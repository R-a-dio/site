<?php

trait AdminNews {
	// =======================
	// NEWS
	// =======================

	public function getNews($id = null) {

		if ($id) {
			if (Auth::user()->isDev()) {
				$news = Post::withTrashed()
					->findOrFail($id)
					->load("author");
			} else {
				$news = Post::findOrFail($id)
					->load("author");
			}
		} else {
			if (Auth::user()->isDev()) {
				$news = Post::with("author")
					->withTrashed()
					->orderBy("id", "desc")
					->paginate(15);
			} else {
				$news = Post::with("author")
					->orderBy("id", "desc")
					->paginate(15);
			}
			
		}

		$this->layout->content = View::make("admin.news")
			->with("news", $news)
			->with("id", $id);
	}

	public function postNews() {
		$title = Input::get("title");
		$text = Input::get("text");
		$header = Input::get("header");
		$user = Auth::user();
		$private = Input::get("private");

		if (!$user->canPostNews()) {
			Session::flash("status", "I can't let you do that.");
		} else {
			try {
				$post = Post::create([
					"user_id" => $user->id,
					"title" => $title,
					"text" => $text,
					"header" => $header,
					"private" => $private,
				]);
				

				$status = "News post added.";
				Notification::news("added news post \"$title\" ({$post->id})", $user);
				Queue::push("SendMessage", ["text" => "@channel <https://r-a-d.io/admin/users/{$user->id}|{$user->user}> posted a news article: <https://r-a-d.io/news/{$post->id}|{$title}>", "channel" => "#aaaaaaahn", "username" => "news"]);
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
		$user = Auth::user();

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
				Notification::news("updated news post \"{$post->title}\" $id", $user);
				Queue::push("SendMessage", ["text" => "<https://r-a-d.io/admin/users/{$user->id}|{$user->user}> updated a news article: <https://r-a-d.io/news/{$post->id}|{$title}>", "channel" => "#logs", "username" => "news"]);
			} catch (Exception $e) {
				$status = $e->getMessage();
			}
			
		}

		return Redirect::to("/admin/news/$id")
			->with("status", $status);

	}

	public function deleteNews($id) {
		$user = Auth::user();
		if ($user->isAdmin()) {
			try {
				$post = Post::findOrFail($id);
				$title = $post->title;
				$post->delete();

				$status = "Post Deleted.";
				Notification::news("soft-deleted news post \"$title\" ($id)", Auth::user());
				Queue::push("SendMessage", ["text" => "<https://r-a-d.io/admin/users/{$user->id}|{$user->user}> deleted a news article: <https://r-a-d.io/admin/news/{$id}|{$title}>", "channel" => "#logs", "username" => "news"]);
			} catch (Exception $e) {
				$status = $e->getMessage();
			}
		}

		return Redirect::to("/admin/news")
			->with("status", $status);
	}
}
