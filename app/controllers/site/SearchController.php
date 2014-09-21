<?php

class SearchController extends BaseController {
	use SearchTrait;

	public function __construct() {
		$this->setupClient();
		parent::__construct();
	}

	public function anyIndex($search = false) {

		if (Input::has('q'))
			$search = Input::get("q", false);

		$results = $this->getSearchResults($search);

		$this->layout->content = View::make($this->theme("search"))
			->with("results", $results)
			->with("param", $search);
	}
}
