<?php

use Elasticsearch\Client;

trait SearchTrait {

	public $client;

	public function setupClient() {
		$this->client = new Client([
			"hosts" => [
				"127.0.0.1:9200",
			]
		]);
	}

	protected function getSearchResults($request, $amount = 20, $usable_only = true) {
		
			$results = $this->search($request ?: "", "track", "song-database", $usable_only);
			$start = (Paginator::getCurrentPage() - 1) * $amount;
			$count = $results["hits"]["total"];
			$slice = array_slice($results["hits"]["hits"], $start, $amount);
			$paginator = Paginator::make($slice, $count, $amount);

			View::share("time", $results["took"]);

			return $paginator;

	}

	public function search($terms, $type, $index, $usable_only = true) {

		$terms = $this->sanitize($terms);

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
			$params["body"]["filter"] = [
				"bool" => [
					"must" => [
						"term" => ["usable" => 1]
					]
				]
			];
		}

		return $this->client->search($params);

	}

	public function index(Track $track = null) {
		$tmp = [];

		// assumes this is a model
		if (is_null($track))
			$track = $this;

		$tmp["type"] = "track";
		$tmp["index"] = "song-database";
		$tmp["id"] = $track->id;

		$tmp["body"] = [
			"album" => $track->album,
			"tags" => $track->tags,
			"title" => $track->title,
			"artist" => $track->artist,
			"id" => $track->id,
			"acceptor" => $track->acceptor,
			"editor" => $track->last_editor,
			"requests" => $track->request_count,
			"lastplayed" => $track->last_played->toTimestamp(),
			"lastrequested" => $track->last_requested->toTimestamp(),
			"hash" => $track->hash,
			"usable" => $track->usable,
		];

		$this->client->index($tmp);
	}

	public function remove(Track $track = null) {

		// assumes this is a model
		if (is_null($track))
			$track = $this;

		$this->client->delete([
			"type" => "track",
			"index" => "song-database",
			"id" => $track->id,
		]);
	}


	public function sanitize($text) {
		return str_replace(
			[
				"+",
				"-",
				"&&",
				"||",
				"!",
				"{",
				"}",
				"[",
				"]",
				"^",
				"?", 
				"\\",
				"/",
			],
			[
				"",
				"",
				"",
				"",
				"",
				"",
				"",
				"",
				"",
				"",
				"",
				"",
				"",
			],
			$text
		);
	}

}
