<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use ConnorVG\Slack\Slack;
use ConnorVG\Slack\SlackPayload;

class SlackCommand extends Command {
	protected $name = "slack:send";
	protected $description = "Send a message to slack.";

	public function fire() {
		$key = Config::get("app.slack.apikey", null);

		$body = $this->argument("body");
		$title = $this->argument("title");
		$color = $this->argument("color");

		if (!$key)
			$this->error("API Key is not set. Aborting.");

		$message = new SlackPayload(new Slack($key), [
			"command" => "chat.postMessage",
			"username" => "R/a/dio",
			"link_names" => "1",
			"parse" => "none",
			"channel" => "#logs",
			"icon_url" => "https://r-a-d.io/assets/logo_image_small.png",
			"text" => $title,
			"attachments" => [
				[
					"fallback" => "$title: $body",
					"text" => $body,
					"color" => $color,
				]
			],
		]);

		$response = $message->send();
	}

	public function getOptions() {
		return [];
	}

	public function getArguments() {
		return [
			["title", InputArgument::REQUIRED, "Title for the changelog", null],
			["body", InputArgument::REQUIRED, "Text to send", null],
			["color", InputArgument::OPTIONAL, "Color to mark the message", "B19CD9"],
		];
	}
}
