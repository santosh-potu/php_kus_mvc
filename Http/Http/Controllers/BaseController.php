<?php

namespace Http\Controllers;

use Http\Request;

class BaseController {

    protected static $_selfInstances;
    protected $_view;
    protected $_request;

    protected function __construct() {
        $this->_view = new \Kus\BaseView();
        $this->_request = Request::getInstance();
    }

    public static function getInstance() {
        $calledClass = get_called_class();
        if (!isset(self::$_selfInstances[$calledClass])){
            self::$_selfInstances[$calledClass] = new $calledClass();
        }

        return self::$_selfInstances[$calledClass];
    }

    public function indexAction($args = null, $optional = null) {
        $this->_view->render('index', $args);
    }
    
    protected function loadModel($model,$args = null){
        try{
            $modelName = $model.'Model';
            $modelClass = "Kus\\Models\\{$modelName}";
            $this->$modelName = (new \ReflectionClass($modelClass))->newInstance($args);
        }catch(\Exception $ex){
            error_log($ex->getMessage());
            return false;
        }
        return $this->$modelName;
    }

}