<?php

namespace App\Core;

use FFI\Exception;
use \PDO;
use \PDOException;

class Model {
    private $host = "localhost";
    private $user = "";
    private $password = "";
    private $dbName = "scandiweb";

    protected function connect()
    {
        try{
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbName;
        $pdo = new PDO($dsn, $this->user, $this->password);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
        return $pdo;
        }catch(PDOException $e){
            die($e->getMessage()."Database connection went wrong");
        }
    }
}