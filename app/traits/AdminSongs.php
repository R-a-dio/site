<?php

trait AdminSongs {

	public function getPending() {
		$pending = DB::table("pending")
			->orderBy("id", "asc")
			->get();

		foreach($pending as &$p) {
			try {
				$filesize = filesize(Config::get("radio.paths.pending") . "/" . $p["path"]);
			} catch (Exception $e) {
				$filesize = "N/A";
			}
			$p["filesize"] = $filesize;
		}
		$this->layout->content = View::make("admin.pending")
			->with("pending", $pending);
	}

	public function postPending($id) {
		$pending = DB::table("pending")
			->where("id", "=", $id)
			->first();

		$delete = false;

		$action = Input::get("choice");

		if ($pending) {
			switch ($action) {
				case "decline":
					$reason = Input::get("reason", "");
					$meta = $pending["track"] ? $pending["artist"] . " - " . $pending["track"] : $pending["origname"];
					DB::table("postpending")
						->insert([
							"reason" => $reason,
							"ip" => $pending["submitter"],
							"accepted" => 0,
							"meta" => $meta,
						]);

					try {
						unlink(Config::get("radio.paths.pending") . "/" . $pending["path"]);
					} catch (Exception $e) {
						return Response::json(["error" => $e->getMessage()]);
					}
					
					$delete = true;
					Notification::pending("declined $meta ($reason)", Auth::user());
					break;
				case "replace":
					$replace = Input::get("replace");
					$check = DB::table("tracks")
						->where("id", "=", $replace)
						->first();
					if ($check) {
						DB::table("tracks")
							->where("id", "=", $check["id"])
							->update([
								"usable" => 0,
								"lasteditor" => Auth::user()->user,
							]);
						$delete = true;

						// fetch it again
						$new = DB::table("tracks")
							->where("id", "=", $replace)
							->first();

						// index for search
						$this->index($new);
						try {
							rename(Config::get("radio.paths.pending") . "/" . $pending["path"], Config::get("radio.paths.music") . $check["path"]);
						} catch (Exception $e) {
							return Response::json(["error" => $e->getMessage()]);
						}
					}
					Notification::pending("replaced song {$check["id"]}", Auth::user());
					break;
				case "accept":
					$editor = Auth::user()->user;
					$artist = Input::get("artist", "");
					$title = Input::get("title", null);
					$album = Input::get("album", "");
					$tags = Input::get("tags", "");
					$hash = sha1(strtolower(trim($artist != "" ? "$artist - $title" : $title)));
					$good = Input::get("good");

					// title is required.
					if ($title) {
						$delete = true;

						try {
							$id = DB::table("tracks")
								->insertGetId([
									"track" => $title,
									"artist" => $artist,
									"album" => $album,
									"tags" => $tags,
									"path" => $pending["path"],
									"usable" => 0,
									"accepter" => $editor,
									"lasteditor" => $editor,
									"hash" => $hash,
								]);

							} catch (Exception $e) {
								$delete = false;
								break;
							}
						

						DB::table("postpending")
							->insert([
								"ip" => $pending["submitter"],
								"accepted" => 1,
								"meta" => "$artist - $title",
								"good_upload" => $good ? 1 : 0,
							]);

						$track = DB::table("tracks")
							->where("id", "=", $id)
							->first();

						$this->index($track);

						rename(Config::get("radio.paths.pending") . "/" . $pending["path"], Config::get("radio.paths.music") . "/" . $pending["path"]);
						Notification::pending("accepted $artist - $title ($id)", Auth::user());
					}
					
					break;
				default:
					break;
			}


			if ($delete) {
				DB::table("pending")
					->where("id", "=", $pending["id"])
					->delete();
			}

		}

		if (Request::ajax())
			return Response::json(["status" => !$delete]);
		else
			return Redirect::to("/admin/pending");
	}

	public function getPendingSong($id) {
		$pending = DB::table("pending")->where("id", "=", $id)->first();

		if ($pending) {
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
	}

	public function getSong($id) {
		$track = DB::table("tracks")->where("id", "=", $id)->first();

		if ($track) {
			try {

				$this->sendFile($track, false);

			} catch (Exception $e) {
				return Response::json(["error" => $e->getMessage()]);
			}
			
		}
	}

	protected function sendFile(array $song, $pending = true) {
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

		$song = DB::table("tracks")
			->where("id", "=", $id)
			->first();

		if (! $song) {
			return radio_error("404 at POST /admin/songs/$id", 404);
		}

		if (Input::get("artist")) {
			$hash = sha1(
				strtolower(
					trim(
						Input::get("artist") . " - " . Input::get("title")
					)
				)
			);
		} else {
			$hash = sha1(
				strtolower(
					trim(
						Input::get("title")
					)
				)
			);
		}

		DB::table("tracks")
			->where("id", "=", $id)
			->update([
				"artist" => Input::get("artist"),
				"track" => Input::get("title"),
				"album" => Input::get("album"),
				"tags" => Input::get("tags"),
				"hash" => $hash,
				"lasteditor" => Auth::user()->user,
			]);

		$song = $song = DB::table("tracks")
			->where("id", "=", $id)
			->first();

		$this->index($song);

		return Redirect::back()
			->with("status", "Song Updated.");


	}

}
