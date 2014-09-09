<?php

trait IndexTrait {
	public function index() {
		Queue::push("SendIndex", ["id" => $this->id]);
	}

	public function remove() {
		Queue::push("SendIndex", ["id" => $this->id, "-d" => true]);
	}
}
