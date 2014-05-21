<?php

class Home extends BaseController {

	// traits (protected functions)
	use Player;
	use Search;
	use Analysis;
	use Requests;
	use SpamCheck;
	use Themes;

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
		$staff = DB::table("djs")
			->where("visible", "=", 1)
			->orderBy("role", "asc")
			->orderBy("priority", "asc")
			->get();

		$this->layout->content = View::make($this->theme("staff"))
			->with("staff", $staff);
	}
	
	public function getFaves($nick = false) {
		if($nick) {
			// select nick, artist, track from enick join efave on inick=enick.id join esong on isong=esong.id left join tracks on esong.hash=tracks.hash where nick= 'Vin';
			$faves = $this->getFavesArray($nick);
			if(Input::has("dl")) {
				$resp = Response::make($faves->get(), 200);
				$resp->header("Content-disposition", "attachment; filename={$nick}_faves.json");
				return $resp;
			}
		}
		else {
			$faves = null;
		}

		if($faves)
			$faves = $faves->paginate(100);
		$this->layout->content = View::make($this->theme("faves"))
			->with("nick", $nick)
			->with("faves", $faves);
	}
	
	public function postFaves($nick = false) {
		if(Input::has('nick')) {
			$nick = Input::get('nick', false);
		}
		
		return Redirect::to("/faves/$nick");
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
	public function getNews($id = false) {
		

		if ($id) {
			$news = Post::with("author")->findOrFail($id);
			if ($news["private"] and !Auth::check())
				App::abort(404);

			$comments = $news->comments->load("user");
		} else {
			$news = Post::with("author");

			if (!Auth::check() or !Auth::user()->canDoPending())
				$news = $news->where("private", "=", 0);

			$news = $news->orderBy("id", "desc")
				->paginate(15);
			$comments = null;
		}

		$this->layout->content = View::make($this->theme("news"))
			->with("news", $news)
			->with("id", $id)
			->with("comments", $comments ? $comments->reverse() : null);
	}

	public function postNews($id) {

		$post = Post::findOrFail($id);

		$check = Comment::withTrashed()
			->where("ip", "=", Input::server("REMOTE_ADDR"))
			->orderBy("created_at", "desc")
			->first();

		if ($check
			and (
					(time() - strtotime($check->created_at) < (60 * 20))
					or
					($check->deleted_at ? time() - strtotime($check->deleted_at) < (60 * 60 * 6) : false)
				)
			and !Auth::check())
		{

			$status = "Slow the hell down, cowboy.";
			$response = ["status" => $status];

		} else {

			if (Input::has("comment")) {

				try {
					if (!Auth::check() and $this->isSpam(Input::get("comment"))) {
						throw new Exception("Go away brohamid.");
					}

					$comment = new Comment(["comment" => Input::get("comment"), "ip" => Input::server("REMOTE_ADDR")]);

					if (Auth::check()) {
						$comment->user_id = Auth::user()->id;
					}

					$post->comments()->save($comment);

					Notification::dev(Input::server("REMOTE_ADDR") . " posted a comment on news post $id");
					$status = "Comment posted!";
					$response = ["comment" => $comment->toArray(), "status" => $status];
				} catch (Exception $e) {
					$response = ["error" => $e->getMessage()];
					$status = $e->getMessage();
				}
				

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
				Notification::dev("deleted a comment on news post $id", Auth::user());
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
		$accepts = DB::table("postpending")
			->where("accepted", ">=", 1)
			->take(20)
			->orderBy("time", "desc")
			->get();

		$declines = DB::table("postpending")
			->where("accepted", "=", 0)
			->where("reason", "!=", "")
			->take(20)
			->orderBy("time", "desc")
			->get();

		$uploadTime = $this->checkUploadTime();
		$cooldown = time() - $uploadTime < $this->delay;

		if ($cooldown) {
			$message = trans("api.upload.cooldown", ["time" => time_ago($uploadTime)]);
		} else {
			$message = trans("api.upload.no-cooldown");
		}

		$this->layout->content = View::make($this->theme("submit"))
			->with("accepts", $accepts)
			->with("declines", $declines)
			->with("message", $message)
			->with("cooldown", $cooldown);
	}

	public function postSubmit() {
		try {
			$file = Input::file("song");

			if ($file)
				$result = $this->addPending($file);
			else
				$result = "You need to add a file.";

			if (Request::ajax())
				return Response::json(["value" => $result]);

			return Redirect::to("/submit")
				->with("status", $result);
		} catch (Exception $e) {
			return Response::json(["value" => ["error" => $e->getTrace(), "success" => $e->getMessage()]]);
		}
	}


	public function getComiket() {
		$this->layout->content = View::make("default.comiket");
	}

	public function postComiket() {
		
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
