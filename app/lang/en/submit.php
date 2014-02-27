<?php

return [
	"title" => "Submit",
	"guidelines" => [
		"upload" => [
			"title" => "Uploading",
			"search" => "Search first to make sure that the song isn't already in the database.",
			"quality" => "Anything below 128kbps is auto-rejected. That means no youtube rips.",
			"source" => "Please include the source (anime, VN, etc.) in the comment field.",
		],
		"tagging" => [
			"title" => "Tagging",
			"required" => "Both artist and title are required.",
			"runes" => "Avoid Japanese characters unless it's absolutely necessary.",
			"cv" => "Do not include character names or \"CV\" notation; vocalists only."
		]
	],
	
	"comment" => [
		"label" => "Comment",
		"desc" => "Add the source, artist and title if tags are missing, etc."
	],
	"daypass" => [
		"label" => "Daypass",
		"desc" => "Enter the daypass and you can have unlimited uploads until midnight, UTC."
	],
	"upload" => [
		"label" => "Upload Song",
		"desc" => "Upload a song to the R/a/dio database. Try to keep MP3s to around 15MB.",
	],
	"accepts" => "Accepts",
	"declines" => "Declines",
];

