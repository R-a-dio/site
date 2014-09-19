<?php

class API extends Controller {

	use PlayerTrait;
	use AnalysisTrait;
	use HanyuuTrait;
	use SongTrait;

	protected $limit;
	protected $offset = 0;
	protected $routes = ["tracks", "djs", "faves", "can-request", "request", "metadata", "dj-image", "song"];

	public function __construct() {
		$this->limit = Config::get("radio.api.limit", 25);
	}

	/**
	 * Primary response function. 
	 * 
	 * 
	 *
	 */
	protected function response(array $array, array $metadata = [], $id = "main") {
		$metadata["length"] = count($array);
		$metadata["offset"] = Input::get("offset", $this->offset);
		$metadata["limit"] = Input::get("limit", $this->limit);
		$metadata["routes"] = $this->routes;
		$metadata["stream"] = Config::get("radio.stream.url");
		$response = Response::json([$id => $array, "meta" => $metadata]);

		return $response;

	}

	protected function error($code) {
		return Response::json(["error" => $code]);
	}

	public function missingMethod($method = null) {
		return $this->error(404);
	}

	public function getPing() {
		return Response::json(["ping" => true]);
	}

	// normally this is in a model, using Status::current()
	protected function current() {
		$current = DB::table("streamstatus")->first();
		$dj = Dj::find($current["djid"]);

		$lastplayed = $this->getLastPlayedArray();
		foreach ($lastplayed as &$lp) {
			$lp["timestamp"] = $lp["time"];
			$lp["time"] = time_ago($lp["time"]);
		}

		$queue = $this->getQueueArray();
		foreach ($queue as &$q) {
			$q["timestamp"] = $q["time"];
			$q["time"] = time_ago($q["time"]);
		}

		$current["dj"] = $dj;
		unset($current["djid"]);
		$current["current"] = time();
		$current["queue"] = $queue;
		$current["lp"] = $lastplayed;

		// time-sensitive. contains timestamps that are hit hundreds of times per second.
		Cache::connection()->set(Cache::getPrefix() . $this->id(), serialize($current));
		Cache::connection()->expire(Cache::getPrefix() . $this->id(), 1);

		return $current;
	}

	protected function id() {
		// manual key because otherwise the redis instance is untouchable
		return "api:" . Request::url();
	}

	public function getMetadata($meta) {
		if (preg_match("/\(cv[.:] .+\)/i", $meta)) {
			$status = "api.metadata.cv";
		} elseif (preg_match("/\p{Han}/i", $meta)) {
			$status = "api.metadata.kanji";
		} elseif (" - " or !$meta) {
			$status = "api.metadata.missing";
		} else {
			$status = "api.metadata.success";
		}

		return Response::json(["status" => trans($status), "metadata" => $meta]);
	}

	public function getCanRequest() {
		$current = Cache::get($this->id(), null) ?: $this->currentModelOutput();
		if ($current["isafkstream"]) {
			return $this->response(["requests" => can_request(Input::server("REMOTE_ADDR"))]);
		}

		return $this->response(["requests" => false]);
	}

	public function getSong($b64) {
		// this will probably throw an exception on anything strange
		$decoded = base64url_decode($b64);
		$hash = bin2hex(daypass_crypt($decoded));
		
		$track = Track::find(["hash" => $hash]);
		
		if ($track) {
			try {
				$this->sendFile($track, false);
			} catch (Exception $e) {
				return Response::json(["error" => $e->getMessage()]);
			}
		}
	}

	public function getDjImage($id) {
		$dj = Dj::findOrFail($id);
		
		$path = Config::get("radio.paths.dj-images") . "/" . $dj->djimage;
		
		if (! File::exists($path)) {
			$resp = Response::make(File::get(public_path() . "/assets/dj_image.png"), 200);
		} else {
			$resp = Response::make(File::get($path), 200);
		}
		
		// Yes, I know it might be something else, but we don't know and honestly,
		// browsers don't care either.
		$resp->header('Content-type', 'image/png');
		
		return $resp;
	}

	public function getIndex() {
	 	$current = Cache::get($this->id(), null) ?: $this->current();
	  
		return $this->response($current);
	}

	public function getUserCooldown() {
		$uploadTime = $this->checkUploadTime();

		$response = [
			"cooldown" => $uploadTime,
			"now" => time(),
			"delay" => $this->delay,
		];

		if (time() - $uploadTime < $this->delay) {
			$response["message"] = trans("api.upload.cooldown", ["time" => time_ago($uploadTime)]);
		} else {
			$response["message"] = trans("api.upload.no-cooldown");
		}

		return Response::json($response);
	}
}
