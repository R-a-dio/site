<?php

class Track extends Eloquent {
	
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
