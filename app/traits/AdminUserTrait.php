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
		$email = Input::get("email", "");
		$auth = Auth::user();

		if (!Auth::user()->isAdmin()) {
			Session::flash("status", "I can't let you do that.");
		} else {
			if ($username and $password) {

				try {
					$user = User::create([
						"user" => $username,
						"pass" => Hash::make($password),
						"email" => $email,
						"privileges" => 0,
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
		$email = Input::get("email");

		if (!Auth::user()->isAdmin()) {
			$status = "I can't let you do that.";
		} else {
			try {
				$user = User::findOrFail($id);

				if ($password) {
					$user->pass = Hash::make($password);
				}

				$newPerm = $user->getPermissions();
				foreach ($newPerm as $perm => $hasPerm) {
					$inputPerm = "p_" . $perm;
					if (Input::has($inputPerm)) {
						$newPerm[$perm] = (Input::get($inputPerm, "") === "true");
					}
				}

				$rv = $this->updateProfile($user);
				if ($rv === true) {
					$status = "User {$user->user} updated.";
					$user->privileges = $user->updatePermissions($newPerm);
					$user->save();
				} else {
					$status = ($rv === false) ? "Something broke." : $rv;
				}
			} catch (Exception $e) {
				$status = $e->__toString();
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

			if ($check === true) {
				$status = "Profile Updated";
				$user->save();
			} else {
				$status = ($check === false) ? "Something broke." : $check;
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
					return true;
				}

				$dj = new Dj;
				$dj->djname = $name;
				$dj->djtext = "x";
				$dj->djimage = "";
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
					return "Error: Image file size is too large.";

				$image->move(Config::get("radio.paths.dj-images"), $dj->id);

				$dj->djimage = $dj->id . "-" . substr(sha1(rand()), 0, 8) . ".png";
			}

			if (Auth::user()->isAdmin()) {
				// if the editing user is admin, it means they can change
				// visibility, priority and regex as well.
				$visible = Input::get("visible");
				$priority = Input::get("priority");
				$regex = Input::get("regex");
				if (ctype_digit($priority) and $priority >= 1 and $priority <= 200) {
					// If you want to redo this to use a Validator, be my guest.
					$dj->priority = $priority;
				}
				$dj->visible = (bool)$visible;
				$dj->regex = $regex;
			}

			$ip = Input::get("ipadr");
			if (preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$|^$/', $ip))
			{
				$user->ip = $ip;
			}
			else
			{
				return 'Error: Need a valid IPv4 address (or leave the field empty)';
			}

			return $dj->save();
		}

		return false;
	}

}
