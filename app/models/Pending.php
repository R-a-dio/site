<?php

class Pending extends Eloquent {
	
	use SlackTrait;

	protected $table = "pending";
	protected $timestamps = false;

	public function deleteFile() {
		unlink(Config::get("radio.paths.pending") . "/" . $this->path);
	}

	public function moveFile() {
		rename(Config::get("radio.paths.pending") . "/" . $this->path, Config::get("radio.paths.music") . "/" . $this->path);
	}

	public function getFilesizeAttribute() {
		try {
			$filesize = filesize(Config::get("radio.paths.pending") . "/" . $p["path"]);
		} catch (Exception $e) {
			$filesize = "N/A";
		}

		return $filesize;
	}

	public function getTitleAttribute() {
		return $this->track;
	}

	public function getFilenameAttribute() {
		return $this->origname;
	}

	public function getMetaAttribute() {
		return $this->title ? $this->artist . " - " . $this->title : $this->original;
	}

	public function decline($reason) {
		DB::table("postpending")
			->insert([
				"reason" => $reason,
				"ip" => $this->submitter,
				"accepted" => 0,
				"meta" => $this->meta,
			]);

		$this->slack("pending.declined", ["reason" => $reason]);
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

	public function save(array $options = array()) {
		if ($this->id) {
			//$this->slack("track.update");
		} else {
			$this->slack("pending.uploaded");
		}
		return parent::save($options);
	}

}
