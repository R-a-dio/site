<?php

use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Eloquent {

	use SoftDeletes;

	protected $table = "radio_comments";
	protected $fillable = ["user_id", "comment", "ip"];

	public function user() {
		return $this->belongsTo("User", "user_id", "id");
	}

}
