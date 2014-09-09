<?php

trait DjImageTrait {

	// 10MB
	protected $maxImageFileSize = 10485760;
	
	public function getDjImage($id) {
		$dj = Dj::findOrFail($id);
		
		$path = Config::get("radio.paths.dj-images") . "/" . $dj->djimage;
		
		if (! File::exists($path)) {
			$resp = Response::make(File::get(public_path() . "/assets/dj_image.png"), 200);
		} else {
			$resp = Response::make(File::get($path), 200);
		}
		
		// Yes, I know it might be something else, but we don't know and honestly,
		// browsers don't care either.
		$resp->header('Content-type', 'image/png');
		
		return $resp;
	}

	public function putDjImage($id) {
		if (! Auth::check())
				return;

		$dj = Dj::findOrFail($id);
		$user = Auth::user();

		if (($dj->user->id === $user->id) or ($user->isDev())) {
			$image = Input::file("image");
			
			if ($image->getSize() > $this->maxImageFileSize)
				return Response::json(["error" => "file too big"]);

			$image->moveUploadedFile(Config::get("radio.paths.dj-images"), $dj->djimage);
		}
	}

	public function postDjImage($id) {
		if (! Auth::check())
			return;

		$dj = Dj::findOrFail($id);
		$user = Auth::user();

		if (($dj->user->id === $user->id) or ($user->isDev())) {
			$image = Input::file("image");

			if ($image->getSize() > $this->maxImageFileSize)
				return Response::json(["error" => "file too big"]);

			$dj->djimage = $dj->id;
			$image->moveUploadedFile(Config::get("radio.paths.dj-images"), $dj->id);
			$dj->save();
		}
	}

	public function deleteDjImage($id)
	{
		if (! Auth::check())
			return;

		$dj = Dj::findOrFail($id);
		$user = Auth::user();

		if (($dj->user->id === $user->id) or ($user->isDev())) {
			unlink(Config::get("radio.paths.dj-images", "") . "/" . $dj->djimage);
			$dj->djimage = null;
			$dj->save();
		}
	}
}
