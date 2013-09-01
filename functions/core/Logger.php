<?php

	class Logger {
		public static function exception($message, $exception) {
			if (DEBUG) {
				var_dump($exception);
				echo $message;
			} else {
				self::log("[EXCEPTION] " . date() . " $message\n" . $exception->getMessage());
			}
		}


		private static function log($message) {
			// TODO
			return;
		}
	}
