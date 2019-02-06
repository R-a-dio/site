<?php

trait IndexTrait {
	public function index() {
		Artisan::call("index", ["id" => $this->id]);
	}

	public function remove() {
		Artisan::call("index", ["id" => $this->id, "-d" => true]);
	}
}
