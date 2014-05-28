<?php

trait Search {

	protected function getSearchResults($request, $amount = 20, $usable_only = true) {
		
			$results = $this->search($request ?: "", "track", "song-database", $usable_only);
			//dd($results);

			$start = (Paginator::getCurrentPage() - 1) * $amount;

			$count = $results["hits"]["total"];

			$slice = array_slice($results["hits"]["hits"], $start, $amount);

			$paginator = Paginator::make($slice, $count, $amount);

			View::share("time", $results["took"]);

			return $paginator;

	}

	public function search($terms, $type, $index, $usable_only = true) {

		$params = [
			"type" => $type,
			"index" => $index,
			"ignore" => [
				400,
				404
			],
			"body" => [
				"size" => 10000,
				"query" => [
					"query_string" => [
						"fields" => ["title", "artist", "album", "tags", "_id"],
						"default_operator" => "and",
						"query" => $terms,
					]
				],
			],
		];

		if ($usable_only) {
			$params["body"]["filter"] = ["bool" => ["must" => ["term" => ["usable" => 1] ] ] ];
		}

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
			"lastplayed" => strtotime($track["lastplayed"]),
			"lastrequested" => strtotime($track["lastrequested"]),
			"hash" => $track["hash"],
			"usable" => $track["usable"],
		];

		$this->client->index($tmp);
	}

}
