<?php

class Database{
    private $connection;
    private $statment;

    public function __construct() {
        $dsn = "pgsql:host=localhost;port=5432;dbname=web_php";
        try {
            $this->connection = new PDO($dsn, 'postgres', 'postgres');
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    public function query($sql, $params = []) {
        $this->statment  = $this->connection->prepare($sql);
        $this->statment->execute($params);
        return $this;
    }
    
    public function get(){
        return $this->statment->fetchAll(PDO::FETCH_ASSOC);
    }

    public function firstOrFail() {
        $result = $this->statment->fetch(PDO::FETCH_ASSOC);
        
        if(!$result){
            exit('No results found');
        }

        return $result;
    }
}