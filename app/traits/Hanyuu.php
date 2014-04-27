<?php

use Symfony\Component\Console\Output\BufferedOutput;

trait Hanyuu {

	public function getHanyuu($route, $id = null) {
		Auth::onceBasic("user");

		if (false) {
			$user = Auth::user();

			if (($user->isDev() or $user->id === 18)) {
				$output = new BufferedOutput();
				switch ($route) {
					case "index":

						Artisan::call("index:add", ["id" => $id, "--json" => true], $output);
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
