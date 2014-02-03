<?php

class Comment extends Eloquent {

	protected $table = "radio_comments";
	protected $softDelete = true;
	protected $fillable = ["user_id", "comment"];

	public function author() {
		if ($this->user_id) {
			$user = User::find($this->user_id);

			return $user->user;
		} else {
			return "Anonymous";
		}
	}

}
