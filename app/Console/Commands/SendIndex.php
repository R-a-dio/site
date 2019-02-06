<?php

class SendIndex {
	public function fire($job, $data) {
		try {
			Artisan::call("index", $data);
		} catch (Exception $e) {}

		$job->delete();
	}
}
