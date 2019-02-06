<?php

trait SongTrait {
	
	public function getSong($b64="") {
		// this will probably throw an exception on anything strange
		if($b64 === "")
			App::abort(404);
		$decoded = base64url_decode($b64);
		$hash = bin2hex(daypass_crypt($decoded));
//		return $hash;
		$track = Track::where("hash", "=", $hash)->first();
		
		if ($track) {
			try {
				$this->sendFile($track);
			} catch (Exception $e) {
				return Response::json(["error" => $e->getMessage()]);
			}
		}
		App::abort(404);
	}
	
        protected function sendFile(SongInterface $song) {

                $headers = [
                        "Cache-Control" => "no-cache",
                        "Content-Description" => "File Transfer",
                        "Content-Type" => $song->file_type,
                        "Content-Transfer-Encoding" => "binary",
                        "Content-Length" => $song->file_size,
                        "Content-Disposition" => "attachment; filename=\"" . $song->file_name . "\"",
                ];

                $response = Response::make('', 200, $headers);

                Session::save();

                // send the file
                $fp = fopen($song->file_path, 'rb');

                if ($fp) {
                        // fire headers and clean the output buffer
                        ob_end_clean();
                        $response->sendHeaders();
                        fpassthru($fp);
                }

                exit;
        }


	// Copied this here from AdminSongs; is there a better way?
	protected function sendxFile(array $song, $pending = true) {
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
