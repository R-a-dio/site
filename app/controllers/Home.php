<?php

class Home extends BaseController {

	use Player;
	use Search;
	use News;

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| Default Home Controller.
	| Passes in default variables since they are otherwise not available
	| in an @section() block.
	|
	|	Route::get('/', 'HomeController@showHome');
	|
	*/

	protected $layout = 'master';


	/**
	 * Show the homepage (and throw in a load of variables)
	 *
	 * @return void
	 */
	public function getIndex() {
		
		$this->layout->content = View::make($this->theme("home"))
			->with("curqueue", $this->getQueueArray())
			->with("lastplayed", $this->getLastPlayedArray());

	}

	public function getIrc() {
		$this->layout->content = View::make($this->theme("irc"));
	}


	public function anySearch($search = false) {

		if (Input::has('q'))
			$search = Input::get("q", false);

		$this->layout->content = View::make($this->theme("search"))
			->with("search", $this->getSearchResults($search));
	}

	public function getStaff() {
		$staff = DB::table("djs")
			->where("visible", "=", 1)
			->orderBy("role", "asc")
			->orderBy("priority", "asc")
			->get();

		$this->layout->content = View::make($this->theme("staff"))
			->with("staff", $staff);
	}

	/**
	 * Setup the layout used by the controller, fetch news.
	 *
	 * @return void
	 */
	public function getNews($id = false) {
		$news = DB::table("news");

		if (!$id) {
			$news = $news->select("header", "id")->get();
		} else {
			$news = $news->where("id", "=", $id)->first();
		}

		$this->layout->content = View::make($this->theme("news"))
			->with("news", $news)
			->with("id", $id);
	}


	public function getLogin() {
		$this->layout->content = View::make($this->theme("login"));
	}

	public function postLogin() {
		Auth::attempt(["user" => Input::get("username"), "password" => Input::get("password")], true);

		if (!Auth::check()) {
			Session::put("error", "Invalid Login");
			return Redirect::to("/login");
		}

		return Redirect::to("/");
	}

	public function anyLogout() {
		Auth::logout();
		Redirect::to("/");
	}


	public function missingMethod($parameters = []) {
		App::abort(404);
	}

}
