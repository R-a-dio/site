<?php

use Elasticsearch\Client;
use Illuminate\Pagination\LengthAwarePaginator;

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

			$page = LengthAwarePaginator::resolveCurrentPage() ?: 1;
			$start = ($page - 1) * $amount;
			if (($usable_only === false) && is_string($results)) {
				return radio_error(new Exception(print_r(json_decode($results), true)));
			}
			$count = $results["hits"]["total"];
			$slice = array_slice($results["hits"]["hits"], $start, $amount);
			$paginator = new LengthAwarePaginator($slice, $count, $amount);

			View::share("time", $results["took"]);
			$paginator->setPath(rawurlencode($request));
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
				"sort" => [
					["priority" => ["order" => "desc"]],
					["_score"   => ["order" => "desc"]]
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
			"acceptor" => $track->accepter,
			"editor" => $track->last_editor,
			"requests" => $track->requestcount,
			"priority" => $track->priority,
			"lastplayed" => strtotime($track->last_played),
			"lastrequested" => strtotime($track->last_requested),
			"hash" => $track->hash,
			"usable" => $track->usable,
			"need_reupload" => $track->need_reupload
		];

		$this->client->index($tmp);
	}

	public function remove(Track $track = null) {

		// assumes this is a model
		if (is_null($track))
			$track = $this;
		try {
		$this->client->delete([
			"type" => "track",
			"index" => "song-database",
			"id" => $track->id,
		]);
		} catch (Exception $e) {} // HACK this seems to work anyway
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
				"~",
			],
			[
				"",
				" ",
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
				" ",
			],
			$text
		);
	}

}
