<?php
namespace Http\Controllers;

class SampleController extends BaseController {

    protected function __construct() {
        parent::__construct();
        $this->loadModel("Kus",['tableName' => 'users']); //optional table name
    }

    public function getRecordsAction($args = null) {
        $records = $this->KusModel->getAll();        
        $output = ['data' => $records];
        $this->_view->renderJson($output);
    }

    public function createUserPostAction($args = null) {
        $data = [
                'Name' => $this->_request->getParam('name'), 
                'Email' => $this->_request->getParam('email'),
                'Pwd' => $this->_request->getParam('pwd')
                ];
        $result = $this->KusModel->createUser($data);
        if(isset($result['error'])){
            $http_status_code = 500;
            $message = "Unable to insert";
        }else{
            $http_status_code = 201;
            $message = "Succefully inserted";
        }
        $output = ['message' => $message];
        $this->_view->renderJson($output,$http_status_code);
    }

    public function updateUserPutAction($args = null) {
        $data = [
                'Name' => $this->_request->getParam('name'), 
                'Email' => $this->_request->getParam('email'),
                'Pwd' => $this->_request->getParam('pwd')
                ];
        $result = $this->KusModel->updateUser($data, 
                                    ['id' => $this->_request->getParam('id')]
                                    );
        if(!$result){
            $http_status_code = 400;
            $message = "Unable to update";
        }else{
            $http_status_code = 200;
            $message = "Succefully updated";
        }
        $output = ['message' => $message];
        $this->_view->renderJson($output,$http_status_code);
    }

    public function deleteUserDeleteAction($args = null) {
        $result = $this->KusModel->deleteUser(['id' => $this->_request->getParam('id')]);
        if(!$result){
            $http_status_code = 400;
            $message = "Unable to delete";
        }else{
            $http_status_code = 200;
            $message = "Succefully deleted";
        }
        $output = ['message' => $message];
        $this->_view->renderJson($output,$http_status_code);
    }
    
    public static function static($param) {
        
    }
}