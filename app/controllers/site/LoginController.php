<?php

class LoginController extends BaseController {

	use LoginTrait;
	
	/**
	 * Display the login form
	 *
	 * @return Response
	 */
	public function index() {
		if (Auth::check())
			return Redirect::to("/admin");

		$this->layout->content = View::make($this->theme("login"));
	}

	/**
	 * POST the login form
	 *
	 * @return Response
	 */
	public function store() {
		if (Auth::check())
			return Redirect::to("/admin");


		if (! $this->bruteforce())
			Auth::attempt(["user" => Input::get("username"), "password" => Input::get("password")], true);

		if (! Auth::check()) {
			$this->failedLogin();
			Session::put("error", "Invalid Login");
			return Redirect::to("/login");
		}

		//$this->clearFailedLogins();

		return Redirect::to("/admin");
	}
}
