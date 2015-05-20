<?php
/**
 * Description of Database
 * =============================================
 * 141224.1043 [win] Add throw exception when query error
 */
Tools::_include_config("database");

class Database {

    protected $dbType = 'pgsql';
    protected $dbHost = '127.0.0.1';
    protected $dbPort = '5432';
    protected $dbName = '';
    protected $dbUser = '';
    protected $dbPass = '';

    public $conn = NULL;
    
    public function __construct() { /*{{{
     * initial configs
     */
        if (defined('DB_TYPE')) { $this->dbType = DB_TYPE; }
        if (defined('DB_HOST')) { $this->dbHost = DB_HOST; }
        if (defined('DB_PORT')) { $this->dbPort = DB_PORT; }
        if (defined('DB_NAME')) { $this->dbName = DB_NAME; }
        if (defined('DB_USER')) { $this->dbUser = DB_USER; }
        if (defined('DB_PASS')) { $this->dbPass = DB_PASS; }
    } /*}}}*/

    private function handleError($msg, $code){
        global $log;
        throw new Exception($msg, $code);
    }
    
    public function connect() { /*{{{
     * Check and connect if not
     */
        // Check already connected of not?
        if ($this->conn !== NULL) return;
        
        // Try open connection via PDO drivers
        try {
                $this->conn = new PDO("{$this->dbType}:
                        host={$this->dbHost};
                        port={$this->dbPort};
                        dbname={$this->dbName};
                        user={$this->dbUser};
                        password={$this->dbPass};
                ");
                return(true);	// Success connecting
        }catch (PDOException $e) {
            $this->handleError($e->getMessage(), ERROR_DATABASE_CONNECTION);
        }
    } /*}}}*/

    public function begin(){ /*{{{*/
        //Try to connect to database
        $this->connect();
        return $this->conn->beginTransaction();
    } /*}}}*/

    public function commit(){ /*{{{*/
        //Try to connect to database
        $this->connect();
        return $this->conn->commit();
    } /*}}}*/

    public function rollback(){ /*{{{*/
        //Try to connect to database
        $this->connect();
        return $this->conn->rollBack();
    } /*}}}*/

    public function query($query , $params = array()){ /*{{{*/
        //Try to connect to database
        $this->connect();

        //Prepare Query
        $stm = $this->conn->prepare($query);
        $err = $this->conn->errorInfo();
        if($err['0'] != '00000'){
            $msg = "Prepare sqlState:" . $err[0] . " DriverCode:" . $err[1] . " DriverInfo:" . $err[2];
            $this->handleError($msg, ERROR_INTERNAL);
        }

        $stm->execute($params);
        $err = $stm->errorInfo();
        if ($err[0]!='00000'){
            $msg = "Excute sqlState:" . $err[0] . " DriverCode:" . $err[1] . " DriverInfo:" . $err[2];
            $this->handleError($msg, ERROR_INTERNAL);
        }

        return new Statement($stm);
    } /*}}}*/

    public function insert($table, $colArr) { /*{{{*/
        //Try to connect to database
        $this->connect();
        
        $a = [];
        $c = [];
        $v = [];
        foreach ($colArr as $key=>$value) {
            $c[] = $key;
            $v[] = ':'.$key;
            $a[':'.$key] = $value;
        }
        $query = 'INSERT INTO '.$table.'('.implode(',',$c).') VALUES('.implode(',',$v).');';

        return $this->query($query,$a)->rowCount();
    } /*}}}*/

    public function update($table, $set, $where) { /*{{{*/
        //Try to connect to database
        $this->connect();
        $a = [];
        $c = [];
        foreach ($set as $key => $value) {
            $c[] = $key.' = ?';
            $a[] = $value;
        }
        $w = '';
        foreach ($where as $key => $value) {
                $w .= ' and '.$key.' = ?';
                $a[] = $value;
        }
        $query = 'UPDATE '.$table.' SET '.implode(',',$c).' WHERE 1=1 '.$w;

        return $this->query($query,$a)->rowCount();
    } /*}}}*/

    public function last_insert_id($name = NULL) { /*{{{*/
        return $this->conn->lastInsertId($name);
    } /*}}}*/
    
    public function tm18() {
        return $this->query("SELECT tm18();")->fetchOne();
    }
}

class Statement{
    private $resource;

    function __construct(&$pdoStatement) {
        $this->resource = $pdoStatement;
    }

    public function rowCount() {
        $result = $this->resource->rowCount();
        return $result;
    }

    public function fetchAll() {
        $result = $this->resource->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function fetchRow(){
        $result = $this->resource->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function fetchFirst() {
        $result = $this->resource->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_FIRST);
        return $result;
    }

    public function fetchPair() {
        $rows = $this->fetchAll();
        $pair = array();
        foreach ($rows as $row) {
            $k_pair = '';
            foreach ($row as $value){
                if($k_pair == ''){
                    $k_pair = $value;
                }else{
                    $pair[$k_pair] = $value;
                    $k_pair = '';
                    break;
                }
            }
        }
        return $pair;
    }

    public function fetchOne() {
        $result = $this->resource->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_FIRST);
        return isset($result[0]) ? $result[0] : NULL;
    }
}

$db = new Database();