<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */

	protected function getTheme()
	{
		// TODO: check database access, DJ column will have theme
		return "default";
	}

	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			// TODO: dynamic source for the themes
			$this->layout = View::make($this->layout)
				->with("base", Config::get("app.base", "/"))
				->with("theme", $this->getTheme()));
		}
	}

}