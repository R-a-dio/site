<?php

class DevController extends BaseController {

	protected $layout = "admin";

	public function __construct() {
		$this->beforeFilter("auth.dev");
		parent::__construct();
	}

	/**
	 * Misc developer items.
	 * 
	 * @return void
	 */
	public function getIndex() {
		if (! Auth::user()->isDev())
			return Redirect::to("/admin");
		
		$this->layout->content = View::make("admin.dev")
			->with("failed_logins", DB::table("failed_logins")->get())
			->with("environment", App::environment());
	}

	/**
	 * Restore a soft-deleted item as a developer.
	 * 
	 * @param $type string
	 * @param $id int
	 * @return void
	 */
	public function getRestore($type, $id) {
		if (! Auth::user()->isDev())
			return Redirect::to("/admin");

		if ($type == "news") {
			$news = News::withTrashed()->find($id);
			$news->restore();
		}
	}
}
