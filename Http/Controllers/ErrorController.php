<?php
namespace Http\Controllers;

class ErrorController extends BaseController{
    
    public function indexAction($args = null, $optional = null) {
        if ( (isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
                && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) || 
                (isset($optional['json']) && $optional['json'] == 1) ) {
        // this is ajax request, do something
            $data = ['message' => 'Not found'];
            $this->_view->renderJson($data,404);
        }else{
            http_response_code(404);
            $this->_view->render('404',$args);
        }
    }
    
}

