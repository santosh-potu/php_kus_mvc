<?php

namespace Kus\Db;

class PDOConnection extends DbConnection{

    protected $pdo;

    public function __construct($dsn = PDO_DSN, $username= DB_USER, $passwd = DB_PWD) {
        try {
            $this->pdo = new \PDO($dsn, $username, $passwd);
        } catch (\PDOException $ex) {
            echo 'Connection failed:' . $ex->getMessage();
        }
    }  
}