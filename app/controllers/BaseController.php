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
	protected function getTheme() {
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

	protected function getStrings($path, $locale) {
		try {

			$json = file_get_contents($path);
			$json = json_decode($json);

			Cache::section("strings")->put($locale, $json, 30);

			return $json;
		} catch (Exception $e) {
			die("Invalid json file: " . $path);
		}
	}

	protected function getLocaleStrings() {
		$locale = Config::get("app.locale", "en");
		// todo: fetch actual locale

		// No Fun Allowed
		if (preg_match("/[^a-z]/", $locale))
			$locale = "en";

		if (Cache::section("strings")->has($locale)) {

			return Cache::section("strings")->get($locale);

		} else {
			// need to add to the cache instead

			$strings = app_path() . "/views/strings/" . $locale . ".json";

			if (file_exists($strings))
				return $this->getStrings($strings, $locale);
			else
				return $this->getStrings($strings = app_path() . "/views/strings/en.json", "en");

		}
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
				->with("theme", $this->getTheme())
				->with("strings", $this->getLocaleStrings());
		}
	}

}