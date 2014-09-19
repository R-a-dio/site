<?php

class NewsController extends BaseController {

	public function getIndex($id = false) {
		

		if ($id) {
			$news = Post::with("author")->findOrFail($id);
			if ($news["private"] and !Auth::check())
				App::abort(404);

			$comments = $news->comments->load("user");
		} else {
			$news = Post::with("author");

			if (!Auth::check() or !Auth::user()->canDoPending())
				$news = $news->where("private", "=", 0);

			$news = $news->orderBy("id", "desc")
				->paginate(15);
			$comments = null;
		}

		$this->layout->content = View::make($this->theme("news"))
			->with("news", $news)
			->with("id", $id)
			->with("comments", $comments ? $comments->reverse() : null);
	}

	public function postIndex($id) {

		$post = Post::findOrFail($id);

		$check = Comment::withTrashed()
			->where("ip", "=", Input::server("REMOTE_ADDR"))
			->orderBy("created_at", "desc")
			->first();

		// TODO: move logic to comment model instead
		if ($check
			and (
					(time() - strtotime($check->created_at) < (60 * 20))
					or
					($check->deleted_at ? time() - strtotime($check->deleted_at) < (60 * 60 * 6) : false)
				)
			and !Auth::check())
		{

			$status = "Slow the hell down, cowboy.";
			$response = ["status" => $status];

		} else {

			if (Input::has("comment")) {

				try {
					if (!Auth::check() and $this->isSpam(Input::get("comment"))) {
						throw new Exception("Go away brohamid.");
					}

					$comment = new Comment(["comment" => Input::get("comment"), "ip" => Input::server("REMOTE_ADDR")]);

					if (Auth::check()) {
						$comment->user_id = Auth::user()->id;
					}

					$post->comments()->save($comment);
					$status = "Comment posted!";
					$response = ["comment" => $comment->toArray(), "status" => $status];
				} catch (Exception $e) {
					$response = ["error" => $e->getMessage()];
					$status = $e->getMessage();
				}
				

			}
		}
		if (Request::ajax()) {
			return Response::json($response);
		} else {
			return Redirect::to("/news/$id")
				->with("status", $status);
		}

		
	}

	/**
	 * Deletes comments.
	 *
	 * @return void
	 */
	public function deleteIndex($id) {

		if (!Auth::check() and !Auth::user()->isAdmin())
			return Redirect::to("/news/$id");

		$post = Post::findOrFail($id);
		$comment = Input::get("comment");

		if ($comment and is_numeric($comment)) {

			try {
				$comment = Comment::find($comment);

				$comment->delete();
				$status = "Comment Deleted!";
				$response = ["status" => $status];
			} catch (Exception $e) {
				$response = ["error" => $e->getMessage()];
				$status = $e->getMessage();
			}
			

		}

		if (Request::ajax()) {
			return Response::json($response);
		} else {
			return Redirect::to("/news/$id")
				->with("status", $status);
		}

		
	}	
}
