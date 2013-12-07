<?php

class Staff extends BaseController {

	protected $layout = "master";

	protected function getStaff() {
		return DB::table("djs")
			->where("visible", "=", 1)
			->orderBy("role", "asc")
			->orderBy("priority", "asc")
			->get();
	}

	public function show() {
		$this->layout->content = View::make($this->getTheme() . ".staff")
			->with("staff", $this->getStaff());
	}
}