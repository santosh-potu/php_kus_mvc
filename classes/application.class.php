<?php
namespace Kus;

class Application{
    
    protected static $db;
    protected static $self_inst;
    
    
    private function __construct(){
        self::$db = $this->getDbConnection();
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
        if(!isset(self::$db)){
            try{
                self::$db = new \PDO(PDO_DSN, DB_USER,DB_PWD);
                self::$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                self::$db->query('SET CHARSET '.CHARSET); //Setting character set
            }catch(\PDOException $ex){
                echo 'Connection failed:'.$ex->getMessage();
            }
        }
        return self::$db;
    }
}