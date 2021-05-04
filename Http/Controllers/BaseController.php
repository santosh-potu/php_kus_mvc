<?php

namespace Http\Controllers;

class BaseController {

    protected static $self_instances;
    protected $view;

    protected function __construct() {
        $this->view = new \Kus\BaseView();
    }

    public static function getInstance() {
        $calledClass = get_called_class();
        if (!isset(self::$self_instances[$calledClass])){
            self::$self_instances[$calledClass] = new $calledClass();
        }

        return self::$self_instances[$calledClass];
    }

    public function indexAction($args = null, $optional = null) {
        $this->view->render('index', $args);
    }
    
    public function loadModel($model,$args = null){
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