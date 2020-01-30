<?php

	class Database {
		
		private $host = 'localhost';
		private $user = 'root';
		private $pw = 'kamikaze589';
		private $db = 'cookpotdatabase';
		
		private static $_instance;
		private $_connection;
	
		function __construct() {
			$this->_connection = new mysqli($this->host, $this->user, $this->pw, $this->db);
		}
		
		static function getInstance() {
			if(!self::$_instance) {				
				self::$_instance = new self();				
			}
			
			return self::$_instance;			
		}
		
		function getConnection() {
			
			return $this->_connection;
		}
		
		function projecto() {
			
		}
	
	}
?>