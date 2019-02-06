<?php

trait DjImageTrait {

	// 10MB
	protected $maxImageFileSize = 10485760;

	public function getDjImage($id) {
		if (strpos($id, "-") !== false)
			$id = substr($id, 0, strpos($id, '-'));
		$dj = Dj::findOrFail($id);

		// The image path is always the id.
		$path = Config::get("radio.paths.dj-images") . "/" . $dj->id;

		if (! File::exists($path)) {
			$resp = Response::make(File::get(public_path() . "/assets/dj_image.png"), 200);
		} else {
			$resp = Response::make(File::get($path), 200);
		}

		// Yes, I know it might be something else, but we don't know and honestly,
		// browsers don't care either.
		$resp->header('Content-type', 'image/png');
		$resp->header('Cache-Control', "public, max-age=15555000");

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

			$dj->djimage = $dj->id . "-" . substr(sha1(rand()), 0, 8) . ".png";
			$image->moveUploadedFile(Config::get("radio.paths.dj-images"), $dj->id);
			$dj->save();
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

			// Construct a fake path, consisting of <id>-<random>.png. This
			// is so that we get caching of the image, but bypass the cache
			// in case the image changes.
			$dj->djimage = $dj->id . "-" . substr(sha1(rand()), 0, 8) . ".png";
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
			unlink(Config::get("radio.paths.dj-images", "") . "/" . $dj->id);
			$dj->djimage = null;
			$dj->save();
		}
	}
}
