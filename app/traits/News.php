<?php

trait News {

	/**
	 * Formats news articles correctly for full-view
	 *
	 * @param string $text
	 * @param boolean $excerpt
	 * @return string formatted news
	 */
	protected function format_news($text, $excerpt = false) {
		// newlines to <br>. No damn XHTML allowed.
		$text  = nl2br($text, false);

		// temporary hack until news posts have an extract as well
		if (!$excerpt)
			$text = str_replace("TRUNCATE", "", $text);
		else
			$text = preg_replace("/TRUNCATE.*$/", "", $text);

		return $text;
	}

}
