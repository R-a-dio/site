<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Elasticsearch\Client;

class DatabaseRescueCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'database:rescue';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$params = [
			"hosts" => [
				"127.0.0.1:9200",
			],
		];
		$client = new Client($params);

		$search = $client->search([
			"type" => "track",
			"index" => "song-database",
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
						"query" => "*:*",
					]
				],
			],
		]);

		$this->info(count($search["hits"]["hits"]) . " tracks in the index.");

		foreach ($search["hits"]["hits"] as $s) {
			$source = $s["_source"]; // index match
			$id = $s["_id"];

			$possible = glob("/radio/music/{$id}_*");

			if (!$possible) {
				$this->info("Missing index entry for $id");
				continue;
			}

			$path = $possible[0];


			DB::insert(
				"insert into `tracks` (track, artist, album, tags, hash, path, usable, requestcount, accepter, lasteditor, lastplayed, lastrequested, id)" .
				" values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) on duplicate key update " .
				"track=VALUES(track), artist=VALUES(artist), album=VALUES(album), tags=VALUES(tags), path=VALUES(path), hash=VALUES(hash), " .
				"requestcount=VALUES(requestcount), lasteditor=VALUES(lasteditor), lastplayed=VALUES(lastplayed), lastrequested=VALUES(lastrequested)", [
				$source["title"], $source["artist"], $source["album"], $source["tags"], $source["hash"], $path, 1, $source["requests"],
				$source["acceptor"], $source["editor"], $source["lastplayed"], $source["lastrequested"], $source["id"],
			]);
		}


	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array();
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array();
	}

}
