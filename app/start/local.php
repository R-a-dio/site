<?php

function parseRuby($text) {
	// ruby is provided in the format:
	// 感{かん}じ
	// Which becomes:
	// <ruby>
	//   <rb>感</rb>
	//   <rp>(</rp>
	//       <rt>かん</rt>
	//   <rp>)</rp>
	// </ruby>

	return preg_replace_callback(
		"/" . // start
		"(\p{Han})" . // kanji (japanese/chinese/anything)
		"\{" . // literal {
		"([^}]+)" . // anything other than }
		"\}" . // literal }
		"/", // end
		function($matches) {
			$kanji = $matches[1];
			$ruby = $matches[2];

			return
				"<ruby>" .
				"<rb>" . $kanji . "</rb>" .
				"<rp>(</rp>" .
					"<rt>" . $ruby . "</rt>" .
				"<rp>)</rp>" .
				"</ruby>";
		},
		$text
	);
}
