<?php

class FaveController extends BaseController {
	public function getFaves($nick = false) {
		if($nick) {
			// select nick, artist, track from enick join efave on inick=enick.id join esong on isong=esong.id left join tracks on esong.hash=tracks.hash where nick= 'Vin';
			$faves = $this->getFavesArray($nick);
			if(Input::has("dl")) {
				$resp = Response::make($faves->get(), 200);
				$resp->header("Content-disposition", "attachment; filename={$nick}_faves.json");
				return $resp;
			}
		}
		else {
			$faves = null;
		}

		if($faves)
			$faves = $faves->paginate(100);
		$this->layout->content = View::make($this->theme("faves"))
			->with("nick", $nick)
			->with("faves", $faves);
	}
	
	public function postFaves($nick = false) {
		if(Input::has('nick')) {
			$nick = Input::get('nick', false);
		}
		
		return Redirect::to("/faves/$nick");
	}
}
