<?php

class Player extends BaseController {


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
				DB::raw('UNIX_TIMESTAMP(time) as time'),
				'type'
			)
			->orderBy('time', 'asc')
			->take($limit)
			->get();	
	}


	/**
	 * Grabs the last $limit songs played
	 *
	 * @param int $limit
	 * @return array
	 */
	protected function getLastPlayedArray($limit = 5) {

		// this query is utter shit and you should feel bad if you made this.
		return DB::table('eplay')
			->select(
				DB::raw('unix_timestamp(eplay.dt) as time'),
				'esong.meta'
			)
			->join('esong', 'esong.id', "=", 'eplay.isong')
			->orderBy('eplay.id', 'desc')
			->take($limit)
			->get();
	}

}