<?php

class Submit extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Submit Page.
	|--------------------------------------------------------------------------
	|
	| Submits songs, or displays recently added/rejected songs.
	| 
	| 
	|
	|	Route::get('/submit', 'SubmitController@showSubmit');
	|	Route::post('/submit', 'SubmitController@doSubmit');
	|
	*/
	protected $layout = 'master';

	protected function getLastAccepted($limit = 20) {

	}

	protected function getLastRejected($limit = 20) {

	}

	protected function getSong() {
		$song = Input::file('song');

		if (in_array(
					$song->getClientOriginalExtension(),
					Config::get('app.allowed_extensions', ['mp3'])
			)
			and in_array(
				$song->getMimeType(),
				Config::get('app.allowed_mime_types', ['audio/mpeg'])
			)
		) {
			if ($song->getUploadedSize() > Config::get('app.max_upload_size', 15000)) {
				
			}
		}
	}

	protected function getTags() {
		// need to use something to process tags here.
	}

	public function showSubmit($submit = false) {

		$this->layout->content = View::make($this->getTheme() . ".submit")
			->with("base", Config::get("app.base", ""))
			->with("theme", $this->getTheme())
			->with("submit", $submit)
			->with("status", $status);

	}

	public function doSubmit() {
		if (Input::hasFile('song')) {
			if ($this->getSong()) {
				$comment = Input::get('comment', "No Comment");
				$code = Input::get('daypass', '');
			}
		} else {
			// TODO 
		}
	}



}