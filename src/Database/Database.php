<?php
use PDO;
use PDOException;

class Database {

    public function __construct(
        public $port, 
        public $dbName, 
        public $userName,
        public $password ){}

    public function connect (){
        try{
            $dsn = "mysql:host=localhost;port={$this->port};dbname={$this->dbName}";
            $pdo = new PDO($dsn,$this->userName, $this->password);
        } catch(PDOException $e){
            echo "an error occurred: ". $e->getMessage();
        }
        return $pdo

    }
    }