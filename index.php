<?php


	if ($_ENV["RADIO_SERVER_CONFIG"])
		require("config/" . $_ENV["RADIO_SERVER_CONFIG"] . ".php");
	else
		require("config/development.php") or die("config can't be found! (or read)");



	require("functions/core.php");

	require("functions/news.php");
	require("functions/stats.php");
	require("functions/graph.php");
	require("functions/user.php");
	require("functions/routes.php");