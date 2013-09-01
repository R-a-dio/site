<?php
	class SecureRandom {

		private $crypto;
		private $length;
		private $hash;


		public function __construct($crypto = TRUE, $length = 18, $hash = "sha384") {
			$this->crypto = $crypto;
			$this->length = $length;
			$this->hash = $hash;
		}

		public function random($length = $this->length) {
			// we dont want blocking /dev/random calls on a webserver.
			mcrypt_create_iv($length, MCRYPT_DEV_URANDOM);
		}

		public function salt($length = $this->length) {
			return substr(
						strtr(
							base64_encode(
								$this->random()
							), '+', '.'
						), 0, 22
					);
		}


		public function hmac($data, $key_len = 128) {
			return hash_hmac(
				$this->algo,
				$data,
				$this->random($length)
			);
		}


		public function hash() {
			// TODO
			return;
		}

		public function verify() {
			// TODO
			return;
		}

		public function csrf_token() {
			// TODO
			return;
		}

	}
