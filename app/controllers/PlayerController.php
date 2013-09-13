<?php

class PlayerController extends BaseController {


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
				'eplay.dt as lastplayed',
				'esong.meta as metadata',
				DB::raw('(select count(*) from efave where eplay.isong = esong.isong) as faves'),
				DB::raw('(select count(*) from eplay where eplay.isong = esong.id) as plays')
			)
			->join('esong', 'eplay.isong', "=", 'esong.id')
			->orderBy('eplay.dt', 'desc')
			->take($limit)
			->get();
	}

}