<?php

class Home extends BaseController {

	use Player;
	use Search;

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
		
		$news = DB::table("radio_news")
			->orderBy("id", "desc")
			->whereNull("deleted_at")
			->where("private", "=", 0)
			->take(3)
			->get();

		$this->layout->content = View::make($this->theme("home"))
			->with("curqueue", $this->getQueueArray())
			->with("lastplayed", $this->getLastPlayedArray())
			->with("news", $news);

	}

	public function getIrc() {
		$this->layout->content = View::make($this->theme("irc"));
	}


	public function anySearch($search = false) {

		if (Input::has('q'))
			$search = Input::get("q", false);

		$results = $this->getSearchResults($search);

		$this->layout->content = View::make($this->theme("search"))
			->with("search", $results["search"])
			->with("links", $results["links"])
			->with("param", $search);
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
		

		if ($id) {
			$news = Post::findOrFail($id);
		} else {
			$news = Post::publicPosts()->paginate(15);
		}

		$this->layout->content = View::make($this->theme("news"))
			->with("news", $news)
			->with("id", $id);
	}

	/**
	 * Setup the layout used by the controller, fetch news.
	 *
	 * @return void
	 */
	public function postNews($id) {

		$post = Post::findOrFail($id);

		if (Input::has("comment")) {

			try {
				$comment = new Comment(["comment" => Input::get("comment"), "ip" => Input::server("REMOTE_ADDR")]);

				if (Auth::check()) {
					$comment->user_id = Auth::user()->id;
				}

				$post->comments()->save($comment);

				$status = "Comment posted!";
				$response = ["comment" => $comment->toArray(), "status" => $status];
			} catch (Exception $e) {
				$response = ["error" => $e->getMessage()];
				$status = $e->getMessage();
			}
			

		}

		if (Request::ajax()) {
			return Response::json($response);
		} else {
			return Redirect::to("/news/$id")
				->with("status", $status);
		}

		
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

		return Redirect::to("/admin");
	}

	public function anyLogout() {
		Auth::logout();
		Redirect::to("/");
	}


	public function missingMethod($parameters = []) {
		App::abort(404);
	}

}
