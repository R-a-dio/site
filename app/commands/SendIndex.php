<?php

class SendIndex {
	public function fire($job, $data) {
		try {
			Artisan::call("index:add", $data);
		} catch (Exception $e) {}

		$job->delete();
	}
}
