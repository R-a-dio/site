<?php

class BaseController extends Controller {

	public function __construct() {
		
		// Auth, naturally.
		//$this->beforeFilter('auth');

		// ALL POST/PUT/DELETE REQUIRE CSRF TOKENS.
		$this->beforeFilter('csrf', ['on' => ['post', 'put', 'delete']]);

	}

	/**
	 * Retrieve the current theme's identifier.
	 *
	 * @return string
	 */
	protected function getTheme()
	{
		if (Input::cookie("radio.theme", false)) {
			if (Cache::section("themes")
				->get(Input::cookie("radio.theme"))) {
				return Cache::section("themes")
					->get(Input::cookie("radio.theme"));
			} else {
				$theme = DB::table("themes")
				->where("id", Input::cookie("radio.theme"))
				->get();

				if ($theme) {
					Cache::section("themes")->put(
						Input::cookie("radio.theme"),
						$theme["name"],
						Config::get("cache.times.themes", 180)
					);
					return $theme["name"];
				} 
			}
		}
		// TODO: check database access, DJ column will have theme
		return "default";
	}

	/**
	 * Setup the layout used by the controller.
	 * Also adds a few required variables.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			// TODO: dynamic source for the themes
			$this->layout = View::make($this->layout)
				->with("base", Config::get("app.base", ""))
				->with("theme", $this->getTheme());
		}
	}

}