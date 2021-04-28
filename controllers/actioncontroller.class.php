<?php
namespace Controllers;

class ActionController extends BaseController{

    public function getRecordsAction($args = null,$optional=null){
        $app = \Kus\Application::getInstance();
        $db = $app->getDbConnection();
        $sql = "SELECT users.*
                        FROM users;";
        $data = $db->db_query($sql, [], GET_RECORD, PDO::FETCH_ASSOC);
        return json_encode($data);

    }
    
}
