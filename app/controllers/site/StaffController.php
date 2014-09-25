<?php

class StaffController extends BaseController {

	public function index() {
		$staff = Dj::where("visible", "=", 1)
			->orderBy("role", "asc")
			->orderBy("priority", "asc")
			->get();

		$this->layout->content = View::make($this->theme("staff"))
			->with("staff", $staff);
	}	
}
