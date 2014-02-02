<?php

trait Search {

	protected function getSearchResults($request) {
		if ($request) {
		
			$results = DB::table('tracks')
				->where('usable', '=', 1)
				->where('need_reupload', '=', 0)
				->whereRaw('match (artist, track, album, tags) against (?)', [$request])
				->select("id", "track", "artist", "album", "tags", "lastplayed", "lastrequested", "requestcount", "priority")
				->paginate(15);

			$search = $results->toArray();

			foreach ($search["data"] as &$result) {

				$delay = $this->getSongDelay((int) $result["requestcount"]);

				if ((time() - strtotime($result["lastrequested"])) > $delay)
					$result["cooldown"] = false;
				else
					$result["cooldown"] = true;

			}

			return ["search" => $search, "links" => $results->links()];
		} else {
			return ["search" => false, "links" => ""];
		}

	}

}
