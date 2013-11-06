<?php

	class UserAuth extends BaseController {

		protected $layout = "master";

		public function login() {
			$this->layout->content = View::make($this->getTheme() . '.login');
		}
	}