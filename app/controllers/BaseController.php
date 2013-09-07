<?php

class BaseController extends Controller {

	/**
	 * Retrieve the current theme's identifier.
	 *
	 * @return string
	 */
	protected function getTheme()
	{
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