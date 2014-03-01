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
				Notification::admin("created user {$user->user} ({$user->id})", Auth::user());
				
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
				Notification::admin("updated user {$user->user} ({$user->id})", Auth::user()); 
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
				$username = $user->id;
				$user->delete();
				$status = "User Deleted.";
				Notification::admin("soft-deleted $username ($id)", Auth::user());
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
		$check = Input::get("check");
		$confirm = Input::get("confirm");

		try {
			if ($password) {
				if (Auth::validate(["user" => $user->user, "password" => $check])) {
					if ($password == $confirm) {
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

			$user->save();

			$status = "Profile Updated";
			Notification::dev("updated their profile", $user);

		} catch (Exception $e) {
			$status = $e->getMessage();
		}

		return Redirect::to("/admin/profile")
			->with("status", $status);

	}

}
