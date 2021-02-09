<?php


class Database {

	private $db = "nts_site";
	private $username = "projectuser";
	private $password = "wgnd8b";

	public $conn;
	

	public function getConnection(){
		$this->conn = null;
		try{
			$this->conn = new PDO("mysql:host=localhost;dbname=" . $this->db, $this->username, $this->password);
			
		}catch(PDOExeption $exception){
			return "Conection Error: ". $exception->getMessage();
		}

		return $this->conn;
	}


}
