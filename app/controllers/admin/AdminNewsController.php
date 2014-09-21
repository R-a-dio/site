<?php

class AdminNewsController extends BaseController {

	protected $layout = "admin";

	public function __construct() {
		$this->beforeFilter("auth.news");
		parent::__construct();
	}

	/**
	 * Get all news posts, or a specific one.
	 *   Developers can view deleted posts.
	 *
	 * @param $id int
	 * @return void
	 */
	public function getIndex($id = null) {

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

	/**
	 * Add a news post.
	 *
	 * @return void
	 */
	public function postIndex() {
		$title = Input::get("title");
		$text = Input::get("text");
		$header = Input::get("header");
		$user = Auth::user();
		$private = Input::get("private");

		if (!$user->canPostNews()) {
			return Redirect::to("/admin/news/$id")
				->with("status", "I can't let you do that.");
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
			} catch (Exception $e) {
				$status = $e->getMessage();
			}
			
		}

		return Redirect::to("/admin/news")
			->with("status", $status);

	}

	/**
	 * Update an existing news post.
	 *
	 * @param $id int
	 * @return void
	 */
	public function putIndex($id) {
		$title = Input::get("title");
		$text = Input::get("text");
		$header = Input::get("header");
		$private = Input::get("private");
		$user = Auth::user();

		if (!Auth::user()->canPostNews()) {
			return Redirect::to("/admin/news/$id")
				->with("status", "I can't let you do that.");
		} else {
			try {
				$post = Post::findOrFail($id);

				$post->title = $title;
				$post->header = $header;
				$post->text = $text;
				$post->private = $private;

				$post->save();

				$status = "News post $id updated.";
				
			} catch (Exception $e) {
				$status = $e->getMessage();
			}
			
		}

		return Redirect::to("/admin/news/$id")
			->with("status", $status);

	}

	/**
	 * Soft-delete a news post.
	 *   They're never properly deleted.
	 *
	 * @param $id int
	 * @return void
	 */
	public function deleteIndex($id) {
		$user = Auth::user();
		$status = "Nope.";
		if ($user->isAdmin()) {
			try {
				$post = Post::findOrFail($id);
				$title = $post->title;
				$post->delete();
				$status = "Post Deleted.";
				
			} catch (Exception $e) {
				$status = $e->getMessage();
			}
		}

		return Redirect::to("/admin/news")
			->with("status", $status);
	}
}
