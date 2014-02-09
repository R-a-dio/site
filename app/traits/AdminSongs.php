<?php

trait AdminSongs {

	public function getPending() {
		$this->layout->content = View::make("admin.pending");
	}

	public function postPending($id) {

	}

}
