<?php

class QueueController extends BaseController {

	use PlayerTrait;
	
	public function getIndex() {
		$this->layout->content = View::make($this->theme("queue"))
			->with("queue", $this->getQueuePagination()->get());
	}	
}
