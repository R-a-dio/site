<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Elasticsearch\Client;

class IndexCommand extends Command {

	use SearchTrait;

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'index';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Index a specific song';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->setupClient();
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$id = $this->argument("id");
		$json = $this->option("json");
		$delete = $this->option("delete");
		$output = [];

		$track = Track::find($id);

		if (!$track)
		{
			if ($json) {
				$output["success"] = false;
				$output["error"] = "Track ID not found";

				$this->info(json_encode($output, JSON_PRETTY_PRINT));
			} else {
				$this->error("Track ID not found");
			}
			return;
		}

		if ($json) {
			$output["track"] = $track;
		} else {
			$this->comment("Artist: " . $track->artist);
			$this->comment("Title: " . $track->title);
			$this->comment("Album: " . $track->album);
		}
		
		if ($delete) {
			$this->remove($track);
		} else {
			$this->index($track);
		}
		$output["success"] = true;
		
		if ($json) {
			$this->info(json_encode($output, JSON_PRETTY_PRINT));
		}
		

	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			["id", InputArgument::REQUIRED, "Song ID in the database"],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
			["json", "j", InputOption::VALUE_NONE, 'Output response as JSON?'],
			["delete", "d", InputOption::VALUE_NONE, "Delete the document?"],
		];
	}

}
