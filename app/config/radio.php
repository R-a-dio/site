<?php

return [
	"api" => [
		"limit" => 25,
	],
	"paths" => [
		"pending" => "/radio/music/pend",
		"music" => "/radio/music",
		"dj-images" => "/radio/dj-images",
	],
	"captcha" => [
		"public" => @$_ENV["RECAPTCHA_PUBLIC_KEY"],
		"private" => @$_ENV["RECAPTCHA_PRIVATE_KEY"],
	],
	"camo" => [
		"host" => "https://images.r-a-d.io/",
		"key" => @$_ENV["CAMO_KEY"] ?: "0xDEADBEEFCAFE",
	],
	"daypass" => @$_ENV["DAYPASS"] ?: "testing",
	"hanyuu" => [
		"host" => @$_ENV["HANYUU_HOST"],
		"key" => @$_ENV["HANYUU_HMAC_KEY"],
	],
	"akismet" => [
		"key" => @$_ENV["AKISMET_KEY"] ?: "test",
		"url" => "https://%s.rest.akismet.com/1.1/comment-check",
		"blog" => "https://r-a-d.io/news",
	],
];
