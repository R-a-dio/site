<?php

interface SongInterface {
	public function getMetaAttribute();
	public function getFilePathAttribute();
	public function getFileSizeAttribute();
	public function getFileTypeAttribute();
	public function getFileNameAttribute();
}
