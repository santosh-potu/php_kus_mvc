<?php

namespace Kus;

class BaseView {

    protected $_router;
    protected $_requestParams;
    protected $_params;

    public function __construct() {
        $this->_router = \Kus\Router::getInstance();
        $this->_requestParams = $this->_router->getRequestParams();
    }

    public function render($template, $args) {
        $this->_params = $args;
        $template_path = '..' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR .
                $template . '.php';
        require_once $template_path;
    }

    public function getRouter() {
        return $this->_router;
    }
    
    /**
     * Renders Json data
     * 
     * @param array $data
     * @param int $http_response_code
     * @param int $flags
     * @param int $depth
     * @return type
     */
    public function renderJson($data,$http_response_code = 200,$flags = 0 ,$depth = 512) {
        http_response_code($http_response_code);
        header('Content-Type: application/json');
        echo json_encode($data, $flags, $depth);
    }

}
