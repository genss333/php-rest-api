<?php
class Database
{
    private $pdo;

    public function __construct()
    {
        $host = 'localhost';
        $dbname = 'rest_api_demo';
        $username = 'root';
        $password = '';
        $con = new PDO('mysql:host=' . $host . '; dbname=' . $dbname . ';', $username, $password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo = $con;
        $this->pdo->exec("SET NAMES utf8mb4");
    }

    public function queryCustom($sql)
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function query($tableName)
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM' . $tableName);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw $e;
        }
    }

    function joinTables($arrTable, $joinConditions) {
        try {
            $tables = implode(" JOIN ", $arrTable);
            $joinString = implode(" AND ", $joinConditions);
    
            $query = "SELECT * FROM $tables ON $joinString";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw $e;
        }
    }
    

    function joinTablesCondion($arrTable, $joinConditions,$condition) {
        try {
            $tables = implode(" JOIN ", $arrTable);
            $joinString = implode(" ON ", $joinConditions);
            $query = "SELECT * FROM $tables ON $joinString WHERE $condition";
    
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw $e;
        }
    }


    public function insert($table, $data)
    {
        try {
            $columns = implode(', ', array_keys($data));
            $values = ':' . implode(', :', array_keys($data));
            $sql = "INSERT INTO $table ($columns) VALUES ($values)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($data);
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function update($table, $data, $condition)
    {
        try {
            $set = '';
            foreach ($data as $key => $value) {
                $set .= "$key = :$key, ";
            }
            $set = rtrim($set, ', ');

            $where = '';
            foreach ($condition as $key => $value) {
                $where .= "$key = :cond_$key AND ";
            }
            $where = rtrim($where, 'AND ');

            $sql = "UPDATE $table SET $set WHERE $where";
            $stmt = $this->pdo->prepare($sql);

            $params = array_merge($data, $condition);

            $stmt->execute($params);
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function delete($table, $condition)
    {
        try {
            $where = '';
            foreach ($condition as $key => $value) {
                $where .= "$key = :$key AND ";
            }
            $where = rtrim($where, 'AND ');

            $sql = "DELETE FROM $table WHERE $where";
            $stmt = $this->pdo->prepare($sql);

            $stmt->execute($condition);
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
