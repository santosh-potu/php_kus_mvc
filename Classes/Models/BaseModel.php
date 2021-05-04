<?php
namespace Kus\Models;

use Kus\Db\DbConnection;

abstract class BaseModel {
    protected $_db;
    protected $_table_name;
    
    protected function __construct($args = null) {
        $this->_db = new DbConnection();
        $this->_table_name = $args['table_name'];
    }
}
