<?php

namespace Kus;

use Http\Controllers\ErrorController;
use Http\Request;

class Router {

    use \Kus\SingletonTrait;
    
    protected $_requestStack;
    protected $_request;
    
    protected function __construct() {
        $request_path = (count(array_keys($_GET))) ? explode('/', trim(array_keys($_GET)[0], '/')) : null;
        if (!$request_path) {
            $request_path[0] = $request_path[1] = 'Index';
        }
        $this->_requestStack = $request_path;
        $this->_request = Request::getInstance();
    }

    public function route($controller = null, $method = null) {      
        ($controller) ?: $controller = $this->_requestStack[0]??null;
        ($method) ?: $method = $this->_requestStack[1]??null;
        $controller_class = '\\Http\\Controllers\\' . $controller. 'Controller';
        $jsonReq = Request::getInstance()->isJson();
        if($jsonReq){
            $optional = ['json' => $jsonReq];
        }else{
            $optional = null;
        }
        if (class_exists($controller_class)) {
            $controller_inst = $controller_class::getInstance();
        } else {
            $controller_inst = ErrorController::getInstance();
            $controller_inst->indexAction($this->getRequestParams(), $optional);
            return false;
        }

        $method_name = ($method ? $method :'index').'Action';
        if (method_exists($controller_inst, $method_name) &&
                is_callable(array($controller_inst, $method_name), false)) {
            $controller_inst->$method_name($this->getRequestParams());
        } else {
            ErrorController::getInstance()->indexAction($this->getRequestParams());
        }
    }

    public function getControllerParam() {
        return $this->_requestStack[0];
    }

    public function getActionParam() {
        return $this->_requestStack[1];
    }

    public function getRequestParams() {
        return array_slice($this->_requestStack, 2);
    }

}
