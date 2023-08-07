<?php
use PDO;
use PDOException;

class Database {

    public function __construct(
        public $port, 
        public $dbName, 
        public $userName,
        public $password ) {}

    private function connect()
    {
        try {
            $dsn = "mysql:host=localhost;port={$this->port};dbname={$this->dbName}";
            $pdo = new PDO($dsn, $this->userName, $this->password);
            return $pdo;
        } catch (PDOException $e) {
            echo "An error occurred: " . $e->getMessage();
            return null;
        }
    }

    public function getConnection(){
        return $this->connect();
    }
}
