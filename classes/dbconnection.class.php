<?php

namespace Kus;

class DbConnection {

    protected $pdo;

    function __construct() {
        try {
            $this->pdo = \Kus\Application::getInstance()->getDbConnection();
        } catch (\PDOException $ex) {
            echo 'Connection failed:' . $ex->getMessage();
        }
    }

    function query($sql_statement, $bind_values = array(), $return_type = GET_RECORDSET, $fetch_style = \PDO::FETCH_BOTH) {

        if (!trim($sql_statement)) {
            return false;
        }
        $this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, true);
        try {
            $stmt = $this->pdo->prepare($sql_statement);
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

    function insert($table_name, $data) {

        if (!strlen(trim($table_name)) || !( count($data) && is_array($data))) {
            return ['error' => true];
        }
        $question_marks[] = '(' . $this->placeholders('?', sizeof($data)) . ')';
        $insert_values = array_values($data);
        $sql = "INSERT INTO $table_name (" . implode(",", array_keys($data)) . ") VALUES " .
                implode(',', $question_marks);

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($insert_values);
            $result['row_count'] = $stmt->rowCount();
            $result['id'] = $this->pdo->lastInsertId();
        } catch (\PDOException $ex) {
            error_log($ex->getMessage());
            $result['error'] = $ex->getMessage();
        }

        return $result;
    }

    function update($table_name, $update_column, $where_column, $limit_num = "") {

        if (!$table_name || !is_array($update_column)) {
            return false;
        }
        $this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, true);
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
            $stmt = $this->pdo->prepare($update_query);
            $stmt->execute($bindings);
            $result = $stmt->rowCount();
        } catch (\Exception $ex) {
            error_log($ex->getMessage());
            $result = false;
        }
        return $result;
    }

    function delete($table_name, $where_column, $limit_num = "") {

        if (!$table_name) {
            return false;
        }
        $this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, true);
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
            $stmt = $this->pdo->prepare($delete_query);
            $stmt->execute($bindings);
            $result = $stmt->rowCount();
        } catch (\Exception $ex) {
            error_log($ex->getMessage());
            $result = false;
        }
        return $result;
    }

    function dmlQuery($query) {

        try {
            $result = $this->pdo->exec($query);
        } catch (\Exception $ex) {
            error_log($ex->getMessage());
            $result = false;
        }
        return $result;
    }

    function placeholders($text, $count = 0, $separator = ",") {
        $result = array();
        if ($count > 0) {
            for ($x = 0; $x < $count; $x++) {
                $result[] = $text;
            }
        }

        return implode($separator, $result);
    }

}
