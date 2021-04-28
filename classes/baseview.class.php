<?php
namespace Kus;

class BaseView{
    protected  $router;
    protected $request_params;
    protected $params ;
    
    public function __construct() {
        $this->router = \Kus\Router::getInstance();
        $this->request_params = $this->router->getRequestParams();
    }
    
    public function render($template,$args){
        $this->params = $args;
        $template_path = '..'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.
                $template.'.php';
        require_once $template_path;
    }
    
    public function getRouter(){
        return $this->router;
    }
}