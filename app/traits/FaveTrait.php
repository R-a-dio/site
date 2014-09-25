<?php

trait FaveTrait {
	protected function getFavesArray($nick) {
		return DB::table("enick")
				->join('efave', 'enick.id', '=', 'efave.inick')
				->join('esong', 'efave.isong', '=', 'esong.id')
				->leftJoin('tracks', 'esong.hash', '=', 'tracks.hash')
				->where('nick', $nick)
				->select('tracks.id as tracks_id', 'meta', 'lastrequested', 'lastplayed', 'requestcount')
				->orderBy('meta', 'asc');
	}
}
