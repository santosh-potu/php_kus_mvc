<?php

namespace Http;

use Http\Request;
use Http\Dispatcher;

class Router {

    use \Kus\SingletonTrait;
    
    protected $_requestStack;
    protected $_request;
    
    protected function __construct() {
        $request_path = (count(array_keys($_GET))) ? explode('/', trim(array_keys($_GET)[0], '/')) : null;
        if (!$request_path) {
            $request_path[0] = 'Index';
            $request_path[1] = 'index';
        }
        $this->_requestStack = $request_path;
        $this->_request = Request::getInstance();
    }

    public function route() {      
        $controller = $this->_requestStack[0]??null;
        $method = $this->_requestStack[1]??null;
        $request_method = ($this->_request->getRequestMethod() == 'get')?'':
                $this->_request->getRequestMethod();
        $method_name = ($method ? $method :'index').
                ucfirst($request_method).'Action';
        
        $jsonReq = Request::getInstance()->isJson();
        if($jsonReq){
            $optional = ['json' => $jsonReq];
        }else{
            $optional = null;
        }
        
        Dispatcher::getInstance()->dispatch($controller, $method_name, $request_method,$optional);
    }

    public function getControllerParam() {
        return $this->_requestStack[0];
    }

    public function getActionParam() {
        return $this->_requestStack[1];
    }

    public function getRequestParams() {
        return $this->_requestStack;
    }

}
