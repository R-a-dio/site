<?php

class SubmitController extends BaseController {

	use AnalysisTrait;

	public function getIndex() {
		$accepts = DB::table("postpending")
			->where("accepted", ">=", 1)
			->take(20)
			->orderBy("time", "desc")
			->get();

		$declines = DB::table("postpending")
			->where("accepted", "=", 0)
			->where("reason", "!=", "")
			->take(20)
			->orderBy("time", "desc")
			->get();

		$uploadTime = $this->checkUploadTime();
		$cooldown = time() - $uploadTime < $this->delay;

		if ($cooldown) {
			$message = trans("api.upload.cooldown", ["time" => time_ago($uploadTime)]);
		} else {
			$message = trans("api.upload.no-cooldown");
		}

		$this->layout->content = View::make($this->theme("submit"))
			->with("accepts", $accepts)
			->with("declines", $declines)
			->with("message", $message)
			->with("cooldown", $cooldown);
	}

	public function postIndex() {
		try {
			$file = Input::file("song");

			if ($file)
				$result = $this->addPending($file);
			else
				$result = "You need to add a file.";

			if (Request::ajax())
				return Response::json(["value" => $result]);

			return Redirect::to("/submit")
				->with("status", $result);
		} catch (Exception $e) {
			return Response::json(["value" => [
				"error" => $e->getTrace(),
				"success" => get_class($e) . ": " . $e->getMessage()
			]]);
		}
	}
}
