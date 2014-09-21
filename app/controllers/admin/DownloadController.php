<?php

class DownloadController extends BaseController {

	use SongTrait;

	protected $layout = "admin";
	
	/**
	 * Get a pending song by its ID
	 * 
	 * @param $id int
	 * @return File
	 */
	public function getPendingSong($id) {
		$pending = Pending::findOrFail($id);

		try {
			
			$this->sendFile($pending);

		} catch (Exception $e) {
			return Response::json([
				"error" => $e->getMessage(),
				"trace" => $e->getTraceAsString(),
				"line"  => $e->getLine(),
				"file"  => $e->getFile(),
			]);
		}

	}

	/**
	 * Fetch a song's file from its ID
	 * 
	 * @param $search string
	 * @return File
	 */
	public function getSong($id) {
		$track = Track::findOrFail($id);

		if ($track) {
			try {

				$this->sendFile($track, false);

			} catch (Exception $e) {
				return Response::json(["error" => get_class($e) . ": " . $e->getMessage()]);
			}
			
		}
	}
}