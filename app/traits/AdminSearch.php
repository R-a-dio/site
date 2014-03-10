<?php

use Elasticsearch\Client;

trait AdminSearch {

	public function getSearch($index = null) {

		if ($index) {

			$document = $this->search($index, "track", "song-database");

			View::share("index", $document["hits"]["hits"]);
		}

		$this->layout->content = View::make("admin.search");

	}

	// rebuild
	public function putSearch() {

		$load = DB::table("tracks")->get();

		try {
			foreach ($load as $track) {
				$this->index($track);
			}

			return;
		} catch (Exception $e) {
			return ["error" => $e->getTraceAsString(), "message" => $e->getMessage()];
		}
	}

	// wipe
	public function deleteSearch() {

		$this->client->indices()->delete(["index" => "song-database"]);
	}

	// query
	public function postSearch() {

	}
}
