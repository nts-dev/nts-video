<?php

require_once '../../../config.php';

$host = $NTS_CFG->dbhost;
$user = $NTS_CFG->dbuser;
$pass = $NTS_CFG->dbpass;
$db = $NTS_CFG->dbname;

class Database
{

    private $host;
    private $user;
    private $pass;
    private $db;

    public $conn;

    function __construct($host, $user, $pass, $db)
    {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->db = $db;
    }


    public function getConnection()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname=" . $this->db, $this->user, $this->pass);

        } catch (PDOExeption $exception) {
            return "Conection Error: " . $exception->getMessage();
        }

        return $this->conn;
    }

}
