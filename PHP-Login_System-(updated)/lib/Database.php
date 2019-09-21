<?php  

	class Database{
		private $servername = "localhost";
		private $db_user = "root";
		private $db_pass = "";
		private $db_name = "db_login";

		public $conn;

		public function __construct(){

			if (!isset($this->conn)){
				try{
					$link = new PDO("mysql:host=".$this->servername. ";dbname=".$this->db_name, $this->db_user, $this->db_pass);

					$link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$link->exec("SET character set utf8");
					$this->conn = $link;

				}catch(PDOEception $e){
					die("Connection failed! ".$e->getMessage());

				}

			}

		} //__construct()



	} //end of Database class

?>