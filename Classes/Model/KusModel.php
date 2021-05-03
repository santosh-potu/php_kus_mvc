<?php
namespace Kus\Model;

class KusModel extends BaseModel {
    protected $_table_name;
    public function __construct($args = null) {
        parent::__construct();
        $this->_table_name = $args['table_name']??"users";
    }
    
    public function getAll(){
        $records = null;
        $sql = "SELECT * FROM {$this->_table_name}";
        $data = $this->db->query($sql, [], GET_RECORDSET, \PDO::FETCH_ASSOC);
        foreach($data as $record){
            $records[] = $record;
        }
        return $records;
    }
    
    public function createUser($data){
        return $this->db->insert($this->_table_name,$data);
    }
    
    public function updateUser($data,$where_column) {
        return $this->db->update($this->_table_name,$data,$where_column);
    }
    
    public function deleteUser($where_column) {
        return $this->db->delete($this->_table_name,$where_column);
    }
}
