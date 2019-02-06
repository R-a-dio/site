<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Elasticsearch\Client;

class DatabaseCleanupCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'database:cleanup';

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
		$db = DB::table("tracks")->get();
		
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
		$this->info(count($db) . " tracks in the database.");

		$index = array_column($search["hits"]["hits"], "_id");

		foreach ($db as $track) {
			if (in_array($track["id"], $index))
				continue;

			$this->comment("Deleting " . $track["id"]);

			DB::table("tracks")
				->where("id", "=", $track["id"])
				->delete();
		}

		$this->info("Done");
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
