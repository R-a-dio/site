<?php

trait ProfileTrait {

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
				$dj->name = $name;
			
			if (Input::hasFile("image")) {
				$image = Input::file("image");
				
				if ($image->getSize() > 10485760)
					return false;

				if (strpos($dj->image, "/") !== false) {
					$path = explode("/", $dj->image);

					do {
						$path[1]++;
					} while (
						file_exists(
							Config::get("radio.paths.dj-images") .
							"{$dj->id}/{$path[1]}"
						)
					);

					$dj->image = "{$dj->id}/{$path[1]}";
				} else {
					if (! file_exists()) {
						mkdir(Config::get("radio.paths.dj-images") . $dj->id);
					}
					$dj->image = "{$dj->id}/1";
				}
				// also visible at https://static.r-a-d.io/dj/<id>/<number> on live
				$image->move(Config::get("radio.paths.dj-images"), $dj->image);

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
