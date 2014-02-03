<?php

trait AdminUser {
	// =======================
	// USERS
	// =======================

	public function getUsers($id = null) {

		if (!Auth::user()->isAdmin()) {
			return Redirect::to("/admin");
		}
		if (!$id)
			$user = User::all();
		else
			$user = User::findOrFail($id);

		$this->layout->content = View::make("admin.users")
			->with("users", $user)
			->with("id", $id);
	}

	public function postUsers($id = null) {
		$username = Input::get("username");
		$password = Input::get("password");
		$privileges = Input::get("privileges");
		$email = Input::get("email");

		if (!Auth::user()->isAdmin() or ($privileges >= 5)) {
			Session::flash("status", "I can't let you do that.");
		} else {
			if ($username and $password and $privileges) {

				try {
					$user = User::create([
						"user" => $username,
						"pass" => Hash::make($password),
						"email" => $email,
						"privileges" => $privileges,
					]);
				} catch (Exception $e) {
					$status = $e->getMessage();
				}

				$status = "User {$user->user} created.";
				Notification::admin(Auth::user()->user . " just created a user: {$user->user}");
				
			} else {
				$status = "Missing username, password or permissions";
			}
		}

		return Redirect::to("/admin/users")
			->with("status", $status);

	}

	public function putUsers($id) {
		$username = Input::get("username");
		$password = Input::get("password");
		$privileges = Input::get("privileges");
		$email = Input::get("email");

		if (!Auth::user()->isAdmin() or ($privileges >= 5)) {
			Session::flash("status", "I can't let you do that.");
		} else {
			try {
				$user = User::find($id);
				
				if ($username != $user->user) {
					$user->user = $username;
				}

				if ($password) {
					$user->pass = Hash::make($password);
				}

				if ($privileges) {
					$user->privileges = $privileges;
				}

				$user->save();

				$status = "User {$user->user} updated.";
				Notification::admin(Auth::user()->user . " just updated a user: {$user->user}"); 
			} catch (Exception $e) {
				$status = $e->getMessage();
			}
			
		}

		return Redirect::to("/admin/users")
			->with("status", $status);

	}

	public function deleteUsers($id) {
		if (Auth::user()->isAdmin()) {
			try {
				$user = User::find($id);
				$user->delete();
				$status = "User Deleted.";
				Notification::admin(Auth::user()->user . " just soft-deleted user $id");
			} catch (Exception $e) {
				$status = $e->getMessage();
			}
		}

		return Redirect::to("/admin/users")
			->with("status", $status);
	}

	public function getProfile() {
		$this->layout->content = View::make("admin.profile");
	}


	public function putProfile() {
		$user = Auth::user();
		$email = Input::get("email");
		$password = Input::get("password");
		$check = Input::get("current");
		$confirm = Input::get("confirm");

		try {
			if ($password) {
				if (Auth::validate(["user" => $user->user, "password" => $check])) {
					if ($password == $confirm) {
						$user->password = Hash::make($password);
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

			$user->save();

			$status = "Profile Updated";

		} catch (Exception $e) {
			$status = $e->getMessage();
		}

		return Redirect::to("/admin/profile")
			->with("status", $status);

	}

}
