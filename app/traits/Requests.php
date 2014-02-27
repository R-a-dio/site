<?php

use Buzz\Browser as Buzz;
use Buzz\Exception\ClientException as ClientException;

trait Requests {

	// normally in REST this would be a GET. Instead, it's a POST so we can use CSRF tokens.
	public function anyRequest($id) {
		$song = DB::table("tracks")
			->where("id", "=", $id)
			->first();

		if ($song) {

			$client = new Buzz;

			try {
				// todo: move to TLS since hanyuu will be on another server
				$response = $client->post(
					Config::get("radio.hanyuu.host", "http://localhost:9691"),
					[
						"X-Radio-Auth" =>
							hash_hmac(
								"sha256",
								Config::get("radio.hanyuu.key", "DEADBEEFCAFE"),
								Request::server("REMOTE_ADDR")
							),
						"X-Radio-Client" => Request::server("REMOTE_ADDR"),
					],
					"songid={$song["id"]}"
				);

				if ($response->isOk())
					$res = $this->parseResponse($response->getContent());
				else
					$res = ["error" => trans("search.requests.oops")];
			} catch (ClientException $e) {
				$res = ["error" => trans("search.requests.oops")];
			}
		} else {
			$res = ["error" => trans("search.requests.missing")];
		}

		if (Request::ajax() or !Request::server("REFERER"))
			return Response::json($res);
		else
			return Redirect::back()
				->with("status", $res);
	}

	protected function parseResponse($response) {
		$actual = preg_replace("/.*<h2>([^<]*)<\/h2>.*/", "$1", $response);

		switch ($actual) {
			case "You can't request songs at the moment.":
				$response = ["error" => trans("search.requests.no_afk")];
				break;

			case "You need to wait longer before requesting again.":
				$response = ["error" => trans("search.requests.user_cooldown")];
				break;

			case "You need to wait longer before requesting this song.":
				$response = ["error" => trans("search.requests.song_cooldown")];
				break;

			case "Invalid parameter.":
				$response = ["error" => trans("search.requests.invalid")];
				break;

			case "Thank you for making your request!":
				$response = ["success" => trans("search.requests.success")];
				break;

			default:
				$response = ["error" => trans("search.requests.invalid")];
				break;
		}

		return $response;
	}

}
