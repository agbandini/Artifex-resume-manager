<?php if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) exit('No direct access allowed.');

/** 
 * Validate class
 */ 
class Validate {

	/**
	 * Error
	 *
	 * @access private 
	 */		
	private $errore;
	
	private static $config;	
	private $db;
	
	/**
	 * Constructor
	 * 
	 * @access public 
	 */	  
	public function __construct() {
		
		self::$config = config_load('authentication');		
		//$this->db = new Database();
		$this->errore = new Errore();
		
	}

	/**
	 * Validate email address
	 * 
	 * @access public 
	 */	
	public function email($value, $message) {
	
		if (empty($value)) {
		
			$this->error->set_error($message);
		
		} else if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
		
			$this->error->set_error($message);
		
		}
	
	}

	/**
	 * Validate string
	 * 
	 * @access public 
	 */	
	public function required($value, $message) {
	
		if (empty($value))
			$this->error->set_error($message);
	
	}

	/**
	 * Validate number
	 * 
	 * @access public 
	 */	
	public function numeric($value, $message) {
	
		if (empty($value)) {
		
			$this->error->set_error($message);
		
		} else if (!filter_var($value, FILTER_VALIDATE_FLOAT)) {
		
			$this->error->set_error($message);
		
		}
	
	}

	/**
	 * Match one field to another
	 * 
	 * @access public 
	 */	
	public function matches($value_1, $value_2, $message) {
	
		if (empty($value_1) || empty($value_2)) {
		
			$this->error->set_error($message);
		
		} else if (!strcmp($value_1, $value_2) == 0) {
		
			$this->error->set_error($message);
		
		}		
	
	}
	
	public function sollevaErrore($message) {
		$this->error->set_error($message);
	}
	
	public function check_user_mail($email, $message) {
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);
		if ($this->db->row_count("SELECT user_email FROM " . self::$config['table_users'] ." WHERE user_email = '" . $email . "'")) {
			//return true;
			$this->error->set_error($message);
		} else {
					
		}
	}
	
}

?>
