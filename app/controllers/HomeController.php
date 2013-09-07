<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	protected $layout = 'master';

	public function showHome() {
		
		// primary content.
		$this->layout->content = View::make($this->theme . "home");

		// optional javascript to place at the end of the body tag
		$this->layout->script = "";
	}

}
