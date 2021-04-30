<?php
namespace Controllers;

class SampleController extends BaseController {

    protected $db;
    protected $response;

    protected function __construct() {
        $this->db = new \Kus\DbConnection;
        parent::__construct();
        
    }

    public function getRecordsAction($args = null, $optional = null) {

        $sql = "SELECT * FROM users";
        $data = $this->db->query($sql, [], GET_RECORD, \PDO::FETCH_ASSOC);
        $output = ['data' => $data?$data:null];
        $this->view->renderJson($output);
    }

    public function insertRecordAction($args = null, $optional = null) {

        $table_name = 'users';
        $data = array('Name' => 'test'. rand(), 'Email' => 'test'.rand().'@gmail.com', 'Pwd' => 'test@123');
        $result = $this->db->insert($table_name, $data);
        if(isset($result['error'])){
            $http_status_code = 500;
            $message = "Unable to insert";
        }else{
            $http_status_code = 201;
            $message = "Succefully inserted";
        }
        $output = ['message' => $message];
        $this->view->renderJson($output,$http_status_code);
    }

    public function updateRecordAction($args = null, $optional = null) {

        $table_name = 'users';
        $data = array('Name' => 'test'.rand(), 'Email' => "test".rand()."@gmail.com", 'Pwd' => 'test@123');
        $where_column = array('id' => $args[0]);
        $result = $this->db->update($table_name, $data, $where_column);
        if(!$result){
            $http_status_code = 400;
            $message = "Unable to update";
        }else{
            $http_status_code = 200;
            $message = "Succefully updated";
        }
        $output = ['message' => $message];
        $this->view->renderJson($output,$http_status_code);
    }

    public function deleteRecordAction($args = null, $optional = null) {

        $table_name = 'users';
        $where_column = array('id' => $args[0]);
        $result = $this->db->delete($table_name,$where_column);
        if(!$result){
            $http_status_code = 400;
            $message = "Unable to delete";
        }else{
            $http_status_code = 200;
            $message = "Succefully deleted";
        }
        $output = ['message' => $message];
        $this->view->renderJson($output,$http_status_code);
    }

}