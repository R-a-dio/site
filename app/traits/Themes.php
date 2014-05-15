<?php

trait Themes {
	
	/*
	|--------------------------------------------------------------------------
	| Themes controller
	|--------------------------------------------------------------------------
	|
	| Utility functions and routes for handling themes on the main site.
	|
	*/
	
	protected function getThemesArray() {
		return Theme::all();
	}
	
	/*
	* This method sets the theme for the current user in a cookie.
	* If the variable is less than 0 (not a valid id) it will unset the cookie.
	*/
	public function anySetTheme($id) {
		
		if($id >= 0) {
			$theme = Theme::find($id);
			
			if(is_null($theme)) {
				$theme = Theme::where('name', '=', 'default')->first();
			}
			
			$cookie = Cookie::forever('theme', $theme->name);
			return Redirect::to("/")->withCookie($cookie);
		}
		else {
			$cookie = Cookie::forget('theme');
			return Redirect::to("/")->withCookie($cookie);
		}
		
	}
	
	
}