<?php

class SearchController extends BaseController {
	use SearchTrait;

	public function __construct() {
		$this->setupClient();
		parent::__construct();
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {

		if (Input::has('q'))
			Redirect::to("/search/" . Input::get("q"));

		$this->layout->content = View::make($this->theme("search"))
			->with("results", null)
			->with("param", false);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($search)
	{
		$results = $this->getSearchResults($search);

		$this->layout->content = View::make($this->theme("search"))
			->with("results", $results)
			->with("param", $search);
	}
}
