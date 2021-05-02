<?php

namespace Kus;

class Router {

    private static $self_inst = null;
    private $request_stack = null;

    private function __construct() {
        $request_path = (count(array_keys($_GET))) ? explode('/', trim(array_keys($_GET)[0], '/')) : null;
        if (!$request_path) {
            $request_path[0] = $request_path[1] = 'Index';
        }
        $this->request_stack = $request_path;
    }

    public static function getInstance() {
        if (self::$self_inst) {
            return self::$self_inst;
        } else {
            self::$self_inst = new Router();
            return self::$self_inst;
        }
    }

    public function route($controller = null, $method = null) {

        ($controller) ?: $controller = $this->request_stack[0];
        ($method) ?: $method = $this->request_stack[1];

        $controller_class = '\\Controllers\\' . ucfirst($controller) . 'Controller';
        if (class_exists($controller_class)) {
            $controller_inst = $controller_class::getInstance();
        } else {
            $controller_inst = \Controllers\ErrorController::getInstance();
            $controller_inst->indexAction($this->getRequestParams());
            return false;
        }

        $method_name = ($method ? $method :'index').'Action';
        if (method_exists($controller_inst, $method_name) &&
                is_callable(array($controller_inst, $method_name), false)) {
            $controller_inst->$method_name($this->getRequestParams());
        } else {
            \Controllers\ErrorController::getInstance()->indexAction($this->getRequestParams());
        }
    }

    public function getControllerParam() {
        return $this->request_stack[0];
    }

    public function getActionParam() {
        return $this->request_stack[1];
    }

    public function getRequestParams() {
        return array_slice($this->request_stack, 2);
    }

}
