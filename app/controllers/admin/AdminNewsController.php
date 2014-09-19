<?php

class AdminNewsController extends BaseController {

	/*
	 |--------------------------------------------------------
	 | Pending Songs
	 |--------------------------------------------------------
	 */

	/**
	 * View pending songs.
	 * 
	 * @param $id int
	 * @return void
	 */
	public function getPending() {
		$pending = Pending::all();

		$this->layout->content = View::make("admin.pending")
			->with("pending", $pending);
	}

	/**
	 * Accept, decline or replace a pending song.
	 * 
	 * @param $id int
	 * @return Response
	 */
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

	/**
	 * Get a pending song by its ID
	 * 
	 * @param $id int
	 * @return File
	 */
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
}
