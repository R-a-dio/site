<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use ConnorVG\Slack\Slack;

class SlackCommand extends Command {
	protected $name = "slack:send";
	protected $description = "Send a message to slack.";

	public function fire() {
		$key = Config::get("app.slack.apikey", null);
		$text = $this->argument("text");
		$channel = $this->argument("channel");
		$username = $this->argument("username");

		if (!$key)
			$this->error("API Key is not set. Aborting.");

		$slack = new Slack($key);

		$message = $slack->message($text, $channel);

		$message->username($username);
		$message->icon("https://r-a-d.io/assets/logo_image_small.png");

		$message->set("link_names", "1");
		$message->set("parse", "none");

		$response = $message->send();
	}

	public function getOptions() {
		return [];
	}

	public function getArguments() {
		return [
			["channel", InputArgument::REQUIRED, "Channel to send to", null],
			["username", InputArgument::REQUIRED, "Username to give the message", null],
			["text", InputArgument::REQUIRED, "Text to send to a given channel", null],
		];
	}
}
