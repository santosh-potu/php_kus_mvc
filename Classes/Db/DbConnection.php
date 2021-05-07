<?php

namespace Kus\Db;

class DbConnection {

    protected $_pdo;

    public function __construct() {
        try {
            $this->_pdo = \Kus\Application::getInstance()->getDbConnection();
        } catch (\PDOException $ex) {
            echo 'Connection failed:' . $ex->getMessage();
        }
    }  

    public function query($sql_statement, $bind_values = array(), $return_type = GET_RECORDSET, $fetch_style = \PDO::FETCH_BOTH) {

        if (!trim($sql_statement)) {
            return false;
        }
        $this->_pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, true);
        try {
            $stmt = $this->_pdo->prepare($sql_statement);
            $stmt->execute($bind_values);
            if ($return_type == GET_RECORDSET) {       //returns a 2-dimensional array
                $result = $stmt->fetchAll($fetch_style);
            } elseif ($return_type == GET_RECORD) {    //returns a 1-dimensional array
                $result = $stmt->fetch($fetch_style);
            } elseif ($return_type == GET_VALUE) {     //returns a value
                $result = $stmt->fetchColumn();
            }
            $stmt->closeCursor();
        } catch (\Exception $ex) {
            error_log($ex->getMessage());
            $result = false;
        }
        return $result;
    }

    public function insert($table_name, $data) {

        if (!strlen(trim($table_name)) || !( count($data) && is_array($data))) {
            return ['error' => true];
        }
        $question_marks[] = '(' . QueryHelper::placeholders('?', sizeof($data)) . ')';
        $insert_values = array_values($data);
        $sql = "INSERT INTO $table_name (" . implode(",", array_keys($data)) . ") VALUES " .
                implode(',', $question_marks);

        try {
            $stmt = $this->_pdo->prepare($sql);
            $stmt->execute($insert_values);
            $result['row_count'] = $stmt->rowCount();
            $result['id'] = $this->_pdo->lastInsertId();
        } catch (\PDOException $ex) {
            error_log($ex->getMessage());
            $result['error'] = $ex->getMessage();
        }

        return $result;
    }

    public function update($table_name, $update_column, $where_column, $limit_num = "") {

        if (!$table_name || !is_array($update_column)) {
            return false;
        }
        $this->_pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, true);
        $set_clause = " UPDATE $table_name SET ";
        $where_clause = $where_column ? " WHERE " : "";
        $limit_clause = $limit_num ? " LIMIT $limit_num " : "";
        foreach ($update_column as $key => $value) {
            $bindings[$key] = $value;
            $set_clause .= " $key = :$key,";
        }
        $set_clause = rtrim($set_clause, ',');
        if (is_array($where_column)) {
            $i = 0;
            foreach ($where_column as $key => $value) {
                $and_clause = ($i++ == 0 ? "" : " AND ");
                $where_clause .= " $and_clause $key = :where_$key ";
                $bindings['where_' . $key] = $value;
            }
        } else if (strlen($where_column) > 0) {
            $where_clause .= $where_column;
        }

        $update_query = " $set_clause $where_clause $limit_clause ";
        try {
            $stmt = $this->_pdo->prepare($update_query);
            $stmt->execute($bindings);
            $result = $stmt->rowCount();
        } catch (\Exception $ex) {
            error_log($ex->getMessage());
            $result = false;
        }
        return $result;
    }

    public function delete($table_name, $where_column, $limit_num = "") {

        if (!$table_name) {
            return false;
        }
        $this->_pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, true);
        $delete_clause = " DELETE  FROM $table_name ";
        $where_clause = $where_column ? " WHERE " : "";
        $limit_clause = $limit_num ? " LIMIT $limit_num " : "";

        if (is_array($where_column)) {
            $i = 0;
            foreach ($where_column as $key => $value) {
                $and_clause = ($i++ == 0 ? "" : " AND ");
                $where_clause .= " $and_clause $key = :where_$key ";
                $bindings['where_' . $key] = $value;
            }
        } else if (strlen($where_column) > 0) {
            $where_clause .= $where_column;
        }

        $delete_query = "$delete_clause $where_clause $limit_clause ";
        try {
            $stmt = $this->_pdo->prepare($delete_query);
            $stmt->execute($bindings);
            $result = $stmt->rowCount();
        } catch (\Exception $ex) {
            error_log($ex->getMessage());
            $result = false;
        }
        return $result;
    }

    public function dmlQuery($query) {
        try {
            $result = $this->_pdo->exec($query);
        } catch (\Exception $ex) {
            error_log($ex->getMessage());
            $result = false;
        }
        return $result;
    }
    
    public function insertBatch($table_name, $data) {

        if (!strlen(trim($table_name)) || !( count($data) && is_array($data))) {
            return ['error' => true];
        }
        $insert_values = array();
        foreach($data as $d){
            $question_marks[] = '('  . QueryHelper::placeholders('?', sizeof($d)) . ')';
            $insert_values = array_merge($insert_values, array_values($d));
        }
        $sql = "INSERT INTO $table_name (" . implode(",", array_keys($data[0])) . ") VALUES " .
                    implode(',', $question_marks);            
        try {
            $stmt = $this->_pdo->prepare($sql);
            $stmt->execute($insert_values);
            $result = $stmt->rowCount();
        } catch (\PDOException $ex) {
            error_log($ex->getMessage());
            $result['error'] = $ex->getMessage();
        }            
        return $result;
    }
}
