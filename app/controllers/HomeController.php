<?php

class HomeController extends PlayerController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| Default Home Controller.
	| Passes in default variables since they are otherwise not available
	| in an @section() block.
	|
	|	Route::get('/', 'HomeController@showHome');
	|
	*/

	protected $layout = 'master';


	/**
	 * Builds the homepage queue
	 *
	 * @return string
	 */
	private function makeQueue() {
		$curqueue = $this->getQueueArray();

		if (!$curqueue)
			$curqueue = [
				["timestr" => "", "track" => ""],
				["timestr" => "", "track" => ""],
				["timestr" => "", "track" => ""],
				["timestr" => "", "track" => ""],
				["timestr" => "", "track" => ""],
			];

		$html = <<<START
		<h3 class="text-center">Queue</h3>
            <ul class="list-group text-center">

START;

		foreach($curqueue as $queue) {

			$queue["meta"] = htmlspecialchars($queue["meta"]);
			$diff = Helper::humanTimeDiff($queue["time"]);


			if ($queue["type"] == 1)
				$queue["meta"] = "<b>" . $queue["meta"] . "</b>";

			$html .= <<<QUEUE
                    <li class="list-group-item">
                    	<div class="container">
	                        <div class="col-md-3">
	                        	in {$diff}
	                        </div>
	                        <div class="col-md-6" style="line-height: 1; height: 30px;">
	                        	{$queue["meta"]}
	                        </div>
	                        <div class="col-md-3">
								<span class="badge faves" data-toggle="tooltip" title="faves">20</span>
                            	<span class="badge plays" data-toggle="tooltip" title="plays">99</span>
	                        </div>
                        </div>
                    </li>

QUEUE;
		}

		$html .= "</ul>";

		return $html;
	}




	/**
	 * Show the homepage (and throw in a load of variables)
	 *
	 * @return void
	 */
	public function showHome() {
		
		$this->layout->content = View::make($this->getTheme() . ".home")
			->with("base", Config::get("app.base", ""))
			->with("theme", $this->getTheme())
			->with("queue", $this->makeQueue());

	}

}
