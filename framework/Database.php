<?php

namespace Framework;
use PDO;
class Database{
    private $connection;
    private $statment;

    public function __construct() {
        // $dsn = "pgsql:host=localhost;port=5432;dbname=web_php";
        $dsn = sprintf(
            'pgsql:host=%s;port=%d;dbname=%s',
            config('host'),
            config('port'),
            config('dbname')
        );

        try {
            $this->connection = new PDO($dsn, config('username'), config('password'), config('options', []));
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
        return $this->statment->fetchAll();
    }
    
    public function first() {
        return $this->statment->fetch();
    }

    public function firstOrFail() {
        $result = $this->first();
        
        if(!$result){
            exit('No results found');
        }

        return $result;
    }

}