<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Post extends Eloquent {

	use SoftDeletingTrait;

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


	public function save(array $options = array()) {
		if ($this->id) {
			$this->slack("news.edit");
		} else {
			$this->slack("news.add");
		}
		parent::save($options);
		$this->index();
	}

	public function delete() {
		$this->slack("track.delete");
		parent::delete();
	}
}
