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
			Notification::dev("just tried to update privileges " .
				"(privileges: $privileges, username: $username, email: $email, on: $id)", Auth::user());
		} else {
			try {
				$user = User::findOrFail($id);

				if ($password) {
					$user->pass = Hash::make($password);
				}

				if ($privileges) {
					$user->privileges = $privileges;
				}

				$status = "User {$user->user} updated.";
				Notification::admin("updated user {$user->user} ({$user->id})", Auth::user());

				$user->save();
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
			
			updateProfile($user);

			$user->save();

			$status = "Profile Updated";
			Notification::dev("updated their profile", $user);

		} catch (Exception $e) {
			$status = $e->getMessage();
		}

		return Redirect::to("/admin/profile")
			->with("status", $status);

	}
	
	protected function updateProfile($user) {
		// user in this case is either Auth::user() or User::findOrFail()
		
		if(Auth::user()->isAdmin()|| $user->djid) {
			// We can edit if we are an admin or the user already has a profile.
			
			$name = Input::get("djname");
			
			if(!$user->djid) {
				// create a new dj if we don't already have one
				
				if(!$name || $name === "") {
					// But, abort if we didn't have a djid and haven't input any information.
					return;
				}
				
				$dj = Dj::create([
					"djname" => Input::get("djname")
				]);
				$user->djid = $dj->id;
				$user->save();
			}
			else {
				$dj = Dj::find($user->djid);
			}
			
			if($name)
				$dj->djname = $name;
			
			if(Input::hasFile("image")) {
				$image = Input::file("image");
				
				$image->moveUploadedFile(Config::get("radio.paths.dj-images"), $dj->id);
				
				$dj->djimage = $filename;
			}
			
			if(Auth::user()->isAdmin()) {
				// if the editing user is admin, it means they can change
				// visibility and priority as well.
				$visible = Input::get("visible");
				$priority = Input::get($priority);
				if(ctype_digit($priority) && $priority >= 1 && $priority <= 200) {
					// If you want to redo this to use a Validator, be my guest.
					$dj->priority = $priority;
				}
				if($visible === "1" || $visible === "0") {
					// This too!
					$dj->visible = $visible;
				}
			}
			
			$dj->save();
		}
		
	}

}
