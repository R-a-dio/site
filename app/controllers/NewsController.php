<?php

class NewsController extends BaseController {

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
	 * Generates the News HTML
	 *
	 * @param int id
	 * 
	 * @return string news articles
	 */

	private function fetchNews($id = FALSE) {

		if ( ! $id ) {
			$results = DB::select('SELECT * FROM `news` ORDER BY news.time desc limit 10');
		} else {
			$results = DB::select('SELECT * FROM `news` where news.id=?', [(int) $id]);
		}



		$news = "";
		$in = " in";
		$count = 0;

		foreach ($results as $result) {

			// TODO: commenting
			if ($count == 1)
				$in = "";

			$count++;

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
							{$result["newstext"]}
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
