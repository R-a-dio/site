<?php

use GetId3\GetId3Core as ID3;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;

trait AnalysisTrait {
	
	// min
	protected $bitrate = 128.0; // kbps

	// max upload size
	protected $maxSize = 20971520; // 20MB

	// flac max upload size
	protected $maxFlacSize = 94371840; // 90 MB

	// max song length, in seconds
	protected $length = 480.0; // 8 minutes

	// allowed formats
	protected $formats = ["mp3", "flac"];

	// upload delay
	protected $delay = 7200; // 2 hours


	protected function analyze(File $file) {
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

			if ($size > $this->maxSize and $format != "flac")
				$status["error"][] = "Max filesize exceeded (" . $this->maxSize / 1000000 . "MiB)";

			if ($size > $this->maxFlacSize and $format == "flac")
				$status["error"][] = "Max filesize exceeded (" . $this->maxFlacSize / 1000000 . "MiB)";

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

	protected function addPending(UploadedFile $file, Track $repl = null) {

		// hack start

                $filePath = $file->getRealPath();
                $newFile = $filePath . "." . $file->getClientOriginalExtension();
                $name = $file->getClientOriginalName();
                $size = $file->getClientSize();
                rename($filePath, $newFile);

                $file = new File($newFile);

                // hack end


		$status = $this->analyze($file);

		if (count($status["error"])) {
			return ["error" => $status["error"]];
		}

		$uploadTime = $this->checkUploadTime();

		if (time() - $uploadTime < $this->delay) {
			return [
				"error" =>
					"You have to wait " . date("H") . "hour(s), " . date("i") . "min(s) longer until you can upload another song!"
			];
		}

		$new = $status["success"];


		$duplicate = $this->duplicate($new["artist"], $new["title"]);
		$path = $this->getPath($new["format"]);

		// move the file into pending
		$file->move(Config::get("radio.paths.pending"), $path);

		if (Auth::check()) {
			$submitter = Auth::user()->user;
		} else {
			$submitter = Request::server("REMOTE_ADDR");
			DB::insert(
				"insert into `uploadtime` (`ip`, `time`) values (?, NOW()) on duplicate key update `time` = now()",
				[$submitter]
			);
		}


		try {
			Pending::create([
				"artist" => $repl ? $repl->artist : $new["artist"],
				"track" => $repl ? $repl->title : $new["title"],
				"album" => $repl ? $repl->album : $new["album"],
				"path" => $path,
				"origname" => $name,
				"comment" => Input::get("comment"),
				"submitter" => $submitter,
				"dupe_flag" => $repl ? false : $duplicate,
				"replacement" => $repl ? $repl->id : null,
				"bitrate" => $new["bitrate"],
				"length" => $new["length"],
				"format" => $new["format"],
				"mode" => $new["mode"],
			]);
			if ($repl) {
				$repl->need_reupload = 0;
				$repl->save();
			}
		} catch (Exception $e) {
			sentry_log($e);
			return ["exception" => get_class($e), "message" => $e->getMessage()];
		}

		// todo: translation strings
		return ["success" => "File uploaded successfully"];

	}

	protected function checkUploadTime() {

		// logged in users have unlimited uploads.
		if (Auth::check())
			if (Auth::user()->canDoPending())
				return false;

		// people can be given a "daypass" to upload unlimited songs.
		if (Input::get("daypass") === daypass())
			return false;

		// cloudflare + nginx will work this out and pass it in
		$ip = Request::server("REMOTE_ADDR");

		$result = DB::table("uploadtime")
			->select("time")
			->where("ip", "=", $ip)
			->first();

		if ($result)
			return strtotime($result["time"]);

		return false;

	}

	protected function duplicate($artist, $title) {
		$result = DB::table("tracks")
			->where("artist", "=", $artist)
			->where("track", "=", $title)
			->first();

		return (bool) $result;
	}

	protected function getPath($format = "mp3") {
		$real = Config::get("radio.paths.music");
		$pend = Config::get("radio.paths.pending");

		do
		{
			$seed = substr(hash("sha256", uniqid()), 0, 15) . ".$format";
		}
		while (file_exists($real . "/" . $seed) or file_exists($pend . "/" . $seed));

		return $seed;
	}

}
