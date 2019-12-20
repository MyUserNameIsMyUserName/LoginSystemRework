<?php

class dbClass {
    
    protected $db_name = 'testing_php_oop_login';
    protected $db_user = 'muzika_27nov';
    protected $db_pass = 'muzika_27nov';
    protected $db_host = 'localhost';
    public $query;

    public function connect() {
        $this->connect_db = new mysqli( $this->db_host, $this->db_user, $this->db_pass, $this->db_name );
		
		if ( mysqli_connect_errno() ) {
			printf("Connection failed: %s\ ", mysqli_connect_error());
			exit();
		}
		return true;
    }

    public function disconnect() {
        mysqli_close($this->connect_db);
        
		if ( mysqli_connect_errno() ) {
			printf("Connection failed: %s\ ", mysqli_connect_error());
			exit();
		}
		return true;
    }

    public function queryFunc($query){
        if (mysqli_connect_errno()){
            $result = $this->connect_db->query($query);
            return $result->fetch_array();
        }
        return true;
    }

}