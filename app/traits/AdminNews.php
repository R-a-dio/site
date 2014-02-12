<?php

trait AdminNews {
	// =======================
	// NEWS
	// =======================

	public function getNews($id = null) {

		if ($id)
			$news = Post::findOrFail($id)
				->load("author");
		else
			$news = Post::with("author")->paginate(15);

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
				Post::create([
					"user_id" => Auth::user()->id,
					"title" => $title,
					"text" => $text,
					"header" => $header,
					"private" => $private,
				]);
				

				$status = "News post added.";
				Notification::news(Auth::user()->user . " just add news post"); 
			} catch (Exception $e) {
				$status = $e->getMessage();
			}
			
		}

		return Redirect::to("/admin/news")
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
				$post = Post::findOrFail($id);

				$post->title = $title;
				$post->header = $header;
				$post->text = $text;
				$post->private = $private;

				$post->save();

				$status = "News post $id updated.";
				Notification::news(Auth::user()->user . " just updated news post: $id"); 
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
				$post = Post::findOrFail($id);
				$post->delete();

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
