<?php

class QueueController extends BaseController {

	use PlayerTrait;

	public function index() {
		$this->layout->content = View::make($this->theme("queue"))
			->with("queue", $this->getQueuePagination()->get());
	}	
}
