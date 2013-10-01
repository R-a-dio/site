<?php

class News extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| News Controller
	|--------------------------------------------------------------------------
	|
	| Generates a news block.
	| Sadly I have to touch HTML in a controller. It's just echoed out.
	| Models probably wont be added due to the complexity of the database.
	|
	|	Route::get('/news(/{id})?', 'NewsController@showNews', $id);
	|
	*/

	protected $layout = 'master';


	/**
	 * Formats news articles correctly for full-view
	 *
	 * @param string $text
	 * @param boolean $excerpt
	 * @return string formatted news
	 */
	private function formatNews($text, $excerpt = false) {
		// newlines to <br>. No damn XHTML allowed.
		$text  = nl2br($text, false);

		// temporary hack until news posts have an extract as well
		if (!$excerpt)
			$text = str_replace("TRUNCATE", "", $text);
		else
			$text = preg_replace("/TRUNCATE.*$/", "", $text);

		return $text;
	}



	/**
	 * Generates the News HTML
	 *
	 * @param int id
	 * @return string news articles
	 */
	private function fetchNews($id = false) {


		$results = DB::table('news')->orderBy('time', 'desc');

		if ($id)
			$results = $results->where('id', $id)->take(1);

		$results = $results->get();

		$news = "";
		$in = " in";
		$count = 0;

		foreach ($results as $result) {

			// TODO: commenting
			if ($count == 1)
				$in = "";

			$count++;

			$text = $this->formatNews($result["newstext"]);


			$news .= <<<NEWS
				<div class="panel panel-default">
					<div class="panel-heading">
					  <h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-news-{$result["id"]}">
						  {$result["header"]}
						</a>
					  </h4>
					</div>
					<div id="collapse-news-{$result["id"]}" class="panel-collapse collapse{$in}">
						<div class="panel-body">
							<span class="date">{$result["time"]}</span>
							{$text}
						</div>
					</div>
				</div>
NEWS;

		}

		if ( ! $news ) {
			App::abort(404);
		}

		return $news;

	}

	/**
	 * Setup the layout used by the controller, fetch news.
	 *
	 * @return void
	 */
	public function showNews($id = FALSE) {
		$news = $this->fetchNews($id);

		$this->layout->content = View::make($this->getTheme() . '.news')
			->with("news", $news);
	}

}
