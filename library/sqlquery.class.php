<?php
class SQLQuery {
    protected $_dbHandle;
    protected $_result;
    protected $_table;
     /** Connects to database **/
     function connect($address, $account, $pwd, $name) {
        try{
            $this->_dbHandle = new PDO("mysql:host=$address;dbname=$name", $account, $pwd);
            $this->_dbHandle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return 0;
        }
     }


    /** Méthode pour accéder à la connexion PDO **/
    public function getDbHandle() {
        return $this->_dbHandle;
    }



    /** Disconnects from the database */
    function disconnect(){
        $this->_dbHandle = null;
        return 1;
    }
    function selectAll() {
        $query = 'SELECT * FROM `' . $this->_table . '`';
        return $this->query($query);
    }
    // No need for escaping we can just use prepared statements
    function select($id){
        $query = 'SELECT * FROM `' . $this->_table . '` WHERE `id` = :id';
        $statement = $this->_dbHandle->prepare($query);
        $statement->execute([':id' => $id]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    function query($query, $singleResult = 0) {
        try {
            $stmt = $this->_dbHandle->prepare($query);
            $stmt->execute();
            if (preg_match("/select/i", $query)) {
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if ($singleResult == 1) {
                    return $result[0] ?? null;
                }
                return $result;
            }
            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo "Query error: " . $e->getMessage();
            return false;
        }
    }
    /** Get number of rows **/
    function getNumRows() {
        return $this->_result->rowCount();
    }
    /** Free resources allocated by a query **/
    function freeResult() {
        $this->_result = null;
    }
    /** Get error string **/
    function getError() {
        $errorInfo = $this->_dbHandle->errorInfo();
        return $errorInfo[2];
    }
}
