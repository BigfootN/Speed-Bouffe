<?php

final class Database {
	private $dbh;
	private static $instance = null;

	public Database() {
		private function __construct($servername, $user, $pwd, $dbname) {
			$dsn = "mysql:dbname=" . $dbname . ";host=" . $servername;

			try {
				$dbh = new PDO($dsn, $user, $pwd);
			} catch (PDOException e) {
				echo "Connection failed: " . $e->getMessage();
			}
		}

		public static Instance($servername, $user, $pwd, $dbname) {
			if ($instance === null)
				$instance = new Database($servername, $user, $pwd, $dbname);
		}

		function __destruct() {
			$conn->close();
		}

		public function getClientId($client_name, $client_first_name) {
			$sql = "SELECT client_id FROM client WHERE name = :name AND first_name = :first_name";
			$ret = 0;

			$dbh->beginTransaction();
			$sth = $dbh->prepare($sql);

			$sth->bindParam(":name", $client_name);
			$sth->bindParam(":first_name", $client_first_name);

			$sth->execute();
			$result = $sth->fetchAll();

			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				$ret = $row["client_id"];
			}

			return $ret;
		}

		public function addClient($gender, $name, $first_name, $age, $email) {
			$gender = (strcmp($gender, "Madame") === 0) ? 1 : 0;
			$sql = "INSERT INTO client (gender, name, first_name, age, email) VALUES (?, ?, ?, ?, ?)";

			$dbh->beginTransaction();
			$sth = $dbh->prepare($sql);

			$sth->execute(array(
				$gender,
				$name,
				$first_name,
				$name,
				$age,
				$email
			));

			$dbh->commit();
		}

		public function addBuyer($client_name, $client_first_name) {
			$id = get_client_id($client_name, $client_first_name);
			$sql = 'INSERT INTO buyer (client_id_fk) VALUES (?)';

			$dbh->beginTransaction();
			$sth = $dbh->prepare($sql);

			$sth->execute(array($id));

			$dbh->commit();
		}

		public function addInfoOrder($order_day, $delivery_time, $cash, $buyer_id) {
			$sql = "INSERT INTO info_order (order_day, delivery_time, cash, buyer_id_fk) VALUES (?, ?, ?, ?)";

			$dbh->beginTransaction();
			$sth = $dbh->prepare($sql);

			$sth->execute(array(
				$order_day,
				$delivery_time,
				$cash,
				$buyer_id_fk
			));

			$dbh->commit();
		}

		public function addOrder($meal, $rate, $info_order_id, $client_id) {
			$sql = "INSERT INTO `order` (meal, rate, info_order_id_fk, client_id_fk) VALUES (?, ?, ?, ?)";

			$dbh->beginTransaction();
			$sth = $dbh->prepare($sql);

			$sth->execute(array(
				$meal,
				$rate,
				$info_order_id,
				$client_id
			));

			$dbh->commit();
		}
	}
}

?>