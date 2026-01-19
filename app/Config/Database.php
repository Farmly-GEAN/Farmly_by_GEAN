<?php
class Database {
    private $host = "localhost";
    private $db_name = "farmly";
    private $username = "postgres";
    private $password = "27579Ni@";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        $port = "5432"; 

        e
        if (getenv('DATABASE_URL')) {
            $url = parse_url(getenv('DATABASE_URL'));
            
            $this->host     = $url['host'];
            $this->username = $url['user'];
            $this->password = $url['pass'];
            $this->db_name  = ltrim($url['path'], '/'); 
            $port           = $url['port'];
            
        } 
        
        elseif (getenv('PGHOST') || getenv('POSTGRES_HOST')) {
            $this->host     = getenv('PGHOST') ?: getenv('POSTGRES_HOST');
            $this->db_name  = getenv('PGDATABASE') ?: getenv('POSTGRES_DB');
            $this->username = getenv('PGUSER') ?: getenv('POSTGRES_USER');
            $this->password = getenv('PGPASSWORD') ?: getenv('POSTGRES_PASSWORD');
            $port           = getenv('PGPORT') ?: getenv('POSTGRES_PORT') ?: "5432";
        }
        
        
        if (empty($this->host) && getenv('RAILWAY_ENVIRONMENT')) {
             die("<strong>Configuration Error:</strong> Could not find Database Host. Please check Railway Variables.");
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