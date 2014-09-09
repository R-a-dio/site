<?php

trait SlackTrait {
	public $diffs = true;

	protected $hide = [
		"password",
	];

	public function getDiffs() {
		$before = $this->getOriginal();
		$after = $this->getDirty();
		$text = "";

		foreach ($after as $name => $change) {

			if (in_array($name, $this->hide))
				continue;

			if (! isset($before[$name])) {
				$previous = "?";
			} else {
				$previous = $before[$name];
			}
			$text .= slack_encode("$name: $previous -> $change\n");
		}

		return $text;
	}

	public function slack($code, array $extra = []) {
		$user = Auth::user();
		$title = trans("slack.$code.title", ["user" => slack_encode($user->user), "userid" => $user->id]);
		$body = trans("slack.$code.body", array_merge($this->toSlackArray(), $extra)) . "\n" . $this->getDiffs();

		Queue::push("SendMessage", [
			"title" => $title,
			"body" => $body,
		]);
	}

	public function toSlackArray() {
		$array = $this->toArray();

		foreach ($array as $key => &$value) {
			$value = slack_encode($value);
		}

		return $array;
	}

}
