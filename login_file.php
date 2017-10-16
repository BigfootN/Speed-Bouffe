<?php

class LoginFile {
	private $fd;

	private $user;
	private $host;
	private $database;
	private $password;

	private const USER = 'User';
	private const PASSWORD = 'Password';
	private const HOSTNAME = 'Host';
	private const DATABASE = 'Database';

	private function saveInformation($line) {
		$info = $line[0];

		$line[1] = trim(preg_replace('/\s+/', '', $line[1]));
		switch($info) {
			case self::USER:
				echo "user\n";
				$this->user = $line[1];
				break;
			case self::PASSWORD:
				echo "pwd\n";
				$this->password = $line[1];
				break;
			case self::HOSTNAME:
				echo "host\n";
				$this->host = $line[1];
				break;
			case self::DATABASE:
				echo "db\n";
				$this->database = $line[1];
				break;
		}
	}

	private function parseLine($line) {
		$line_split = explode("=", $line);
		if ($line_split === false)
			return;

		if (count($line_split) < 2)
			return;

		$this->saveInformation($line_split);
	}

	public function __construct($file) {
		$fd = fopen($file, "r");
		while (($line = fgets($fd)) !== false) {
			$this->parseLine($line);
		}
	}

	public function getUser() {
		return $this->user;
	}

	public function getPassword() {
		return $this->password;
	}

	public function getDatabase() {
		return $this->database;
	}

	public function getHost() {
		return $this->host;
	}
}

?>