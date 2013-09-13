<?php

class StatsController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Stats Controller
	|--------------------------------------------------------------------------
	|
	| Generates various different stats.
	| Sadly I have to touch HTML in a controller. It's just echoed out.
	| Google's graph API will come in stupidly handy here.
	|
	|	Route::get('/stats/graph', 'StatsController@showGraphs');
	|	Route::get('/stats/graph.json', StatsController@getGraphsAjax');
	|	Route::get('/stats/djs', 'StatsController@showDJStats');
	|	Route::get('/stats/faves', 'StatsController@showFaveStats');
	|
	*/

	protected $layout = 'master';

	/**
	 * Fetches arrays for use in the Google Graph JS API
	 * Interval is default 288 rows - 24 hours (5min increments)
	 *
	 * @param int $interval
	 * @return array
	 */
	private function getGraphs($interval = 288) {
		$stats = DB::table('listenlog')
			->select(
				'listenlog.listeners',
				'listenlog.time',
				'djs.djname',
				'djs.djimage'
			)
			->join('djs', 'listenlog.dj', '=', 'djs.id')
			->orderBy('listenlog.id', 'desc')
			->take($interval)
			->get();

		return $stats;
	}

	/**
	 * Fetches DJ stats.
	 *
	 * @return string
	 */
	private function getFaveStats() {

	}

	/**
	 * Fetches the HTML for DJ stats
	 *
	 * @return string
	 */
	private function getDJStats() {

	}

	/**
	 * Show the Graphs HTML.
	 *
	 * @return string
	 */
	private function getGraphStats() {

	}

	


	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	public function showGraphs() {
		return Response::json($this->getGraphs());
	}

	/**
	 * Shows each DJ's stats.
	 *
	 * @return void
	 */
	public function showDJStats() {

	}

	/**
	 * Shows Top Favourites.
	 *
	 * @return void
	 */
	public function showFaveStats() {

	}

	/**
	 * Returns JSONP when asked by a client.
	 * Yay for realtime stats updating.
	 * Inb4 this kills nginx
	 *
	 * @return jsonp
	 */
	public function getGraphsAjax() {
		return Response::json($this->getGraphs())
			->setCallback(Input::get('callback'));
	}
}