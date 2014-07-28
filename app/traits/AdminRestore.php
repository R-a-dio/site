<?php

trait AdminRestore {
	
	public function getRestore($type, $id) {
		if (! Auth::user()->isDev())
			return Redirect::to("/admin");

		if ($type == "news") {
			$news = News::withTrashed()->find($id);
			$news->restore();

			Queue::push("SendMessage", [

			]);
		}
	}
}
