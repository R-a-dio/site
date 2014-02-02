<?php

class Admin extends BaseController {

	use AdminUser;
	use AdminNews;
	
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

		// ALL POST/PUT/DELETE REQUIRE CSRF TOKENS.
		$this->beforeFilter('csrf', ['on' => ['post', 'put', 'delete']]);

	}

	public function getIndex() {
		$news = DB::table("radio_news")
			->orderBy("id", "desc")
			->take(15)
			->get();
		View::share("news", $news);
		$this->layout->content = View::make('admin.dashboard');
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
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			View::share("notifications", Notification::fetch(Auth::user()));
			$this->layout = View::make($this->layout);
		}
	}

}
