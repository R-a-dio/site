<?php

use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Eloquent {

	use SoftDeletes;

	protected $table = "radio_news";

	protected $fillable = ["user_id", "title", "header", "text", "private"];

	public function author() {
		return $this->belongsTo("User", "user_id", "id");
	}

	public function comments() {
		return $this->hasMany("Comment", "news_id", "id");
	}

	public function toArray() {
		$array = parent::toArray();

		$array["text"] = Markdown::render($array["text"]);
		$array["header"] = Markdown::render($array["header"]);

		return $array;
	}

}
