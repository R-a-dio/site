<?php

trait Search {

	protected function getSearchResults($request, $amount = 20) {
		
			$results = $this->search($request ?: "", "track", "song-database");
			//dd($results);

			$start = (Paginator::getCurrentPage() - 1) * $amount;

			$count = $results["hits"]["total"];

			$slice = array_slice($results["hits"]["hits"], $start, $amount);

			$paginator = Paginator::make($slice, $count, $amount);

			View::share("time", $results["took"]);

			return $paginator;

	}

	public function search($terms, $type, $index) {

		$params = [
			"type" => $type,
			"index" => $index,
			"ignore" => [
				400,
				404
			],
			"body" => [
				"query" => [
					"query_string" => [
						"fields" => ["title", "artist", "album", "tags", "_id"],
						"default_operator" => "and",
						"query" => $terms,
					]
				],
			],
		];

		return $this->client->search($params);

	}

	public function index($track) {
		$tmp = [];

		$tmp["type"] = "track";
		$tmp["index"] = "song-database";
		$tmp["id"] = $track["id"];

		$tmp["body"] = [
			"album" => $track["album"],
			"tags" => $track["tags"],
			"title" => $track["track"],
			"artist" => $track["artist"],
			"id" => $track["id"],
			"acceptor" => $track["accepter"],
			"editor" => $track["lasteditor"],
			"requests" => $track["requestcount"],
			"lastplayed" => $track["lastplayed"],
			"lastrequested" => $track["lastrequested"],
			"hash" => $track["hash"],
			"delay" => $this->getSongDelay($track["requestcount"]),
		];

		$lr = strtotime($track["lastrequested"]);

		if (time() - $lr > $tmp["body"]["delay"])
			$tmp["body"]["cooldown"] = false;
		else
			$tmp["body"]["cooldown"] = $lr + $tmp["body"]["delay"];

		$this->client->index($tmp);
	}

}
