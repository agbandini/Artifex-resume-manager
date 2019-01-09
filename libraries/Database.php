<?php
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) exit('No direct access allowed.');

class Database {

    private $_connection;
    private static $_instance; //The single instance
    private $myConf;

    public static function getInstance($dbData) {
        if (!self::$_instance) { // If no instance then make one
            self::$_instance = new self($dbData);
        }
        return self::$_instance;
    }

    // Constructor
    private function __construct($dbData) {
        $this->myConf = $dbData; //require('config/database.php');

        $this->_connection = new mysqli($this->myConf['hostname'], $this->myConf['username'], $this->myConf['password'], $this->myConf['dbname']);
        $this->_connection->set_charset($this->myConf['charset']);

        // Error handling
        if (mysqli_connect_error()) {
            trigger_error("Failed to conencto to MySQL: " . mysql_connect_error(), E_USER_ERROR);
        }
    }

    // Magic method clone is empty to prevent duplication of connection
    private function __clone() {
        
    }

    // Get mysqli connection
    public function getConnection() {
        return $this->_connection;
    }

}
