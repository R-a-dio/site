<?php

class Admin extends BaseController {

	use SongTrait;
	use SearchTrait;

	/*
	|--------------------------------------------------------------------------
	| Admin Controller - Split this up maybe?
	|--------------------------------------------------------------------------
	|
	| SUPAH SEKRIT
	| Except it's open-sourced. So that means no funky hacks.
	| Brace for an ACTUAL DASHBOARD
	|
	|	// Dashboard
	|	Route::controller('admin', 'AdminController');
	|
	|	MAGIC GOES HERE.
	|
	*/

	protected $layout = "admin";

	/**
	 * Add an auth filter to BaseController.
	 * 
	 * @return $this
	 */
	public function __construct() {
		
		// Auth, naturally.
		$this->beforeFilter('auth');

		parent::__construct();

	}

	/**
	 * Admin panel index page.
	 * 
	 * @return void
	 */
	public function getIndex() {
		$news = Post::with("author")->paginate(15);
		View::share("news", $news);
		$this->layout->content = View::make("admin.dashboard");
	}


	/*
	 |--------------------------------------------------------
	 | Tracks (Full Songs)
	 |--------------------------------------------------------
	 */

	/**
	 * Fetch a song's file from its ID
	 * 
	 * @param $search string
	 * @return File
	 */
	public function getSong($id) {
		$track = Track::findOrFail($id);

		if ($track) {
			try {

				$this->sendFile($track, false);

			} catch (Exception $e) {
				return Response::json(["error" => get_class($e) . ": " . $e->getMessage()]);
			}
			
		}
	}
	
	/**
	 * Search elasticsearch for songs in the admin panel.
	 * 
	 * @param $search string
	 * @return void
	 */
	public function getSongs($search = null) {
		$search = $search ?: Input::get("q", null);

		$results = $this->getSearchResults($search, 20, false);
		

		$this->layout->content = View::make("admin.database")
			->with("search", $search)
			->with("results", $results);
	}

	/**
	 * Update a Track entry (TODO: make PUT?)
	 * 
	 * @param $id int
	 * @return Redirect
	 */
	public function postSongs($id) {
		if ($id == "search") {
			$search = Input::get("q");
			return Redirect::to("/admin/songs/$search");
		}

		$song = Track::findOrFail($id);

		$song->title = Input::get("title", "");
		$song->artist = Input::get("artist", "");
		$song->album = Input::get("album", "");
		$song->tags = Input::get("tags", "");

		$song->save();

		return Redirect::back()
			->with("status", "Song Updated.");


	}

	/*
	 |--------------------------------------------------------
	 | News Posts
	 |--------------------------------------------------------
	 */

	/**
	 * Get all news posts, or a specific one.
	 *   Developers can view deleted posts.
	 *
	 * @param $id int
	 * @return void
	 */
	public function getNews($id = null) {

		if ($id) {
			if (Auth::user()->isDev()) {
				$news = Post::withTrashed()
					->findOrFail($id)
					->load("author");
			} else {
				$news = Post::findOrFail($id)
					->load("author");
			}
		} else {
			if (Auth::user()->isDev()) {
				$news = Post::with("author")
					->withTrashed()
					->orderBy("id", "desc")
					->paginate(15);
			} else {
				$news = Post::with("author")
					->orderBy("id", "desc")
					->paginate(15);
			}
			
		}

		$this->layout->content = View::make("admin.news")
			->with("news", $news)
			->with("id", $id);
	}

	/**
	 * Add a news post.
	 *
	 * @return void
	 */
	public function postNews() {
		$title = Input::get("title");
		$text = Input::get("text");
		$header = Input::get("header");
		$user = Auth::user();
		$private = Input::get("private");

		if (!$user->canPostNews()) {
			return Redirect::to("/admin/news/$id")
				->with("status", "I can't let you do that.");
		} else {
			try {
				$post = Post::create([
					"user_id" => $user->id,
					"title" => $title,
					"text" => $text,
					"header" => $header,
					"private" => $private,
				]);
				
				$status = "News post added.";
			} catch (Exception $e) {
				$status = $e->getMessage();
			}
			
		}

		return Redirect::to("/admin/news")
			->with("status", $status);

	}

	/**
	 * Update an existing news post.
	 *
	 * @param $id int
	 * @return void
	 */
	public function putNews($id) {
		$title = Input::get("title");
		$text = Input::get("text");
		$header = Input::get("header");
		$private = Input::get("private");
		$user = Auth::user();

		if (!Auth::user()->canPostNews()) {
			return Redirect::to("/admin/news/$id")
				->with("status", "I can't let you do that.");
		} else {
			try {
				$post = Post::findOrFail($id);

				$post->title = $title;
				$post->header = $header;
				$post->text = $text;
				$post->private = $private;

				$post->save();

				$status = "News post $id updated.";
				
			} catch (Exception $e) {
				$status = $e->getMessage();
			}
			
		}

		return Redirect::to("/admin/news/$id")
			->with("status", $status);

	}

	/**
	 * Soft-delete a news post.
	 *   They're never properly deleted.
	 *
	 * @param $id int
	 * @return void
	 */
	public function deleteNews($id) {
		$user = Auth::user();
		$status = "Nope.";
		if ($user->isAdmin()) {
			try {
				$post = Post::findOrFail($id);
				$title = $post->title;
				$post->delete();
				$status = "Post Deleted.";
				
			} catch (Exception $e) {
				$status = $e->getMessage();
			}
		}

		return Redirect::to("/admin/news")
			->with("status", $status);
	}



	/*
	 |--------------------------------------------------------
	 | Misc
	 |--------------------------------------------------------
	 */

	/**
	 * Misc developer items.
	 * 
	 * @return void
	 */
	public function getDev() {
		if (! Auth::user()->isDev())
			return Redirect::to("/admin");
		
		$this->layout->content = View::make("admin.dev")
			->with("failed_logins", DB::table("failed_logins")->get())
			->with("environment", App::environment());
	}

	/**
	 * Restore a soft-deleted item as a developer.
	 * 
	 * @param $type string
	 * @param $id int
	 * @return void
	 */
	public function getRestore($type, $id) {
		if (! Auth::user()->isDev())
			return Redirect::to("/admin");

		if ($type == "news") {
			$news = News::withTrashed()->find($id);
			$news->restore();
		}
	}

	/**
	 * 404 when there's no method to handle anything.
	 * 
	 * @param $parameters array: anything in the url
	 * @return void
	 */
	public function missingMethod($parameters = []) {
		App::abort(404);
	}

	/**
	 * Setup the layout used by the controller.
	 * Also adds a few required variables.
	 *
	 * @return void
	 */
	protected function setupLayout() {
		if ( ! is_null($this->layout)) {
			$this->layout = View::make($this->layout);
		}
	}

}
