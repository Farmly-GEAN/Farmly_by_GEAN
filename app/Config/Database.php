<?php
class Database {
    // 1. Database Credentials
    private $host = "localhost";
    private $db_name = "farmly"; // Ensure this matches your DBeaver DB name
    private $username = "postgres"; // Your DBeaver username
    private $password = "27579Ni@"; // Your DBeaver password
    public $conn;

    // 2. The Connection Function
    public function getConnection() {
        $this->conn = null;
        try {
            // Check if using PostgreSQL (pgsql) or MySQL (mysql)
            // Based on your previous screenshots, you are using PostgreSQL
            $dsn = "pgsql:host=" . $this->host . ";port=5432;dbname=" . $this->db_name;
            
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>