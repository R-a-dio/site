<?php

class HomeController extends BaseController {

	use PlayerTrait;

	public function index() {
		
		$news = Post::with("author")
			->where("private", "=", 0)
			->orderBy("id", "desc")
			->take(5) // the theme sets the number but the max is 5
			->get();
		
		$theme = Cookie::get('theme');

		$this->layout->content = View::make($this->theme("home"))
			->with("curqueue", $this->getQueueArray())
			->with("lastplayed", $this->getLastPlayedArray())
			->with("news", $news)
			->with("themes", $this->getThemesArray())
			->with("theme", $theme);

	}
}
