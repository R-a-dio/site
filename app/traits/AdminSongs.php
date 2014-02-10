<?php

trait AdminSongs {

	public function getPending() {
		$pending = DB::table("pending")
			->orderBy("id", "desc")
			->get();

		foreach($pending as &$p) {
			try {
				$filesize = filesize(Config::get("radio.paths.pending") . "/" . $p["path"]);
			} catch (Exception $e) {
				$filesize = "unknown";
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

		$action = Input::get("action");

		if ($pending) {
			switch ($action) {
				case "delete":
					$reason = Input::get("reason", "");
					$meta = $pending["track"] ?: $pending["origname"];
					DB::table("postpending")
						->insert([
							"reason" => $reason,
							"ip" => $pending["submitter"],
							"accepted" => 0,
							"meta" => $meta,
						]);
					unlink(Config::get("radio.paths.pending") . $pending["path"]);
					$delete = true;
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
						rename(Config::get("radio.paths.pending") . $pending["path"], Config::get("radio.paths.music") . $check["path"]);
					}
					
					break;
				case "accept":
					$editor = Auth::user()->user;
					$artist = Input::get("artist", "");
					$title = Input::get("title", null);
					$album = Input::get("album", "");
					$tags = Input::get("tags", "");
					$hash = sha1(strtolower(trim($artist != "" ? "$artist - $title" : $title)));

					// title is required.
					if ($title) {
						$delete = true;
						DB::table("tracks")
							->insert([
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
						rename(Config::get("radio.paths.pending") . $pending["path"], Config::get("radio.paths.music") . $pending["path"]);
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
			return Response::redirect("/admin/pending");
	}

	public function getPendingSong($id) {
		$pending = DB::table("pending")->where("id", "=", $id)->first();

		if ($pending)
			return Response::download(Config::get("radio.paths.pending") . "/" . $pending["path"]);
	}

	public function getSong($id) {
		$track = DB::table("tracks")->where("id", "=", $id)->first();

		if ($track) {
			try {
				return Response::download(Config::get("radio.paths.music") . "/" . $track["path"]);
			} catch (Exception $e) {
				return Response::json(["error" => 404]);
			}
			
		}
	}

}
