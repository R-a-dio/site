<?php

class Track extends Eloquent implements SongInterface {
	
	use SlackTrait;
	use IndexTrait;

	protected $table = "tracks";
	protected $dates = ["last_played", "last_requested"];

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
		return $this->attributes["track"];
	}


	public function getLastPlayedAttribute() {
		return $this->attributes["lastplayed"];
	}

	public function getLastRequestedAttribute() {
		return $this->attributes["lastrequested"];
	}

	public function setLastEditorAttribute($value) {
		$this->attributes["lasteditor"] = $value;
	}

	public function getLastEditorAttribute() {
		return $this->attributes["lasteditor"];
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
		return Config::get("radio.paths.music") . "/" . $this->attributes["path"];
	}

	public function getFileNameAttribute() {
		return $this->attributes["artist"] . " - " . $this->attributes["track"];
	}

	public function getFileTypeAttribute() {
		if (stripos($this->attributes["path"], ".flac"))
			return "audio/x-flac";

		return "audio/mpeg";
	}

	public function save(array $options = array()) {

		if (Auth::user()) {
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
