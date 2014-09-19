<?php

use GetId3\Write\Id3v2 as Mp3Writer;
use GetId3\Write\MetaFlac as FlacWriter;

trait TagTrait {
	
	public function writeTags(Track $song = null) {
		if (is_null($song)) $song = $this;


		switch ($song->format) {
			case "flac":
				return $this->writeFlac($song);
				break;
			case "mp3":
				return $this->writeMp3($song);
				break;
			case "ogg":
			case "aac":
			case "alac":
			case "wav":
			case "":
			default:
				return null;
		}
	}

	protected function writeMp3(Track $song) {
		$writer = new TagWriter;
		$writer->majorversion = 4; // write ID3v2.4 tags
		$writer->filename = $song->file_path;
		$writer->tag_data = [
			"title" => $song->title,
			"artist" => $song->artist,
			"album" => $song->album,
			"internet_radio_station_name" => "R/a/dio <https://r-a-d.io>",
			"internet_radio_station_owner" => "R/a/dio <contact@r-a-d.io>",
			"tracknumber" => $song->id,
			"comment" => $song->tags,
		];

		return $writer->WriteID3v2();
	}

	protected function writeFlac(Track $song) {
		$writer = new FlacWriter;
		$writer->filename = $song->file_path;
		$writer->tag_data = [
			"title" => $song->title,
			"artist" => $song->artist,
			"album" => $song->album,
			"tracknumber" => $song->id,
			"comment" => $song->tags,
		];

		return $writer->WriteMetaFlac();
	}
}
