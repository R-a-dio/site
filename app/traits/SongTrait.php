<?php

trait SongTrait {
	
	protected function sendFile(SongInterface $song) {

		$headers = [
			"Cache-Control" => "no-cache",
			"Content-Description" => "File Transfer",
			"Content-Type" => $song->file_type,
			"Content-Transfer-Encoding" => "binary",
			"Content-Length" => $song->file_size,
			"Content-Disposition" => "attachment; filename=" . rawurlencode($song->file_name),
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
	
	
	
}
