<?php

trait AdminUserTrait {
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
		$auth = Auth::user();

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

				$status = "User {$user->username} created.";
				
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
				$user = User::findOrFail($id);

				if ($password) {
					$user->pass = Hash::make($password);
				}

				if ($privileges) {
					$user->privileges = $privileges;
				}
				
				$this->updateProfile($user);
				$status = "User {$user->user} updated.";
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
				$user->delete();
				$status = "User Deleted.";
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
	
	protected function updateProfile($user) {
		// user in this case is either Auth::user() or User::findOrFail()
		
		if(Auth::user()->isAdmin() or $user->dj) {
			// We can edit if we are an admin or the user already has a profile.
			
			$name = Input::get("djname");
			
			if (! $user->dj) {
				// create a new dj if we don't already have one
				
				if(! $name or $name === "") {
					// But, abort if we didn't have a djid and haven't input any information.
					return;
				}
				
				$dj = Dj::create([
					"djname" => $name,
					"djtext" => "x",
					"djimage" => "x",
				]);
				$dj->save();
				$user->djid = $dj->id;
				$user->save();
			} else {
				$dj = $user->dj;
			}
			
			if ($name)
				$dj->djname = $name;
			
			if (Input::hasFile("image")) {
				$image = Input::file("image");
				
				if ($image->getSize() > 10485760)
					return false;

				$image->move(Config::get("radio.paths.dj-images"), $dj->id);
				
				$dj->djimage = (string) $dj->id;
			}
			
			if (Auth::user()->isAdmin()) {
				// if the editing user is admin, it means they can change
				// visibility and priority as well.
				$visible = Input::get("visible");
				$priority = Input::get("priority");
				if (ctype_digit($priority) and $priority >= 1 and $priority <= 200) {
					// If you want to redo this to use a Validator, be my guest.
					$dj->priority = $priority;
				}
				if ($visible === "1" or $visible === "0") {
					// This too! NB: You can use (bool) $visible for the same effect.
					$dj->visible = $visible;
				}
			}
			
			return $dj->save();
		}

		return false;
		
	}

}
