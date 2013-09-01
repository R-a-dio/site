<?php

class NewsController extends BaseController {


	protected $layout = 'layouts.master';


	private function fetchNews($id = FALSE) {

		if ( ! $id ) {
			$results = DB::select('SELECT news.*, users.user FROM `news` LEFT JOIN users ON users.id = news.user_id ORDER BY news.time desc limit 10');
		} else {
			$results = DB::select('SELECT news.*, users.user FROM `news` LEFT JOIN users ON users.id = news.user_id where news.id=?', array((int) $id))
		}



		$news = "";

		foreach ($results as $result) {

			// TODO: commenting

			$news .= <<<NEWS
				<div class="panel panel-default">
					<div class="panel-heading">
					  <h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-news-{$result["id"]}>
						  {$result["title"]}
						</a>
					  </h4>
					</div>
					<div id="collapse-news-{$result["id"]} class="panel-collapse collapse">
						<div class="panel-body">
							<span class="date">{$result["time"]}</span>
							<span class="user">{$result["user"]}</span>
							{$result["body"]}
						</div>
					</div>
				</div>
NEWS;

		}

		if ( ! $news ) {
			App::abort(404);
		}

	}

	public function showNews() {
		$news = $this->fetchNews();

		$this->layout->content = View::make('news', array($news));
	}

	public function showSingleNews($id) {
		$news = $this->fetchNews($id);

		$this->layout->content = View::make('news', array($news))
	}

}
