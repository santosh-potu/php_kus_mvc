<?php
namespace Kus\Model;

class KusModel extends BaseModel {
    
    public function __construct($args = null) {
        $args['table_name'] = $args['table_name']??"users";
        parent::__construct($args);
    }
    
    public function getAll(){
        $records = null;
        $sql = "SELECT * FROM {$this->_table_name}";
        $data = $this->_db->query($sql, [], GET_RECORDSET, \PDO::FETCH_ASSOC);
        foreach($data as $record){
            $records[] = $record;
        }
        return $records;
    }
    
    public function createUser($data){
        return $this->_db->insert($this->_table_name,$data);
    }
    
    public function updateUser($data,$where_column) {
        return $this->_db->update($this->_table_name,$data,$where_column);
    }
    
    public function deleteUser($where_column) {
        return $this->_db->delete($this->_table_name,$where_column);
    }
}
