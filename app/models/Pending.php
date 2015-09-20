<?php

class Pending extends Eloquent implements SongInterface {
	
	use SlackTrait;

	protected $table = "pending";
	protected $guarded = ["id"];
	public $timestamps = false;

	public function deleteFile() {
		unlink(Config::get("radio.paths.pending") . "/" . $this->path);
	}

	public function moveFile() {
		rename(Config::get("radio.paths.pending") . "/" . $this->path, Config::get("radio.paths.music") . "/" . $this->path);
	}

	public function getFileSizeAttribute() {
		try {
			$filesize = filesize($this->file_path);
		} catch (Exception $e) {
			$filesize = 0;
		}

		return $filesize;
	}

	public function getFilePathAttribute() {
		return Config::get("radio.paths.pending") . "/" . $this->path;
	}

	public function getTitleAttribute() {
		return $this->track;
	}

	public function getFileNameAttribute() {
		return $this->attributes["origname"];
	}

	public function getFileTypeAttribute() {
		if ($this->format == "flac")
			return "audio/x-flac";

		return "audio/mpeg";
	}

	public function getMetaAttribute() {
		return $this->title ? $this->artist . " - " . $this->title : $this->file_name;
	}

	public function decline($reason) {
		DB::table("postpending")
			->insert([
				"reason" => $reason,
				"ip" => $this->submitter,
				"accepted" => 0,
				"meta" => $this->meta,
			]);

		$this->slack("pending.declined", ["reason" => $reason, "meta" => $this->meta]);
		$this->deleteFile();
		$this->delete();
	}

	public function accept($artist, $title, $album, $tags, $good) {
		try {
			Track::create([
				"track" => $title,
				"artist" => $artist,
				"album" => $album,
				"tags" => $tags,
				"path" => $this->path,
				"accepter" => Auth::user()->username,
			]);

			DB::table("postpending")
				->insert([
					"ip" => $this->submitter,
					"accepted" => 1,
					"meta" => "$artist - $title",
					"good_upload" => $good ? 1 : 0,
				]);

			$this->moveFile();
			$this->delete();
		}  catch (Exception $e) {
			// hash already exists
		}
	}

	public function replace(Track $track, $good) {
		if (is_null($track)) return;
		// add postpending result
		DB::table("postpending")
			->insert([
				"ip" => $this->submitter,
				"accepted" => 2,
				"meta" => $track->artist != "" ? "{$track->artist} - {$track->title}" : $track->title,
				"good_upload" => $good ? 1 : 0,
			]);
		// move the file to the music dir
		$this->moveFile();
		// update the path value
		$track->path = $this->path;
		$track->usable = 0;
		$track->save();
		// delete the pending entry
		$this->delete();
	}

	public function save(array $options = array()) {
		if ($this->exists) {
			//$this->slack("track.update");
		} else {
			$this->slack("pending.uploaded");
		}
		return parent::save($options);
	}

}
