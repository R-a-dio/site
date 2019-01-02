<?php

return [
	"title" => "Submit",
	"guidelines" => [
		"upload" => [
			"title" => "Uploading",
			"search" => "VERY IMPORTANT: Search first to make sure that the song isn't already in the database!",
			"quality" => "Anything below 128kbps is auto-rejected. Do not upload YouTube rips.",
			"source" => "Please include as much information as possible in the comment field, especially source (name of the anime, VN, game). If there is no source work, please mention this.",
		],
		"tagging" => [
			"title" => "Tagging",
			"required" => "Artist and title are required; at least put them in the comment, if not in the artist and title tags.",
			"runes" => "Avoid Japanese characters unless it's absolutely necessary. Uploads with too much kana/kanji may be declined.",
			"cv" => "Do not include character names or \"CV\" notation; vocalists only."
		]
	],
	
	"comment" => [
		"label" => "Comment",
		"desc" => "Add the source, artist and title if tags are missing, etc."
	],
	"daypass" => [
		"label" => "Daypass",
		"desc" => "Enter the daypass and you can have unlimited uploads until midnight, UTC. Ask staff in IRC for it. USE WITH DISCRETION."
	],
	"upload" => [
		"label" => "Upload Song",
		"desc" => "Upload a song to the R/a/dio database. We accept both MP3 (20MB max) and FLAC (90MB max).",
	],
	"accepts" => "Accepts",
	"declines" => "Declines",
];

