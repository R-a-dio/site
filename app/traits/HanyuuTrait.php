<?php

use Symfony\Component\Console\Output\BufferedOutput;

trait HanyuuTrait {

	public function getHanyuu($route, $id = null) {
		Auth::onceBasic("user");

		if (Auth::check()) {
			$user = Auth::user();

			if (($user->isDev() or $user->user === "AFK")) {
				$output = new BufferedOutput();
				switch ($route) {
					case "index":

						Artisan::call("index", ["id" => $id, "--json" => true], $output);
						break;

					case "reindex":
						Artisan::call("index:reindex", ["--json" => true], $output);
						break;

					default:
						break;
				}

				return Response::json(json_decode($output->fetch()));

			}
		}

		return Response::json(["error" => 403]);

	}

}
