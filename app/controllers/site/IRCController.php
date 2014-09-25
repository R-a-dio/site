<?php

class IRCController extends BaseController {

	public function index() {
		$this->layout->content = View::make($this->theme("irc"));
	}	
}
