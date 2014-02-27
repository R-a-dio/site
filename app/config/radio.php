<?php

return [
	"api" => [
		"limit" => 25,
	],
	"paths" => [
		"pending" => "/radio/music/pend",
		"music" => "/radio/music",
	],
	"captcha" => [
		"public" => $_ENV["RECAPTCHA_PUBLIC_KEY"],
		"private" => $_ENV["RECAPTCHA_PRIVATE_KEY"],
	],
	"camo" => [
		"host" => "https://images.r-a-d.io/",
		"key" => $_ENV["CAMO_KEY"],
	],
	"daypass" => $_ENV["DAYPASS"],
	"hanyuu" => [
		"host" => $_ENV["HANYUU_HOST"],
		"key" => $_ENV["HANYUU_HMAC_KEY"],
	],
];
