<?php

class BdConnect {
    
    private static $host = 'localhost';
    private static $user = 'maxx129';
    private static $password = '137Q21Y1904o79129+_)';
    private static $dbName = 'kohana';

    private static $instance = null;
    
    private function __construct() {}
    
    private function __clone() {}
    
    private function __wakeup() {}
    
    static public function getInstance() {
        
        if(self::$instance == NULL) {
            self::$instance = new mysqli(self::$host, self::$user, self::$password, self::$dbName);
            
            if (self::$instance->connect_error) {
                die('Connect Error (' . self::$instance->connect_errno . ') ' . self::$instance->connect_error);
            }
            self::$instance->query('SET NAMES utf8');
        }
        
        return self::$instance;
    }
   
}





