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
		$id = $this->argument("id");

		$track = DB::table("tracks")->where("id", "=", $id)->first();

		if (!$track)
		{
			$this->error("Track ID not found");
			return;
		}

		$this->comment("Artist: " . $track["artist"]);
		$this->comment("Title: " . $track["track"]);
		$this->comment("Album: " . $track["album"]);

		$this->info("Reindexing song...");

		$admin = App::make("Admin");
		$admin->index($track);

		$this->info("Song indexed.");

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
			//array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
