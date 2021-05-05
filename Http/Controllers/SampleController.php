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

    public function insertRecordAction($args = null) {
        $data = array('Name' => 'test'. rand(), 'Email' => 'test'.rand().'@gmail.com', 'Pwd' => 'test@123');
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

    public function updateRecordAction($args = null) {
        $data = array('Name' => 'test'.rand(), 'Email' => "test".rand()."@gmail.com", 'Pwd' => 'test@123');
        $result = $this->KusModel->updateUser($data, array('id' => $args[0]));
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

    public function deleteRecordAction($args = null) {
        $result = $this->KusModel->deleteUser(array('id' => $args[0]));
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
    
}