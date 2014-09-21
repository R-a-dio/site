<?php

class SongController extends BaseController {

	protected $layout = "admin";

	use SearchTrait;

	public function __construct() {
		$this->beforeFilter("auth.pending");
		parent::__construct();
	}

	/**
	 * Search elasticsearch for songs in the admin panel.
	 * 
	 * @param $search string
	 * @return void
	 */
	public function getIndex($search = null) {
		$search = $search ?: Input::get("q", null);

		$results = $this->getSearchResults($search, 20, false);
		

		$this->layout->content = View::make("admin.database")
			->with("search", $search)
			->with("results", $results);
	}

	/**
	 * Update a Track entry (TODO: make PUT?)
	 * 
	 * @param $id int
	 * @return Redirect
	 */
	public function postIndex($id) {
		if ($id == "search") {
			$search = Input::get("q");
			return Redirect::to("/admin/songs/$search");
		}

		$song = Track::findOrFail($id);

		$song->title = Input::get("title", "");
		$song->artist = Input::get("artist", "");
		$song->album = Input::get("album", "");
		$song->tags = Input::get("tags", "");

		$song->save();

		return Redirect::back()
			->with("status", "Song Updated.");


	}
}
