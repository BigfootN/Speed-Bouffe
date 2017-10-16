<?php

include 'login_file.php';

final class DatabaseN {
	private $dbh;
	private $loginFile;

	private static $user;
	private static $dbname;
	private static $host;
	private static $password;

	private static $instance = null;

	private static function isSameEntry($login_file) {
		if (self::$instance === null)
			return false;

		if (strcmp(self::$user, $login_file->getUser()) !== 0)
			return false;

		if (strcmp(self::$dbname, $login_file->getDatabase()) !== 0)
			return false;

		if (strcmp(self::$host, $login_file->getHost()) !== 0)
			return false;

		if (strcmp(self::$password, $login_file->getPassword()) !== 0)
			return false;

		return true;
	}

	private static function setLoginInfo($login_file) {
		self::$user = $login_file->getUser();
		self::$password = $login_file->getPassword();
		self::$host = $login_file->getHost();
		self::$dbname = $login_file->getDatabase();
	}

	private function initConn() {
		$dsn = "mysql:dbname=" . self::$dbname . ";host=" . self::$host;

		try {
			echo "dsn = " . self::$password . "\n";
			$this->dbh = new PDO($dsn, self::$user, self::$password);
		} catch (PDOException $e) {
			echo "Connection failed: " . $e->getMessage();
		}
	}

	private function __construct() {}

	public static function Instance($login_file_path) {

		$file = fopen($login_file_path, "r");
		$login_file = new LoginFile($login_file_path);
		if (self::$instance === null || !(self::$instance->isSameEntry($login_file))) {
			self::$instance = new DatabaseN();
			self::$instance->setLoginInfo($login_file);
			self::$instance->initConn();
		}

		return self::$instance;
	}

	public function query($sql, $class_name = null, $one = false) {
		$req = self::$instance->dbh->query($sql);
		if($class_name === null) {
			$req->setFetchMode(PDO::FETCH_OBJ);
		} else {
			$req->setFetchMode(PDO::FETCH_CLASS, $class_name);
		} if($one) {
			$datas = $req->fetch();
		} else {
			$datas = $req->fetchAll();
		}
		return $datas;
	}

	public function prepare($sql, $attributes, $class_name, $one = false) {
		$req = self::$instance->dbh->prepare($sql);
		$res = $req->execute($attributes);
		if(
			strpos($sql, 'UPDATE') === 0 ||
			strpos($sql, 'INSERT') === 0 ||
			strpos($sql, 'DELETE') === 0
		){
			return $res;
		}

		$req->setFetchMode(PDO::FETCH_CLASS, $class_name);
		if ($one) {
			$datas = $req->fetch();
		} else {
			$datas = $req->fetchAll();
		}

		return $datas;
	}

	public function exec($sql) {
		$req = $this->getPDO()->exec($sql);
		return $req;
	}

	function __destruct() {
		$conn->close();
	}
}

?>