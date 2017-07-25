<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ReindexCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'index:reindex';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Reindex the database';

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
		$this->info("Fetching Admin IoC container");

		// grab the Admin controller directly from the IoC container
		$admin = App::make("Admin"); 

		$this->info("Fetching all tracks from the database...");

		$tracks = Track::all();

		$this->comment("Found " . $tracks->count() . " tracks");

		$this->info("Clearing the existing index");

		$admin->client->indices()->delete(["index" => "song-database"]);

		$this->info("Reindexing all tracks...");
		$num = 1;
		foreach ($tracks as $track)
		{
			$admin->index($track);
			$this->info("Reindexed track ID ".$track->id." (".$num." of ".$tracks->count().")");
			$num++;
		}

		$this->info("Reindex Complete");
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
