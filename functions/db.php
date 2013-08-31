<?php

	class DB extends PDO {

		private $dsn = "mysql:host={DB_HOST}:{DB_PORT}";
		private $user = DB_USER;
		private $pass = DB_PASS;


		public function __construct() {
			try {
				parent::__construct($this->dsn, $this->user, $this->pass);

				$this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			} catch (PDOException $e) {
				Logger::exception("Failed to connect to mysql: " . $e->getPrevious, $e);
			}
		}
	}

	// globally available for use.
	$db = new DB();