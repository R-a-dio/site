<?php

class HomeController extends BaseController {

	// traits (protected functions)
	use PlayerTrait;

	// layout to use. always master unless AJAX.
	protected $layout = 'master';

	/*
	|--------------------------------------------------------------------------
	| Homepage (Index) - GET
	|--------------------------------------------------------------------------
	*/
	public function getException() {
		throw new Exception("test");
	}
	public function getMain() {
		return Redirect::to("//stream.r-a-d.io/main");
	}

	public function getIndex() {
		
		$news = Post::with("author")
			->where("private", "=", 0)
			->orderBy("id", "desc")
			->take(3)
			->get();
		
		$cur_theme = Cookie::get('theme');

		$this->layout->content = View::make($this->theme("home"))
			->with("curqueue", $this->getQueueArray())
			->with("lastplayed", $this->getLastPlayedArray())
			->with("news", $news)
			->with("themes", $this->getThemesArray())
			->with("cur_theme", $cur_theme);

	}


	/*
	|--------------------------------------------------------------------------
	| 404 Method
	|--------------------------------------------------------------------------
	*/
	public function missingMethod($parameters = []) {
		App::abort(404);
	}

}
