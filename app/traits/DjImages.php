<?php

trait DjImages {
        public function getDjImage($id)
        {
				// This entire function is a mess. It throws 500 left and right and
				// I have no idea why.
                $dj = Dj::findOrFail($id);
				
				$path = Config::get("radio.paths.dj-images") . "/" . $dj->djimage;
				
                $resp = Response::make(
					File::get($path),
					200
				);
				
				// Yes, I know it might be something else, but we don't know and honestly,
				// browsers don't care either.
				$resp->header(
					'Content-type',
					'image/png'
				);
				
				return $resp;
        }

        public function putDjImage($id)
        {
                if (! Auth::check())
                        return;

                $dj = Dj::findOrFail($id);
                $user = Auth::user();

                if (($dj->user->id === $user->id) or
                        ($user->isDev()))
                {
                        $image = Input::file("image");
                        $image->moveUploadedFile(Config::get("radio.paths.dj-images"), $dj->djimage);
                }
        }

        public function postDjImage($id)
        {
                if (! Auth::check())
                        return;

                $dj = Dj::findOrFail($id);
                $user = Auth::user();

                if (($dj->user->id === $user->id) or
                        ($user->isDev()))
                {
                        $image = Input::file("image");
                        $image->moveUploadedFile(Config::get("radio.paths.dj-images"), $dj->id);

                }
        }

        public function deleteDjImage($id)
        {
                if (! Auth::check())
                        return;

                $dj = Dj::findOrFail($id);
                $user = Auth::user();

                if (($dj->user->id === $user->id) or
                        ($user->isDev()))
                {
                        unlink(Config::get("radio.paths.dj-images", "") . "/" . $dj->djimage);
                        $dj->image = null;
                        $dj->save();
                }
        }
}
