<?php
// db.php

class Database {
    private $hostname = 'localhost';
    private $username = "root";
    private $password = "";
    private $dbname = "SubhanHotelDB";
    private $conn;

    public function __construct() {
        try {
            $dsn = "mysql:host={$this->hostname};dbname={$this->dbname}";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}
?>
