<?php

use \HTMLPurifier;
use Michelf\MarkdownExtra;

class Markdown {

	protected static $markdown;
	protected static $config;
	protected static $purifier;
	protected static $booted = false;

	public static function boot() {
		// setup
		static::$markdown = new MarkdownExtra();
		static::$config = HTMLPurifier_Config::createDefault();

		// purifier config
		static::$config->set("Cache.DefinitionImpl", null);
		static::$config->set("HTML.Doctype", "HTML 4.01 Transitional");

		// markdown config
		static::$markdown->empty_element_suffix = ">";

		// set purifier config
		static::$purifier = new HTMLPurifier(static::$config);

		// signal booted
		static::$booted = true;
	}
	

	public static function render($markdown) {
		if (!static::$booted)
			static::boot();

		static::$markdown->no_markup = false;
		return static::$markdown->transform($markdown);
	}

	public static function comment($markdown) {
		if (!static::$booted)
			static::boot();

		
		// add 4chan-style quoting
		$comment = static::quotes($markdown);
		
		// remove markup
		static::$markdown->no_markup = true;

		// render
		$comment = static::$markdown->transform($comment);
		// purify
		$comment = static::$purifier->purify($comment);

		return static::links($comment);

	}
	
	public static function quotes($comment) {
		$comment = preg_replace("/>{2,}/", ">>", $comment);
		$links = preg_replace("/>>(\d+)/", '&gt;&gt;$1', $comment);
		return preg_replace("/^>([^>]+)$/m", '&gt;$1', $links);
	}

	public static function links($comment) {
		$links = preg_replace("/&gt;&gt;(\d+)/", '<a href="#$1" class="comment-link">&gt;&gt;$1</a>', $comment);
		return preg_replace("/^&gt;(.+)(<br>)?$/m", '<span class="text-success">&gt;$1</span>$2', $links);
	}

}
