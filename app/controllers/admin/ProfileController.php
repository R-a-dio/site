<?php

class ProfileController extends BaseController {

	protected $layout = "admin";

	public function index() {
		$this->layout->content = View::make("admin.profile");
	}

	public function update($id = null) {
		$user = Auth::user();
		$email = Input::get("email");
		$password = Input::get("password");
		$check = Input::get("check");
		$confirm = Input::get("confirm");

		try {
			if ($password) {
				if (Auth::validate(["user" => $user->user, "password" => $check])) {
					if ($password === $confirm) {
						$user->pass = Hash::make($password);
					} else {
						return Redirect::to("/admin/profile")
							->with("status", "Passwords do not match");
					}
					
				} else {
					return Redirect::to("/admin/profile")
						->with("status", "Incorrect password");
				}
			}

			if ($email)
				$user->email = $email;
			
			$check = $this->updateProfile($user);

			$user->save();

			if ($check) {
				$status = "Profile Updated";
			} else {
				$status = "Image file is too big or the database just went kaput.";
			}
		} catch (Exception $e) {
			$status = $e->getMessage();
		}

		return Redirect::to("/admin/profile")
			->with("status", $status);

	}
}
