<?php

trait Songs {
	
	public function getSong($b64) {
		// this will probably throw an exception on anything strange
		$decoded = base64url_decode($b64);
		$hash = bin2hex(simpleDaypassDecrypt($decoded));
		
		$track = DB::table("tracks")->where("hash", "=", $hash)->first();
		
		if($track) {
			try {
				$this->sendFile($track, false);
			} catch (Exception $e) {
				return Response::json(["error" => $e->getMessage()]);
			}
		}
	}
	
	// Copied this here from AdminSongs; is there a better way?
	protected function sendFile(array $song, $pending = true) {
		$loc = "radio.paths." . ($pending ? "pending" : "music");
		$path = Config::get($loc) . "/" . $song["path"];
		$size = filesize($path);

		if (stripos($song["path"], ".flac")) {
			$type = "audio/x-flac";
		} else {
			$type = "audio/mpeg";
		}

		$headers = [
			"Cache-Control" => "no-cache",
			"Content-Description" => "File Transfer",
			"Content-Type" => $type,
			"Content-Transfer-Encoding" => "binary",
			"Content-Length" => $size,
			"Content-Disposition" => "attachment; filename=" . $song["path"],
		];

		$response = Response::make('', 200, $headers);

		Session::save();

		// send the file
		$fp = fopen($path, 'rb');

		if ($fp) {
			// fire headers and clean the output buffer
			ob_end_clean();
			$response->sendHeaders();
			fpassthru($fp);
		}

		exit;
	}
	
	
	
}
