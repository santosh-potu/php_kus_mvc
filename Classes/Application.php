<?php
namespace Kus;

class Application{
    
    protected static $db;
    protected static $self_inst;
    protected static $router;
    
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
    
    public function getRouter(){
        if(!isset(self::$router)){
            self::$router = \Kus\Router::getInstance();
        }
        return self::$router;
    }
    
    /**
     * Flushes out put buffer
     */
    public function flushOb(){
        if(OB_START){
            // Put all of the above ouptut into a variable
            // This has to be before you "clean" the buffer
            $content = ob_get_contents();  
            // Erase the buffer in case we want to use it for something else later
            ob_end_clean();
            // All of the data that was in the buffer is now in $content
            echo $content;
        }
    }
}