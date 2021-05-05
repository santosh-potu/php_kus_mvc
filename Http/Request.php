<?php
namespace Http; 

class Request {
    use \Kus\SingletonTrait;
    protected $_requestType;
    protected $_params;
    protected $_isJson;
    
    protected function __construct() {
        $this->_requestType = $this->setRequestType();
        $this->_params = $this->scanParams();
    }
    
    protected function scanParams(){
        $data = [];
        if(isset($_SERVER['CONTENT_TYPE']) && 
                $_SERVER['CONTENT_TYPE'] == 'application/json'){
            $json = file_get_contents('php://input');
            $data = json_decode($json,true);
            $this->_isJson = true;
        }
        $this->_params = $_REQUEST + $data;
        return $this->_params;
    } 
    
    public function getParam($name){
        return $this->_params[$name]; 
    }
    
    public function getParamByPos($num){
        return $_REQUEST[array_keys($this->_params)[--$num]];
    }
    
    protected function setRequestType(){
        $this->_requestType = strtolower($_SERVER['REQUEST_METHOD']);
        return $this->_requestType;
    }
    
    public function isJson(){
        return $this->_isJson;
    }
}
