<?php
namespace Http\Controllers;

use Http\Request;

class ErrorController extends BaseController{
    
    public function methodNotFoundAction($args = null, $optional = null) {
        $request = Request::getInstance();
        if ( $request->isAjax()  || $request->isJson() ) {
            $data = ['message' => 'Method not found'];
            $this->_view->renderJson($data,404);
        }else{
            http_response_code(404);
            $this->_view->render('404',$args);
        }
    }
    
    public function methodNotAllowedAction($args = null, $optional = null) {
        $request = Request::getInstance();
        if ( $request->isAjax()  || $request->isJson() ) {
            $data = ['message' => 'Method not allowed'];
            $this->_view->renderJson($data,405);
        }else{
            http_response_code(405);
            $this->_view->render('405',$args);
        }
    }
    
}

