<?php
namespace Kus\Model;

use Kus\Db\DbConnection;

abstract class BaseModel {
    protected $db;
    
    protected function __construct() {
        $this->db = new DbConnection();
    }
}
