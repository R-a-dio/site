<?php

class Admin extends BaseController {

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
		//$this->beforeFilter('auth');

		// ALL POST/PUT/DELETE REQUIRE CSRF TOKENS.
		$this->beforeFilter('csrf', ['on' => ['post', 'put', 'delete']]);

	}

	public function getIndex() {}
	public function getUsers() {}
	public function getLogin() {}
	public function getLogout() {}
	public function getPending() {}
	public function getSongs() {}
	public function getProfile() {}
	public function getSettings() {}
	public function getNews() {}
	public function getBans() {}
	// /admin/dev-functions
	public function getDevFunctions() {}



	/**
	 * DELETE functions
	 * I am well aware that these dont properly adhere to REST.
	 * TODO (Maybe): fix that.
	 */ 

	// DELETE /admin/users?id={id}?
	public function deleteUsers() {}

	// DELETE /admin/pending?id={id}
	public function deletePending() {}

	// DELETE /admin/bans?id={id}
	public function deleteBans() {}

	// DELETE /admin/news?id={id}
	public function deleteNews() {}

}
