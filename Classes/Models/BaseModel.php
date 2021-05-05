<?php
namespace Kus\Models;

use Kus\Db\DbConnection;

abstract class BaseModel {
    protected $_db;
    protected $_tableName;
    
    protected function __construct($args = null) {
        $this->_db = new DbConnection();
        $this->_tableName = $args['tableName'];
    }
}
