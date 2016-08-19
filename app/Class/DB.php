<?php

/**
*  Prisijungimas prie DB klase
*/
class DB{
	
	private $port = '';
	private $host       = Config::$HOST;
	private $database   = Config::$DATEBASE;
	private $d_user     = Config::$DB_USER;
	private $d_password = Config::$DB_PASSWORD;
	private $sql;
	private $connect;
	
		public function __construct() {
			try{
			$options = array(
				PDO::ATTR_PERSISTENT    => true,
				PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_EMULATE_PREPARES => false
			);
				$this->connect = new PDO("mysql:host=".$this->host.";port=".$this->port.";dbname=".$this->database, $this->d_user, $this->d_password, $options);
			}catch(PDOException $e) {
					die('Other Error!1 ');
				return false;
			}
		}
		public function query($query, $data) {
			if($this->connect != null) {
				try{
						$obj = $this->connect->prepare($query);
							foreach($data as $key => $value) {
								$obj->bindValue($key, $value, PDO::PARAM_INT | PDO::PARAM_STR);
							}
						$obj->execute();
					return $this->connect->lastInsertId();
				}catch(PDOException $e) {
					die('Other Error!2'.$e);
					return false;
				}
			}else{
				die('Other Error!3');
				return false;
			}
		}
		public function execute() {
			if($this->connect != null) {
				try{
						$this->connect->execute();
					return true;
				}catch(PDOException $e) {
					die('Other Error!4');
					return false;
				}
			}else{
				die('Other Error!5');
				return false;
			}
		}
		public function fetch($query, $data) {
			if($this->connect != null) {
				try{
						$obj = $this->connect->prepare($query);
							foreach($data as $key => $value) {
								$obj->bindValue($key, $value, PDO::PARAM_INT | PDO::PARAM_STR);
							}
							$obj->execute();
							$read_data = array();
								foreach(($obj->fetch(PDO::FETCH_ASSOC)) as $key => $value) {
									$read_data[$key] = $value;
								}
					return $read_data;
				}catch(PDOException $e) {
					die('Other Error!6'.$e);
					return false;
				}
			}else{
				die('Other Error!7');
				return false;
			}
		}
		public function fetchAll($query, $data) {
			if($this->connect != null) {
				try{
						$obj = $this->connect->prepare($query);
							foreach($data as $key => $value) {
								$obj->bindValue($key, $value, PDO::PARAM_INT | PDO::PARAM_STR);
							}
							$obj->execute();
							$read_data = array();
								foreach(($obj->fetchAll(PDO::FETCH_ASSOC)) as $key => $value) {
									$read_data[$key] = $value;
								}
					return $read_data;
				}catch(PDOException $e) {
					die('Other Error!8');
					return false;
				}
			}else{
				die('Other Error!9');
				return false;
			}
		}
		public function num_rows($query, $data) {
			if($this->connect != null) {
				try{
							$obj = $this->connect->prepare($query);
								foreach($data as $key => $value) {
									$obj->bindValue($key, $value, PDO::PARAM_INT | PDO::PARAM_STR);
								}
								$obj->execute();
						return $obj->rowCount();
				}catch(PDOException $e) {
					die('Other Error!10');
					return false;
				}
			}else{
				die('Other Error!11');
				return false;
			}
		}
		public function last_insert_record() {

		}
		public function close() {
			if($this->connect != null) {
				$this->connect = null;
			}else{
				die('Other Error!12');
				return false;
			}
		}
		public function __destruct() {
			$this->close();
		}
}


