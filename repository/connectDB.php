<?php
class connectDB{
    private $host = "localhost";
    private $port = "3306";
    private $dbname = "dbpm01";
    private $user = "dbpmo01";
    private $passwd = "dbpmo01#";

    public $connect = null;
    public function connect(){
        try{
            $this->connect = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->passwd);
            $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connect->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->connect->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->connect->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
            return $this->connect;
        }catch(PDOException $e){
            echo "Connection failed: ".$e->getMessage();
        }
    }

    public function close(){
        $this->connect=null;
    }
}
?>