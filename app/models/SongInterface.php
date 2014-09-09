<?php

interface SongInterface {
	public function getFilePathAttribute();
	public function getFileSizeAttribute();
	public function getFileTypeAttribute();
	public function getFileNameAttribute();
}
