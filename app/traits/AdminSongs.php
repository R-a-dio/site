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
							$track = DB::table("tracks")
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
						rename(Config::get("radio.paths.pending") . "/" . $pending["path"], Config::get("radio.paths.music") . "/" . $pending["path"]);
						Notification::pending("accepted $artist - $title ($track)", Auth::user());
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
				
				$path = Config::get("radio.paths.pending") . "/" . $pending["path"];
				$file = file_get_contents($path);
				$size = filesize($path);
				$response = Response::make($file, 200);
				
				if ($pending["format"] == "flac") {
					$type = "audio/x-flac";
				} else {
					$type = "audio/mpeg";
				}

				$response->header("Cache-Control", "no-cache");
				$response->header("Content-Description", "File Transfer");
				$response->header("Content-Type", $type);
				$response->header("Content-Transfer-Encoding", "binary");
				$response->header("Content-Length", $size);
				$response->header("Content-Disposition", "attachment; filename=" . $pending["path"]);

				return $response;
			} catch (Exception $e) {
				return Response::json(["error" => $e->getMessage()]);
			}
			
		}
	}

	public function getSong($id) {
		$track = DB::table("tracks")->where("id", "=", $id)->first();

		if ($track) {
			try {
				$path = Config::get("radio.paths.music") . "/" . $track["path"];
				$file = file_get_contents($path);
				$size = filesize($path);
				$response = Response::make($file, 200);
				
				if (strpos($track["path"], ".flac") !== 0) {
					$type = "audio/x-flac";
				} else {
					$type = "audio/mpeg";
				}

				$response->header("Cache-Control", "no-cache");
				$response->header("Content-Description", "File Transfer");
				$response->header("Content-Type", $type);
				$response->header("Content-Transfer-Encoding", "binary");
				$response->header("Content-Length", $size);
				$response->header("Content-Disposition", "attachment; filename=" . $track["path"]);

				return $response;
			} catch (Exception $e) {
				return Response::json(["error" => $e->getMessage()]);
			}
			
		}
	}

	public function getSongs($search = null) {
		$search = $search ?: Input::get("q", null);

		$results = $this->getSearchResults($search);
		

		$this->layout->content = View::make("admin.database")
			->with("search", $search)
			->with("results", $results);
	}

	public function postSongs($id) {
		if ($id == "search") {
			$search = Input::get("q");
			return Redirect::to("/admin/songs/$search");
		}
	}

}
