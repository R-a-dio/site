<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class IndexCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'index:add';

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
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		return;
		$id = $this->argument("id");
		$json = $this->option("json");
		$output = [];

		$track = DB::table("tracks")->where("id", "=", $id)->first();

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
			$this->comment("Artist: " . $track["artist"]);
			$this->comment("Title: " . $track["track"]);
			$this->comment("Album: " . $track["album"]);
		}
		
		$admin = App::make("Admin");
		$admin->index($track);
		$output["success"] = true;
		
		if ($json) {
			$this->info(json_encode($output, JSON_PRETTY_PRINT));
		} else {
			$this->info("Song indexed.");
		}
		

	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('id', InputArgument::REQUIRED, 'Song ID in the database'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('json', "j", InputOption::VALUE_NONE, 'Output response as JSON?'),
		);
	}

}
