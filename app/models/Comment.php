<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Comment extends Eloquent {

	use SoftDeletingTrait;

	protected $table = "radio_comments";
	protected $fillable = ["user_id", "comment", "ip"];

	public function user() {
		return $this->belongsTo("User", "user_id", "id");
	}

}
