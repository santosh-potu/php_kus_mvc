<?php

namespace Controllers;

class SampleController extends BaseController {

    protected $db;

    protected function __construct() {
        $this->db = new \Kus\DbConnect;
        parent::__construct();
    }

    public function getRecordsAction($args = null, $optional = null) {

        $sql = "SELECT * FROM users";
        $data = $this->db->query($sql, [], GET_RECORD, \PDO::FETCH_ASSOC);
        echo json_encode($data);
    }

    public function insertRecordsAction($args = null, $optional = null) {

        $table_name = 'users';
        $data = array('Name' => 'test', 'Email' => 'test@gmail.com', 'Pwd' => 'test@123');
        $this->db->insert($table_name, $data);
        echo 'Records added';
    }

    public function updateRecordsAction($args = null, $optional = null) {

        $table_name = 'users';
        $data = array('Name' => 'test1122', 'Email' => 'test@gmail.com', 'Pwd' => 'test@123');
        $where_column = array('id' => '1');
        $this->db->update($table_name, $data, $where_column);
        echo 'Records updated';
    }

    public function deleteRecordsAction($args = null, $optional = null) {

        $table_name = 'users';
        $where_column = array('id' => '1');
        $this->db->delete($table_name, $where_column);
        echo 'Records deleted';
    }

}
