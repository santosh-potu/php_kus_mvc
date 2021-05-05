<?php
namespace Kus;

class Application{
    
    use \Kus\SingletonTrait;
    protected static $_db;
    protected static $_httpRouter;
    
    protected function __construct(){
        self::$_db = $this->getDbConnection();
    }
    
    public function getDbConnection(){
        if(!isset(self::$_db)){
            try{
                self::$_db = new \PDO(PDO_DSN, DB_USER,DB_PWD);
                self::$_db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                self::$_db->query('SET CHARSET '.CHARSET); //Setting character set
            }catch(\PDOException $ex){
                echo 'Connection failed:'.$ex->getMessage();
            }
        }
        return self::$_db;
    }
    
    public function getHttpRouter(){
        if(!isset(self::$_httpRouter)){
            self::$_httpRouter = \Http\Router::getInstance();
        }
        return self::$_httpRouter;
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