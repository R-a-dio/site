<?php

class BaseController extends Controller {

	public function __construct() {

		// ALL POST/PUT/DELETE REQUIRE CSRF TOKENS.
		$this->beforeFilter('csrf', ['on' => ['post', 'put', 'delete']]);

	}

	/**
	 * Retrieve the current theme's identifier.
	 *
	 * @return string
	 */
	protected function getTheme() {
		// TODO: check database access, DJ column will have theme
		return "default";
	}

	/**
	 * Retrieve a page using the current theme.
	 *
	 * @param string $page
	 * @return string
	 */
	protected function theme($page) {
		// TODO: check database access, DJ column will have theme
		return $this->getTheme() . "." . $page;
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
			View::share("theme", $this->getTheme());
			
			$this->layout = View::make($this->layout);
		}
	}

}