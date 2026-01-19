<?php
class Database {
    private $host = "localhost";
    private $db_name = "farmly"; 
    private $username = "postgres";
    private $password = "27579Ni@";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        if (getenv('PGHOST')) {
            $this->host = getenv('PGHOST');
            $this->db_name = getenv('PGDATABASE');
            $this->username = getenv('PGUSER');
            $this->password = getenv('PGPASSWORD');
            $port = getenv('PGPORT');
        } else {
            
            $port = "5432"; 
        }

        try {
            
            $dsn = "pgsql:host=" . $this->host . ";port=" . $port . ";dbname=" . $this->db_name;
            
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch(PDOException $exception) {
            
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>