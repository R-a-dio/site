<?php

class Home extends BaseController {

	// traits (protected functions)
	use Player;
	use Search;
	use Analysis;

	// layout to use. always master unless AJAX.
	protected $layout = 'master';

	/*
	|--------------------------------------------------------------------------
	| Homepage (Index) - GET
	|--------------------------------------------------------------------------
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

	/*
	|--------------------------------------------------------------------------
	| Stats (Queue, LP, etc.) - GET
	|--------------------------------------------------------------------------
	*/
	public function getQueue() {
		$this->layout->content = View::make($this->theme("queue"))
			->with("queue", $this->getQueuePagination()->paginate(20));
	}

	public function getLastPlayed() {
		$this->layout->content = View::make($this->theme("lastplayed"))
			->with("lastplayed", $this->getLastPlayedPagination()->paginate(20));
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
			->with("search", $results["search"])
			->with("links", $results["links"])
			->with("param", $search);
	}


	/*
	|--------------------------------------------------------------------------
	| News Page - GET, POST|PUT|DELETE (comments)
	|--------------------------------------------------------------------------
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

	/**
	 * Setup the layout used by the controller, fetch news.
	 *
	 * @return void
	 */
	public function deleteNews($id) {

		if (!Auth::check() and !Auth::user()->isAdmin())
			return Redirect::to("/news/$id");

		$post = Post::findOrFail($id);
		$comment = Input::get("comment");

		if ($comment and is_numeric($comment)) {

			try {
				$comment = Comment::find($comment);

				$comment->delete();

				$status = "Comment Deleted!";
				$response = ["status" => $status];
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


	/*
	|--------------------------------------------------------------------------
	| Login Pages (and logout) - GET, POST
	|--------------------------------------------------------------------------
	*/
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

	/*
	|--------------------------------------------------------------------------
	| Submit Song Page - GET, POST
	|--------------------------------------------------------------------------
	*/
	public function getSubmit() {
		$this->layout->content = View::make($this->theme("submit"));
	}

	public function postSubmit() {
		$file = Input::file("song");
		$result = $this->addPending($file);

		return Redirect::to("/submit")
			->with("status", $result);
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
