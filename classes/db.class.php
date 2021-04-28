<?php
namespace Kus;

class Db{
    
    private static $db = null;
    private static $self_inst = null;
    
    
    private function __construct()
    {
        try{
            $db = new \PDO(PDO_DSN, DB_USER,DB_PWD);
            $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $db->query("SET CHARSET utf8"); //test query
            self::$db = $db;
        }catch(\PDOException $ex){
            echo 'Connection failed:'.$ex->getMessage();
        }           
    }
    
    public static function getInstance(){
        if (self::$self_inst){
            return self::$self_inst;
        }else{
            self::$self_inst = new Application();
            return self::$self_inst;
        }
    }
    
    public function getDbConnection(){
        return self::$db;
    }

    public static function placeholders($text, $count = 0, $separator = ",") {
        $result = array();
        if ($count > 0) {
            for ($x = 0; $x < $count; $x++) {
                $result[] = $text;
            }
        }
    
        return implode($separator, $result);
    }

    public function dbQuery($sql_statement, $bind_values = array(), $return_type = GET_RECORDSET, $fetch_style = PDO::FETCH_BOTH) {
        $pdo = $this->getDbConnection();
        if (!trim($sql_statement)) {
            return false;
        }
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
        try {
            $stmt = $pdo->prepare($sql_statement);
            $stmt->execute($bind_values);
            if ($return_type == GET_RECORDSET) {       //returns a 2-dimensional array
                $result = $stmt->fetchAll($fetch_style);
            } elseif ($return_type == GET_RECORD) {    //returns a 1-dimensional array
                $result = $stmt->fetch($fetch_style);
            } elseif ($return_type == GET_VALUE) {     //returns a value
                $result = $stmt->fetchColumn();
            }
            $stmt->closeCursor();
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            $result = false;
        }
        return $result;
    }


}

