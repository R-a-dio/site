<?php

class Admin extends BaseController {

	use AdminUser;
	use AdminNews;
	use AdminSongs;
	use AdminSearch;
	use Player;
	use Search;

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

	public function __construct() {
		
		// Auth, naturally.
		$this->beforeFilter('auth');

		parent::__construct();

	}

	public function getIndex() {
		$news = Post::with("author")->paginate(15);
		View::share("news", $news);
		$this->layout->content = View::make("admin.dashboard");
	}

	public function getNotifications() {
		$notifications = Notification::grab(Auth::user())
			->paginate(20);

		$this->layout->content = View::make("admin.notifications")
			->with("notifications", $notifications);
	}

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
			$pending = DB::table("pending")
				->select(DB::raw("count(*) as count"))
				->first()["count"];
			$events = Notification::count(Auth::user());
			View::share("notifications", [
				"errors" => "",
				"pending" => $pending,
				"events" => $events,
			]);
			$this->layout = View::make($this->layout);
		}
	}

}
