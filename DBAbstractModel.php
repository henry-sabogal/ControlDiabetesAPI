<?php
abstract class DBAbstractModel{
    private static $db_host = 'localhost';
    private static $db_user = '';
    private static $db_password = '###';
    protected $db_name = 'well_being_project';
    protected $rows = array();
    protected $query;
    private $conn;
    
    
    abstract function get();
    abstract function set();
    
    private function open_connection(){
        $this->conn = new mysqli(self::$db_host, self::$db_user, self::$db_password, $this->db_name);
    }
    
    private function close_connection(){
        $this->conn->close();
    }
    
    protected function execute_single_query(){
        $this->open_connection();
        $this->conn->set_charset('utf8');
        $this->conn->query($this->query);
        $this->close_connection();
    }
    
    protected function get_results_from_query(){
        $this->open_connection();
        $this->conn->set_charset('utf8');
        $result = $this->conn->query($this->query);
        $this->rows[] = $result->fetch_all(MYSQLI_ASSOC);
        $result->close();
        $this->close_connection();
    }
    
    protected function get_all_results_from_query(){
        $this->open_connection();
        $this->conn->set_charset('utf8');
        $result = $this->conn->query($this->query);
        $this->rows = $result->fetch_all(MYSQLI_ASSOC);
        $result->close();
        $this->close_connection();
    }
}
