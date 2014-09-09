<?php

trait AdminSongTrait {

	public function getPending() {
		$pending = Pending::all()->sortBy("id", "desc");

		$this->layout->content = View::make("admin.pending")
			->with("pending", $pending);
	}

	public function postPending($id) {
		$pending = Pending::findOrFail($id);
		$action = Input::get("choice");

		switch ($action) {
			case "decline":
				$reason = Input::get("reason", "");
				$pending->decline($reason);
				break;
			case "replace":
				$replace = Input::get("replace");
				$track = Track::find($replace);
				if ($track)
					$pending->replace($track);
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

		if ($track) {
			try {

				$this->sendFile($track, false);

			} catch (Exception $e) {
				return Response::json(["error" => $e->getMessage()]);
			}
			
		}
	}

	protected function sendFile(SongInterface $song, $pending = true) {
		$loc = "radio.paths." . ($pending ? "pending" : "music");
		$path = Config::get($loc) . "/" . $song["path"];
		$size = filesize($path);

		if (stripos($song["path"], ".flac")) {
			$type = "audio/x-flac";
		} else {
			$type = "audio/mpeg";
		}

		$headers = [
			"Cache-Control" => "no-cache",
			"Content-Description" => "File Transfer",
			"Content-Type" => $type,
			"Content-Transfer-Encoding" => "binary",
			"Content-Length" => $size,
			"Content-Disposition" => "attachment; filename=" . $song["path"],
		];

		$response = Response::make('', 200, $headers);

		Session::save();

		// send the file
		$fp = fopen($path, 'rb');

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

		$song->title = Input::get("title", "");
		$song->artist = Input::get("artist", "");
		$song->album = Input::get("album", "");
		$song->tags = Input::get("tags", "");

		$song->save();

		return Redirect::back()
			->with("status", "Song Updated.");


	}

}
