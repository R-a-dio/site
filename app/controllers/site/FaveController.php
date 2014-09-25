<?php

class FaveController extends BaseController {

	use FaveTrait;

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$this->layout->content = View::make($this->theme("faves"))
			->with("nick", null)
			->with("faves", null);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if(Input::has('nick')) {
			$nick = Input::get('nick', false);
		}
		
		return Redirect::to("/faves/$nick");
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($nick)
	{
		$faves = $this->getFavesArray($nick);
		if (Input::has("dl")) {
			$resp = Response::make($faves->get(), 200);
			$resp->header("Content-disposition", "attachment; filename={$nick}_faves.json");
			return $resp;
		}

		if ($faves)
			$faves = $faves->paginate(100);

		$this->layout->content = View::make($this->theme("faves"))
			->with("nick", $nick)
			->with("faves", $faves);
	}
}
