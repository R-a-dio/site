<?php

class LastPlayedController extends BaseController {

	use PlayerTrait;

	public function index() {
		$this->layout->content = View::make($this->theme("lastplayed"))
			->with("lastplayed", $this->getLastPlayedPagination()->paginate(20));
	}	
}
