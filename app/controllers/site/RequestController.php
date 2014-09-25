<?php

class RequestController extends BaseController {

	use RequestTrait;

	// normally in REST this would be a GET. Instead, it's a POST so we can use CSRF tokens.
	public function store($id) {
		$result = $this->requestSong($id);

		if (Request::ajax() or !Request::server("REFERER"))
			return Response::json($result);
		else
			return Redirect::back()
				->with("status", $result);
	}
}
