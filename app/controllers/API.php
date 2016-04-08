<?php

class API extends Controller {

	use PlayerTrait;
	use AnalysisTrait;
	use HanyuuTrait;
	use DjImageTrait;
	use SongTrait;
	use SearchTrait;
	use RequestTrait;

	protected $limit;
	protected $offset = 0;
	protected $routes = ["tracks", "djs", "faves", "can-request", "request", "metadata", "dj-image", "song"];

	public function __construct() {
		$this->limit = Config::get("radio.api.limit", 25);
//		$this->beforeFilter('csrf', ["on" => "postRequest"]);
		$this->setupClient();
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
	protected function currentModelOutput() {
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

	public function getIndex() {
	 	$current = Cache::get($this->id(), null) ?: $this->currentModelOutput();
	  
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
	
	public function getSearch($query) {
		$limit = Input::get('limit', 20);
		$raw = $this->search($query ?: "", "track", "song-database", true);
		$total = $raw["hits"]["total"];
		$res = [];
		$start = (Paginator::getCurrentPage() - 1) * $limit;
		$raw = array_slice($raw["hits"]["hits"], $start, $limit);
		for ($i = 0; $i < count($raw); $i++) {
			$x = $raw[$i]["_source"];
			$res[] = [
				"artist" => $x["artist"],
				"title" => $x["title"],
				"id" => $x["id"],
				"lastplayed" => $x["lastplayed"],
				"lastrequested" => $x["lastrequested"],
				"requestable" => requestable($x["lastrequested"], $x["requests"]),
//				"token" => base64url_encode(daypass_crypt(hex2bin(substr($x["hash"], 0, 20))))
			];
		}
		$pag = Paginator::make($res, $total, $limit);
		return Response::json($pag);
	}
}
