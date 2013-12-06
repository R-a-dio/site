<?php

class IRC extends BaseController {

	protected $layout = "master";

	public function show() {
		$this->layout->content = View::make($this->getTheme() . '.irc');
	}
}
