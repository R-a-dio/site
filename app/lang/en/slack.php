<?php

/*
 * This file should not be translated unless you are working with a
 * custom installation of R/a/dio in another language and are using Slack.
 */

// sucky
$radio_slack = "<https://r-a-d.io/admin/users/:user|:name>";

return [

	"news" => [
		"add" => "@channel {$radio_slack} just posted a news article: <https://r-a-d.io/news/:id|:title>",
		"edit" => "{$radio_slack} edited a news article: <https://r-a-d.io/news/:id|:title>",
		"delete" => "{$radio_slack} deleted a news article: <https://r-a-d.io/admin/news/:id|:title>",
	],
	"user" => [
		"add" => "@channel {$radio_slack} added a new user: <https://r-a-d.io/admin/users/:id|:target>",
		"edit" => "{$radio_slack} edited a user: <https://r-a-d.io/admin/users/:id|:target>",
		"delete" => "@channel {$radio_slack} deleted a user: <https://r-a-d.io/admin/users/:id|:target>",
		"denied" => "@channel {$radio_slack} attempted to update permissions for <https://r-a-d.io/admin/users/:id|:target> (email: :email; privileges: :privileges)",
	],
	"pending" => [
		"accepted" => "{$radio_slack} just accepted <https://r-a-d.io/admin/song/:id|:meta [:album]> (:tags)",
		"declined" => "{$radio_slack} just declined <https://r-a-d.io/admin/deleted-songs/:id|:meta> with the reason \":reason\"",
		"replaced" => "{$radio_slack} just replaced <https://r-a-d.io/admin/song/:id|:meta>",
		"uploaded" => ":ip just uploaded <https://r-a-d.io/admin/pending#:id|:meta>, :sizeMB :format, :length (:comment)",
	],


];
