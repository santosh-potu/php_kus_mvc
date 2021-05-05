<?php
namespace Kus\Models;

class KusModel extends BaseModel {
    
    public function __construct($args = null) {
        $args['tableName'] = $args['tableName']??"users";
        parent::__construct($args);
    }
    
    public function getAll(){
        $records = null;
        $sql = "SELECT * FROM {$this->_tableName}";
        $data = $this->_db->query($sql, [], GET_RECORDSET, \PDO::FETCH_ASSOC);
        foreach($data as $record){
            $records[] = $record;
        }
        return $records;
    }
    
    public function createUser($data){
        return $this->_db->insert($this->_tableName,$data);
    }
    
    public function updateUser($data,$where_column) {
        return $this->_db->update($this->_tableName,$data,$where_column);
    }
    
    public function deleteUser($where_column) {
        return $this->_db->delete($this->_tableName,$where_column);
    }
}
