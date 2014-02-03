<?php

class Comment extends Eloquent {

	protected $table = "radio_comments";
	protected $softDelete = true;
	protected $fillable = ["user_id", "comment", "ip"];

	public function user() {
		return $this->belongsTo("User", "user_id", "id");
	}

	public function author() {
		if ($this->user_id) {
			// lolwat
			return "<span class=\"text-danger\">Anonymous ## Mod <i class=\"fa fa-star\"></i></span>";
		} else {
			return "Anonymous";
		}
	}

}
