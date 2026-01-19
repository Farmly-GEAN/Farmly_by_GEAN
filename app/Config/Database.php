<?php
class Database {
    private $host = "localhost";
    private $db_name = "farmly";
    private $username = "postgres";
    private $password = "27579Ni@";
    public $conn;

    public function getConnection() {
        $this->conn = null;

        if (getenv('RAILWAY_ENVIRONMENT') || getenv('PGHOST') || getenv('POSTGRES_HOST')) {
            
            $this->host = getenv('PGHOST') ?: getenv('POSTGRES_HOST');
            
            $this->db_name = getenv('PGDATABASE') ?: getenv('POSTGRES_DB');
            
            $this->username = getenv('PGUSER') ?: getenv('POSTGRES_USER');
            
            $this->password = getenv('PGPASSWORD') ?: getenv('POSTGRES_PASSWORD');
            
            $port = getenv('PGPORT') ?: getenv('POSTGRES_PORT') ?: "5432";
            
        } else {
            $port = "5432";
        }

        try {
        
            $dsn = "pgsql:host=" . $this->host . ";port=" . $port . ";dbname=" . $this->db_name;
            
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch(PDOException $exception) {
            die("<strong>Database Connection Error:</strong> " . $exception->getMessage());
        }

        return $this->conn;
    }
}
?>