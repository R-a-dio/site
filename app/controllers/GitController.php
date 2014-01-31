<?php

class GitController extends Controller {

	protected function auth() {
		if (Auth::onceBasic("username")) {
			return Auth::user()->isDev();
		}
		return false;
	}

	public function pull() {
		if ($this->auth()) {

			$payload = json_decode(Input::get("payload"));

			// only do this on master
			if ($payload["ref"] != "refs/heads/master")
				return;

			$forced = $payload["forced"] ? " (forced)" : "";
			$git = $payload["forced"] ? "git pull origin master -- force" : "git pull origin master";

			// log updates
			Log::info("[git] updating master from {$payload["before"]} to {$payload["after"]}" . $forced);
			
			// update the repo
			SSH::run([
				"cd " . base_path(),
				$git
			]);

			return;

		}
	}
}
