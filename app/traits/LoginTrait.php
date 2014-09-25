<?php

trait LoginTrait {
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
