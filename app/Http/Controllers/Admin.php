<?php

class Admin extends BaseController {

	use AdminUserTrait;
	use AdminNewsTrait;
	use AdminSongTrait;

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
		$this->middleware('auth');

		parent::__construct();

	}

	public function getIndex() {
		$news = Post::with("author")->paginate(15);
		View::share("news", $news);
		$this->layout->content = View::make("admin.dashboard");
	}

	public function getDev() {
		if (! Auth::user()->isDev())
			return Redirect::to("/admin");
		
		$this->layout->content = View::make("admin.dev")
			->with("failed_logins", DB::table("failed_logins")->get())
			->with("environment", App::environment());
	}

	public function getRestore($type, $id) {
		if (! Auth::user()->isDev())
			return Redirect::to("/admin");

		if ($type == "news") {
			$news = News::withTrashed()->find($id);
			$news->restore();
		}
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
			$this->layout = View::make($this->layout);
		}
	}

}
