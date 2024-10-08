<?php

class Database {
    private $host = "localhost";
    private $port = "3306";
    private $db_name = "warehouse_msib";
    private $username = "root";
    private $password = ""; 
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";port=" . $this->port;

            $this->conn = new PDO($dsn, $this->username, $this->password);
            
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch (PDOException $e) {
            echo "Koneksi gagal: " . $e->getMessage();
            return null;
        }
    }
}
?>
