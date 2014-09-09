<?php

class Track extends Eloquent implements SongInterface {
	
	use SlackTrait;
	use IndexTrait;

	protected $table = "tracks";

	public $timestamps = false;


	protected $guarded = ["id", "hash"];

	public function hash() {
		return sha1(strtolower(trim($this->artist != "" ? "{$this->artist} - {$this->title}" : $this->title)));
	}

	public function setTrackAttribute($value) {
		$this->attributes["track"] = $value;
		$this->hash = $this->hash();
	}

	public function setArtistAttribute($value) {
		$this->attributes["artist"] = $value;
		$this->hash = $this->hash();
	}

	public function setTitleAttribute($value) {
		$this->track = $value;
		$this->hash = $this->hash();
	}

	public function getTitleAttribute() {
		return $this->track;
	}


	public function getLastPlayedAttribute() {
		return $this->lastplayed;
	}

	public function getLastRequestedAttribute() {
		return $this->lastrequested;
	}

	public function setLastEditorAttribute($value) {
		$this->lasteditor = $value;
	}

	public function getLastEditorAttribute() {
		return $this->lasteditor;
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
		return Config::get("radio.paths.music") . "/" . $this->path;
	}

	public function getFileNameAttribute() {
		return $this->artist . " - " . $this->title;
	}

	public function getFileTypeAttribute() {
		if (stripos($this->path, ".flac"))
			return "audio/x-flac";

		return "audio/mpeg";
	}

	public function save(array $options = array()) {

		if (Auth::user()) {
			if (! $this->isDirty("lastrequested"))
				$this->last_editor = Auth::user()->username;

			if ($this->exists) {
				$this->slack("track.update");
			} else {
				$this->slack("pending.accepted");
			}
		}

		parent::save($options);
		$this->index();
	}

	public function delete() {
		$this->slack("track.delete");
		$this->remove();
		parent::delete();
	}
}
