<?php

return [
	"api" => [
		"limit" => 25,
	],
	"paths" => [
		"pending" => "/radio/music/pending",
		"music" => "/radio/music",
	],
	"captcha" => [
		"public" => $_ENV["RECAPTCHA_PUBLIC_KEY"],
		"private" => $_ENV["RECAPTCHA_PRIVATE_KEY"],
	],
];
