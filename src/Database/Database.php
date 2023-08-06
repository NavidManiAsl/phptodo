<?php
use PDO;
use PDOException;

class Database {

    public function __construct(
        public $port, 
        public $dbName, 
        public $userName,
        public $password ){}

    static function connect ($port, $dbName, $userName, $password){
        try{
            $dsn = "mysql:host=localhost;port={$port};dbname={$dbName}";
            $pdo = new PDO($dsn, $userName, $password);
        } catch(PDOException $e){
            echo "an error occurred: ". $e->getMessage();
        }
        return $pdo;

    }
    }