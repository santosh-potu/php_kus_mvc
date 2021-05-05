<?php
namespace Http;

use Http\Controllers\ErrorController;
use Http\Router;
use Http\Request;

/**
 * Description of Dispatcher
 *
 * @author spotu
 */
class Dispatcher {
    use \Kus\SingletonTrait;
    protected $_httpRouter;

    protected function __construct() {
        $this->_httpRouter = Router::getInstance();
    }
    public function dispatch($controller_name,$controller_method,$optional = 'null'){
        $controller_class = '\\Http\\Controllers\\' . $controller_name. 'Controller'; 
        
        if (class_exists($controller_class)) {
            $controller_inst = $controller_class::getInstance();
        } else {
            $controller_inst = ErrorController::getInstance();
            $controller_inst->methodNotFoundAction($this->_httpRouter->getRequestParams(), $optional);
            return false;
        }
        
        if (method_exists($controller_inst, $controller_method) &&
                is_callable(array($controller_inst, $controller_method), false)) {
            $controller_inst->$controller_method($this->_httpRouter->getRequestParams(),$optional);
        } else {
            $other_method_exits = self::isOtherMethodExists($controller_class,$controller_method); 
            $error_method = $other_method_exits? "methodNotAllowedAction":"methodNotFoundAction";
            ErrorController::getInstance()->$error_method($this->_httpRouter->getRequestParams());
        }
    }
    
    public static function isOtherMethodExists($controller_class,$controller_method){
        try{
            $controller_method = rtrim(rtrim($controller_method, 'Action'),
                            ucfirst(Request::getInstance()->getRequestMethod()));
            $method_list = (new \ReflectionClass($controller_class))->
                    getMethods(\ReflectionMethod::IS_PUBLIC );
            
            foreach($method_list as $method){
                if($method->isStatic()){
                    continue;
                }
                if(strpos($method->name,$controller_method) === 0 ){                    
                    return true;
                }
            }
        }catch(\Exception $ex){
            error_log($ex->getMessage());
            return false;
        }
    }
}
