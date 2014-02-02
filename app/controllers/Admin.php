<?php

class Admin extends BaseController {

	use AdminUser;
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

	public function __construct() {
		
		// Auth, naturally.
		$this->beforeFilter('auth');

		// ALL POST/PUT/DELETE REQUIRE CSRF TOKENS.
		$this->beforeFilter('csrf', ['on' => ['post', 'put', 'delete']]);

	}
	protected $layout = "admin";

	public function getIndex() {
		$news = DB::table("radio_news")
			->orderBy("id", "desc")
			->take(15)
			->get();
		View::share("news", $news);
		$this->layout->content = View::make('admin.dashboard');
	}





	
	public function getLogin() {
		$this->layout->content = View::make('admin.login');
	}
	public function getLogout() {}
	public function getPending() {}
	public function getSongs() {}
	public function getProfile() {}
	public function getSettings() {}
	public function getNews() {}
	public function getBans() {}
	
	// /admin/dev-functions
	public function getDevFunctions() {}

	public function deletePending($id = null) {}

	public function deleteBans($id = null) {}

	public function deleteNews($id = null) {}


	



	// PUT (update)

}
