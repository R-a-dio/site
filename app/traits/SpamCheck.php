<?php

use Httpful\Request as RestClient;

trait SpamCheck {

	public function isSpam($post) {
		$key = Config::get("radio.akismet.key", "test");

		$data = [
			"blog" => Config::get("radio.akismet.blog"),
			"user_ip" => Input::server("REMOTE_ADDR"),
			"user_agent" => Input::server("HTTP_USER_AGENT"),
			"referrer" => Input::server("HTTP_REFERER"),
			"comment_type" => "comment",
			"comment_content" => $post,
		];

		$response = RestClient::post(sprintf(Config::get("radio.akismet.url"), $key))
			->body(http_build_query($data))
			->send();

		if (!$response->hasErrors()) {
			return $response->body === "true";
		}

		return true;
		
	}
	
}
