<?php

class SendMessage {
	public function fire($job, $data) {
		try {
			Artisan::call("slack:send", $data);
		} catch (Exception $e) {
			echo "[" . $job->getJobId() . "]" . " Failed to send slack message: " . $data["text"] . PHP_EOL;
		}

		$job->delete();
	}
}