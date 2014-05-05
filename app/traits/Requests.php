<?php

use Httpful\Request as RestClient;

trait Requests {

	// normally in REST this would be a GET. Instead, it's a POST so we can use CSRF tokens.
	public function anyRequest($id) {
		$song = DB::table("tracks")
			->where("id", "=", $id)
			->first();

		if ($song) {

			try {
				$hmac = hash_hmac(
					"sha256",
					Request::server("REMOTE_ADDR"),
					Config::get("radio.hanyuu.key", "DEADBEEFCAFE")
				);
				// todo: move to TLS since hanyuu will be on another server
				$response = RestClient::post(Config::get("radio.hanyuu.host", "https://backup.r-a-d.io/request"))
					->body("songid=$id")
					->addHeader("X-Radio-Auth", $hmac)
					->addHeader("X-Radio-Client", Request::server("REMOTE_ADDR"))
					->send();

				if (!$response->hasErrors()) {
					$res = $this->parseResponse($response->body);
					$this->index($song);
				} else {
					$res = ["error" => trans("search.requests.oops")];
				}
			} catch (Exception $e) {
				$res = ["error" => $e->getMessage()];
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

		$actual = $response->response;

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

			case "hmac error":
				$response = ["error" => trans("search.requests.hmac")];
				break;

			default:
				$response = ["error" => trans("search.requests.invalid")];
				break;
		}

		return $response;
	}

}
