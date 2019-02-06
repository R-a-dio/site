<?php

return [
	"api" => [
		"limit" => 25,
	],
	"paths" => [
		"pending" => "/radio/music/pending",
		"music" => "/radio/music",
		"dj-images" => "/radio/dj-images",
	],
	"captcha" => [
		"public" => env("RECAPTCHA_PUBLIC_KEY", ''),
		"private" => env("RECAPTCHA_PRIVATE_KEY", ''),
	],
	"camo" => [
		"host" => "https://images.r-a-d.io/",
		"key" => env("CAMO_KEY", "0xDEADBEEFCAFE"),
	],
	"daypass" => env("DAYPASS", "testing"),
	"hanyuu" => [
		"host" => env("HANYUU_HOST", ''),
		"key" => env("HANYUU_HMAC_KEY", ''),
	],
	"akismet" => [
		"key" => env("AKISMET_KEY", "test"),
		"url" => "https://%s.rest.akismet.com/1.1/comment-check",
		"blog" => "https://r-a-d.io/news",
	],
	"stream" => [
		"url" => "https://stream.r-a-d.io/main.mp3",
	],
];
