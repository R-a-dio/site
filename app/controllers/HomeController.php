<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| Default Home Controller.
	| Passes in default variables since they are otherwise not available
	| in an @section() block.
	|
	|	Route::get('/', 'HomeController@showHome');
	|
	*/

	protected $layout = 'master';

	/**
	 * Show the homepage (and throw in a load of variables)
	 *
	 * @return void
	 */
	public function showHome() {
		
		$this->layout->content = View::make($this->getTheme() . ".home")
			->with("base", Config::get("app.base", ""))
			->with("theme", $this->getTheme());

	}

}
