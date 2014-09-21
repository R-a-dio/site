<?php

class IRCController extends BaseController {

	public function getIndex() {
		$this->layout->content = View::make($this->theme("irc"));
	}	
}
