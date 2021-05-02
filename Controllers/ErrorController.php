<?php
namespace Controllers;

class ErrorController extends BaseController{
    
    public function indexAction($args = null, $optional = null) {
        $this->view->render('404',$args);
    }
    
}

