<?php

class SendMessage {
	public function fire($job, $data) {
		Artisan::call("slack:send", $data);
		$job->delete();
	}
}