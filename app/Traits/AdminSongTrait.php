<?php

trait AdminSongTrait {

	public function getPending() {
		$pending = Pending::all();

		$this->layout->content = View::make("admin.pending")
			->with("pending", $pending);
	}

	public function postPending($id) {
		$pending = Pending::findOrFail($id);
		$action = Input::get("choice");

		if (!Auth::user()->canEditPending())
			return Redirect::to("/admin/pending");

		switch ($action) {
			case "decline":
				$reason = Input::get("reason", "");
				if ($pending->replacement) {
					$track = Track::find($pending->replacement);
					if ($track) {
						$track->need_reupload = 1;
						$track->save();
					}
				}
				$pending->decline($reason);
				break;
			case "replace":
				$replace = Input::get("replace");
				$good = Input::get("good");
				$track = Track::find($replace);
				if ($track) {
					if ($pending->replacement) {
						$track->need_reupload = 0;
						$track->save();
					}
					$pending->replace($track, $good);
				}
				break;
			case "accept":
				$artist = Input::get("artist", "");
				$title = Input::get("title", null);
				$album = Input::get("album", "");
				$tags = Input::get("tags", "");
				$good = Input::get("good");

				// title is required.
				if ($title)
					$pending->accept($artist, $title, $album, $tags, $good);
				
				break;
			default:
				break;
		}

		if (Request::ajax())
			return Response::json(["status" => ! $pending->exists]); // means it was deleted
		else
			return Redirect::to("/admin/pending");
	}

	public function getPendingSong($id) {
		$pending = Pending::findOrFail($id);

		if (!Auth::user()->canViewPending())
			return;

		try {
			$this->sendFile($pending);

		} catch (Exception $e) {
			return Response::json([
				"error" => $e->getMessage(),
				"trace" => $e->getTraceAsString(),
				"line"  => $e->getLine(),
				"file"  => $e->getFile(),
			]);
		}

	}

	public function getSong($id) {
		$track = Track::findOrFail($id);

		if (!Auth::user()->canViewDatabase())
			return;

		if ($track) {
			try {
				$this->sendFile($track, false);

			} catch (Exception $e) {
				return Response::json(["error" => $e->getMessage()]);
			}
		}
	}

	protected function sendFile(SongInterface $song) {

		$headers = [
			"Cache-Control" => "no-cache",
			"Content-Description" => "File Transfer",
			"Content-Type" => $song->file_type,
			"Content-Transfer-Encoding" => "binary",
			"Content-Length" => $song->file_size,
			"Content-Disposition" => "attachment; filename=\"" . $song->file_name . "\"",
		];

		$response = Response::make('', 200, $headers);

		Session::save();

		// send the file
		$fp = fopen($song->file_path, 'rb');

		if ($fp) {
			// fire headers and clean the output buffer
			ob_end_clean();
			$response->sendHeaders();
			fpassthru($fp);
		}

		exit;
	}

	public function getSongs($search = null) {
		$search = $search ?: Input::get("q", null);

		if (!Auth::user()->canViewDatabase())
			return Redirect::to("/admin");

		$results = $this->getSearchResults($search, 20, false);

		$this->layout->content = View::make("admin.database")
			->with("search", $search)
			->with("results", $results);
	}

	public function postSongs($id) {
		if ($id == "search") {
			$search = Input::get("q");
			return Redirect::to("/admin/songs/$search");
		}

		$song = Track::findOrFail($id);

		if(Input::get("action", "") === "delete") {
			if (!Auth::user()->canDeleteDatabase())
				return Redirect::back()
					->with("status", "Missing permissions.");
			// remove search index first
			$this->remove($song);
			// remove file
			File::delete($song->getFilePathAttribute());
			// remove entry
			$song->delete();
			return Redirect::back()
				->with("status", "Song Deleted.");
		}

		if (!Auth::user()->canEditDatabase())
			return Redirect::back()
				->with("status", "Missing permissions.");

		$song->title = Input::get("title", "");
		$song->artist = Input::get("artist", "");
		$song->album = Input::get("album", "");
		$song->tags = Input::get("tags", "");
		$song->need_reupload = Input::get("need_reupload") === "1" ? 1 : 0;

		$song->save();

		return Redirect::back()
			->with("status", "Song Updated.");


	}

}
