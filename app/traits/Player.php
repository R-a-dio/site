<?php

trait Player {


	/*
	|--------------------------------------------------------------------------
	| Player (faves|queue) Controller
	|--------------------------------------------------------------------------
	|
	| Generates current song info for the player and the homepage
	| (with an interface for the last played and queue pages)
	| 
	| This shouldnt directly route to anything.
	|
	*/

	/**
	 * 
	 */
	protected function getSongDelay($priority) {
		// priority is 30 max
		if ($priority > 30)
			$priority = 30;

		// between 0 and 7 return magic
		if ($priority >= 0 and $priority <= 7)
			return -11057 * $priority * $priority + 172954 * $priority + 81720;
		// if above that, return magic crazy numbers
		else
			return (int) (599955 * exp(0.0372 * $priority) + 0.5);
	}

	/**
	 * Retrieve the current queue.
	 * 
	 * @param int $limit
	 *
	 * @return array
	 */
	protected function getQueueArray($limit = 5) {
		return DB::table('queue')
			->select(
				'meta',
				DB::raw('unix_timestamp(time) as time'),
				'type'
			)
			->orderBy('time', 'asc')
			->take($limit)
			->get();	
	}


	/**
	 * Retrieve the current queue.
	 * 
	 * @param int $limit
	 *
	 * @return array
	 */
	protected function getQueuePagination() {
		return DB::table('queue')
			->select(
				'meta',
				DB::raw('unix_timestamp(time) as time'),
				'type'
			)
			->orderBy('time', 'asc');	
	}


	/**
	 * Grabs the last $limit songs played
	 *
	 * @param int $limit
	 * @return array
	 */
	protected function getLastPlayedArray($limit = 5) {

		// this query is utter shit and you should feel bad if you made this.

		return DB::select(
			"select unix_timestamp(`eplay`.`dt`) as time, `esong`.`meta` " .
			"from `eplay` use index (PRIMARY) " .
			"inner join `esong` on `esong`.`id` = `eplay`.`isong` " .
			"order by `eplay`.`id` desc limit ?", [$limit]);

	}

	/**
	 * Grabs the last $limit songs played
	 *
	 * @param int $limit
	 * @return array
	 */
	protected function getLastPlayedPagination() {

		// this is such a hack holy shit
		return DB::table(DB::raw("`eplay` use index(PRIMARY)"))
			->select(
				"esong.meta",
				DB::raw("unix_timestamp(`eplay`.`dt`) as time")
			)
			->join("esong", "esong.id", "=", "eplay.isong")
			->orderBy("eplay.id", "desc");

	}

}