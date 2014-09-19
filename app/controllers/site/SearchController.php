<?php

class SearchController extends BaseController {
	use SearchTrait;

	public function __construct() {
		$this->setupClient();
		parent::__construct();
	}

	
}
