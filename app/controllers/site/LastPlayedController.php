<?php

class LastPlayedController extends BaseController {

	use PlayerTrait;
	
	public function getIndex() {
		$this->layout->content = View::make($this->theme("lastplayed"))
			->with("lastplayed", $this->getLastPlayedPagination()->paginate(20));
	}	
}
