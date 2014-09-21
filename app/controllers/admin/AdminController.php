<?php

class AdminController extends BaseController {

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


	/**
	 * 404 when there's no method to handle anything.
	 * 
	 * @param $parameters array: anything in the url
	 * @return void
	 */
	public function missingMethod($parameters = []) {
		App::abort(404);
	}

}
