<?php

class LoginController extends BaseController {

	public function getIndex() {
		if (Auth::check())
			return Redirect::to("/admin");

		$this->layout->content = View::make($this->theme("login"));
	}

	public function postIndex() {
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

	protected function bruteforce() {
		$ip = Input::server("REMOTE_ADDR");

		$fails = DB::table("failed_logins")
			->where("ip", "=", $ip)
			->get();

		return count($fails) > 15;
	}

	protected function failedLogin() {
		DB::table("failed_logins")
			->insert([
				"ip" => Input::server("REMOTE_ADDR"),
				"user" => Input::get("username", ""),
				"password" => hash("sha256", Input::get("password")),
			]);
	}

	protected function clearFailedLogins($ip = null) {
		DB::table("failed_logins")
			->where("ip", "=", $ip ?: Input::server("REMOTE_ADDR"))
			->delete();
	}	
}
