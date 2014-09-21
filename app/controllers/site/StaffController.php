<?php

class StaffController extends BaseController {

	public function getIndex() {
		$staff = Dj::where("visible", "=", 1)
			->orderBy("role", "asc")
			->orderBy("priority", "asc")
			->get();

		$this->layout->content = View::make($this->theme("staff"))
			->with("staff", $staff);
	}	
}
