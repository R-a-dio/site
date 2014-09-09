<?php

/*
 * This file should not be translated unless you are working with a
 * custom installation of R/a/dio in another language and are using Slack.
 */

// sucky
$radio_slack = "<https://r-a-d.io/admin/users/:userid|:user>";

return [

	"news" => [
		"add" => [
			"title" => "{$radio_slack} posted a news article",
			"body" => "Link: <https://r-a-d.io/admin/news/:id|:title>",
		],
		"edit" => [
			"title" => "{$radio_slack} edited a news article",
			"body" => "Link: <https://r-a-d.io/admin/news/:id|:title>",
		],
		"delete" => [
			"title" => "{$radio_slack} deleted a news article",
			"body" => "Link: <https://r-a-d.io/admin/news/:id|:title>",
		],
	],
	"user" => [
		"add" => [
			"title" => "{$radio_slack} added a new user",
			"body" => "<https://r-a-d.io/admin/users/:id|:user>",
		],
		"edit" => [
			"title" => "{$radio_slack} edited a user",
			"body" => "<https://r-a-d.io/admin/users/:id|:user>",
		],
		"delete" => [
			"title" => "{$radio_slack} deleted a user",
			"body" => "<https://r-a-d.io/admin/users/:id|:user>",
		],
	],
	"pending" => [
		// technically track.add
		"accepted" => [
			"title" => "{$radio_slack} just accepted a song",
			"body" => "Added: <https://r-a-d.io/admin/song/:id|:artist - :track>",
		],
		// fired by pending.delete
		"declined" => [
			"title" => "{$radio_slack} just declined a song",
			"body" => "Link: <https://r-a-d.io/admin/deleted-songs/:id|:meta>\nReason: :reason",
		],

		// custom event. note: todo
		"replaced" => [
			"title" => "{$radio_slack} just replaced a song",
			"body" => "Replaced: <https://r-a-d.io/admin/song/:id|:artist - :track>",
		],

		// technically pending.add
		"uploaded" => [
			"title" => "New song uploaded",
			"body" => "<https://r-a-d.io/admin/pending#:id|Link>",
		],
	],
	"track" => [
		"update" => [
			"title" => "{$radio_slack} just updated a track",
			"body" => "Updated: <https://r-a-d.io/admin/song/:id|:artist - :track>"
		],
	],


];
