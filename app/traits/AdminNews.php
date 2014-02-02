<?php

trait AdminNews {
	// =======================
	// NEWS
	// =======================

	public function getNews($id = null) {
		$news = DB::table("radio_news");

		if ($id)
			$news = $news->where("id", "=", $id)->first();
		else
			$news = $news->orderBy("id", "desc")->get();

		$this->layout->content = View::make("admin.news")
			->with("news", $news)
			->with("id", $id);
	}

	public function postNews() {
		$title = Input::get("title");
		$text = Input::get("text");
		$header = Input::get("header");
		$private = Input::get("private");

		if (!Auth::user()->canPostNews()) {
			Session::flash("status", "I can't let you do that.");
		} else {
			try {
				$id = DB::table("radio_news")
					->insert([
						"user_id" => Auth::user()->id,
						"created_at" => DB::raw("CURRENT_TIMESTAMP()"),
						"title" => $title,
						"text" => $text,
						"header" => $header,
						"private" => $private,
					]);
				

				$status = "News post added.";
				Notification::news(Auth::user()->user . " just add news post: [$id](/admin/news/$id)"); 
			} catch (Exception $e) {
				$status = $e->getMessage();
			}
			
		}

		return Redirect::to("/admin/news/$id")
			->with("status", $status);

	}

	public function putNews($id) {
		$title = Input::get("title");
		$text = Input::get("text");
		$header = Input::get("header");
		$private = Input::get("private");

		if (!Auth::user()->canPostNews()) {
			Session::flash("status", "I can't let you do that.");
		} else {
			try {
				DB::table("radio_news")
					->where("id", "=", $id)
					->update([
						"updated_at" => DB::raw("CURRENT_TIMESTAMP()"),
						"title" => $title,
						"text" => $text,
						"header" => $header,
						"private" => $private,
					]);
				

				$status = "News post $id updated.";
				Notification::news(Auth::user()->user . " just updated news post: [$id](/admin/news/$id)"); 
			} catch (Exception $e) {
				$status = $e->getMessage();
			}
			
		}

		return Redirect::to("/admin/news/$id")
			->with("status", $status);

	}

	public function deleteNews($id) {
		if (Auth::user()->isAdmin()) {
			try {
				DB::table("radio_news")
					->where("id", "=", $id)
					->update([
						"deleted_at" => DB::raw("CURRENT_TIMETAMP()"),
					]);
				$status = "Post Deleted.";
				Notification::news(Auth::user()->user . " just soft-deleted news post $id");
			} catch (Exception $e) {
				$status = $e->getMessage();
			}
		}

		return Redirect::to("/admin/news")
			->with("status", $status);
	}
}
