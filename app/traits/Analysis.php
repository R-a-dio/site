<?php

use GetId3\GetId3Core as ID3;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait Analysis {
	
	// min
	protected $bitrate = 128.0; // kbps

	// max upload size
	protected $maxSize = 20000000; // 18MiB

	// max song length, in seconds
	protected $length = 480.0; // 8 minutes

	// allowed formats
	protected $formats = ["mp3"];

	// upload delay
	protected $delay = 7200; // 2 hours


	protected function analyze(UploadedFile $file) {
		$size = $file->getSize();

		$status = ["error" => [], "success" => []];

		$analyzer = new ID3();
		$analyzer->setEncoding("UTF-8");

		$result = $analyzer->analyze($file->getRealPath());

		if (@$result["error"]) {
			$status["error"][] = $result["error"];
		} else {

			// song length in seconds (float)
			$length = @$result["playtime_seconds"];

			// exact bitrate, in float format (kbps)
			$bitrate = @$result["audio"]["bitrate"];

			// cbr, vbr, etc
			$mode = @$result["audio"]["bitrate_mode"];

			// sample rate, in Hz (int)
			$sampleRate = @$result["audio"]["sample_rate"];

			// "mp3" or "ogg" etc.
			$format = @$result["fileformat"];

			// UTF-8, etc
			$encoding = @$result["encoding"];


			$tags = (isset($result["tags"]) and is_array($result["tags"])) ? current($result["tags"]) : null;

			if ($tags) {
				$title = isset($tags["title"]) ? end($tags["title"]) : null;
				$album = isset($tags["album"]) ? current($tags["album"]) : null;
				$artist = isset($tags["artist"]) ? current($tags["artist"]) : null;
			} else {
				// no tags
				$title = "";
				$album = "";
				$artist = "";
			}

			if (! in_array($format, $this->formats))
				$status["error"][] = "$format is not allowed.";

			if ($bitrate < ($this->bitrate * 1000))
				$status["error"][] = "Bitrate is too low (" . $bitrate / 1000 . "kbps)";

			if ($length > $this->length)
				$status["error"][] = "The song is too long (>{$this->length} seconds)";

			if ($size > $this->maxSize)
				$status["error"][] = "Max filesize exceeded (" . $this->maxSize / 1000000 . "MiB)";

			if ($format == "mp3" and $bitrate > 325000)
				$status["error"][] = "The MP3 file is over 320kbps. MP3 is useless above that.";


			if (! count($status["error"]))
				$status["success"] = [
					"length" => $length,
					"bitrate" => $bitrate,
					"mode" => $mode,
					"format" => $format,
					"title" => $title ?: "",
					"artist" => $artist ?: "",
					"album" => $album ?: "",
					"encoding" => $encoding,
				];

		}

		return $status;

	}

	protected function addPending(UploadedFile $file) {
		$status = $this->analyze($file);

		if (count($status["error"])) {
			return $status["error"];
		}

		if (!$this->checkUploadTime()) {
			return "You have to wait longer until you can upload another song!";
		}

		$new = $status["success"];


		$duplicate = $this->duplicate($new["artist"], $new["title"]);
		$path = $this->getPath();

		// move the file into pending
		$file->move(Config::get("radio.paths.pending"), $path);

		$submitter = Auth::check() ? Auth::user()->user : Input::server("REMOTE_ADDR");

		DB::table("pending")
			->insert([
				"artist" => $new["artist"],
				"track" => $new["title"],
				"album" => $new["album"],
				"origname" => $file->getClientOriginalName(),
				"comment" => Input::get("comment"),
				"submitter" => $submitter,
				"dupe_flag" => $duplicate,
				"replacement" => 0,
			]);

		// todo: translation strings
		return "File uploaded successfully";

	}

	protected function checkUploadTime() {

		// logged in users have unlimited uploads.
		if (Auth::check() and Auth::user()->canDoPending())
			return true;

		// people can be given a "daypass" to upload unlimited songs.
		if (Input::get("daypass") === $this->daypass())
			return true;

		// cloudflare + nginx will work this out and pass it in
		$ip = Input::server("REMOTE_ADDR");

		$result = DB::table("uploadtime")
			->select("time")
			->where("ip", "=", $ip);

		if ($result and strtotime($result["time"]) - time() > $this->delay)
			return false;

		DB::insert("insert into `uploadtime` (`ip`, `time`) values (?, NOW()) on duplicate key update", [$ip]);

		return true;

	}

	// daypass~
	protected function daypass() {
		// default daypass is "testingYYYY-MM-DD" sha256'd and truncated.
		$raw = Config::get("radio.daypass", "testing") . date("Y-m-d");

		$hash = base64_encode(hash("sha256", $raw));

		return substr($hash, 0, 16);
	}

	protected function duplicate($artist, $title) {
		$result = DB::table("tracks")
			->where("artist", "=", $artist)
			->where("title", "=", $title);

		return (bool) $result;
	}

	protected function getPath($format = "mp3") {
		$real = Config::get("radio.paths.music");
		$pend = Config::get("radio.paths.pending");

		do
		{
			$seed = substr(hash("sha256", uniqid()), 0, 15) . ".$format";
		}
		while (file_exists($real . $seed) or file_exists($pend . $seed));

		return $seed;
	}

}
