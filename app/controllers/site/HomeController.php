<?php

class Home extends BaseController {

	// traits (protected functions)
	use PlayerTrait;
	use AnalysisTrait;
	use RequestTrait;
	use SpamCheckTrait;
	use ThemeTrait;

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
	| Stats (Queue, LP, etc.) - GET
	|--------------------------------------------------------------------------
	*/
	public function getQueue() {
		$this->layout->content = View::make($this->theme("queue"))
			->with("queue", $this->getQueuePagination()->get());
	}

	public function getLastPlayed() {
		$this->layout->content = View::make($this->theme("lastplayed"))
			->with("lastplayed", $this->getLastPlayedPagination()->paginate(20));
	}

	public function getStaff() {
		$staff = Dj::where("visible", "=", 1)
			->orderBy("role", "asc")
			->orderBy("priority", "asc")
			->get();

		$this->layout->content = View::make($this->theme("staff"))
			->with("staff", $staff);
	}


	/*
	|--------------------------------------------------------------------------
	| IRC - GET
	|--------------------------------------------------------------------------
	*/
	public function getIrc() {
		$this->layout->content = View::make($this->theme("irc"));
	}


	/*
	|--------------------------------------------------------------------------
	| Search Page - GET, POST
	|--------------------------------------------------------------------------
	*/
	public function anySearch($search = false) {

		if (Input::has('q'))
			$search = Input::get("q", false);

		$results = $this->getSearchResults($search);

		$this->layout->content = View::make($this->theme("search"))
			->with("results", $results)
			->with("param", $search);
	}


	/*
	|--------------------------------------------------------------------------
	| News Page - GET, POST|PUT|DELETE (comments)
	|--------------------------------------------------------------------------
	*/
	



	/*
	|--------------------------------------------------------------------------
	| 404 Method
	|--------------------------------------------------------------------------
	*/
	public function missingMethod($parameters = []) {
		App::abort(404);
	}

}
