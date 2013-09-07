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
		
		$this->layout->content = View::make($this->getTheme() . ".home")
			->with("base", Config::get("app.base", ""))
			->with("theme", $this->getTheme());

	}

}
