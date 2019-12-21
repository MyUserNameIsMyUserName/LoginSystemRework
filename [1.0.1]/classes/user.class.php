<?php
	//include 'database.class.php';

	class UserClass {

		private $con;
		private $username = NULL;
		public $errorArray = array();
		private $tableName = 'usersssaaa';

		public function __construct() {
			$this->con = new dbClass();
			$this->con->connect();
			$this->errorArray = array();
			if ($this->tableExists() !== 1){
				$this->repairTable();
			}
		}

		public function setUsername($username) {
			if ($username !== ''){
				try {
					$this->username = $username;
					return true;
				}
				catch (exception $e) {
					$this->errorArray = $e;
					return false;
				}
			} else {
				return 'Missing Username:[$user->setUsername($username)]';
			}	
		}

		public function getUsername() {			
			if ($this->username !== NULL){
				try {
					return $this->username;
					return true;
				}
				catch (exception $e) {
					$this->errorArray = $e;
					return false;
				}
			} else {
				return 'Missing Username:[$user->getUsername()]';
			}
		}

		public function getEmail() {
				$this->errorArray = array();
				if (!empty($this->username)){
					$query = $this->con->connect_db->query("SELECT email FROM $this->tableName WHERE username='$this->username'");
					$row = $query->fetch_array();
					if ($query->num_rows !== 0){
						return ($row['email']);
					} else {
						array_push($this->errorArray, 'No email for username');
						return json_encode($this->errorArray);
					}
				} else {
					array_push($this->errorArray, 'Missing Username:[$user->getEmail()]');
					return json_encode($this->errorArray);
				}
		}

		public function getFirstAndLastName() {
				$this->errorArray = array();
				if (!empty($this->username)){
					$query = $this->con->connect_db->query("SELECT concat(firstName, ' ', lastName) as 'name'  FROM $this->tableName WHERE username='$this->username'");
					$row = $query->fetch_array();
					if ($query->num_rows !== 0){
						return ($row['name']);
					} else {
						array_push($this->errorArray, 'No info for username');
						return json_encode($this->errorArray);
					}
				} else {
					array_push($this->errorArray, 'Missing Username:[$user->getFirstAndLastName()]');
					return json_encode($this->errorArray);
				}
		}

		public function login($un, $pw) {
				$this->errorArray = array();
				if ((!empty($un)) && (!empty($pw)) ){
					$pw = md5($pw);
		
					$query = $this->con->connect_db->query("SELECT * FROM $this->tableName WHERE username='$un' AND password='$pw'");
		
					if($query->num_rows == 1) {

						return json_encode(true);
					}
					else {
						array_push($this->errorArray, 'Login Failed');
						return json_encode($this->errorArray);
					}
				} else {
					if (empty($pw)){
						array_push($this->errorArray, 'Empty Password');
					} else if (empty($un)){
						array_push($this->errorArray, 'Empty Username');
					} else if ($this->username == NULL){
						return 'Missing Username:[$user->login()]';
					}
					return json_encode($this->errorArray);
					
				}
			
		}

		public function register($un, $fn, $ln, $em, $em2, $pw, $pw2) {
				$this->errorArray = array();
				$this->validateUsername($un);
				$this->validateFirstName($fn);
				$this->validateLastName($ln);
				$this->validateEmails($em, $em2);
				$this->validatePasswords($pw, $pw2);
	
				if(empty($this->errorArray) == true) {
					//Insert into db
					return $this->insertUserDetails($un, $fn, $ln, $em, $pw);
				}
				else {
					return json_encode($this->errorArray);
				}
		}


		private function insertUserDetails($un, $fn, $ln, $em, $pw) {
			$encryptedPw = md5($pw);
			$profilePic = "assets/images/profile-pics/head_emerald.png";
			$date = date("Y-m-d");

			$result = $this->con->connect_db->query("INSERT INTO $this->tableName VALUES ('', '$un', '$fn', '$ln', '$em', '$encryptedPw', '$date', '$profilePic', '0')");

			return json_encode($result);
		}

		private function validateUsername($un) {

			if(strlen($un) > 25 || strlen($un) < 5) {
				array_push($this->errorArray, 'Invalid Username');
				return;
			}

			$checkUsernameQuery = $this->con->connect_db->query("SELECT username FROM $this->tableName WHERE username='$un'");
			if($checkUsernameQuery->num_rows != 0) {
				array_push($this->errorArray, 'Username Taken');
				return;
			}

		}

		private function validateFirstName($fn) {
			if(strlen($fn) > 25 || strlen($fn) < 2) {
				array_push($this->errorArray, 'Invalid First Name');
				return;
			}
		}

		private function validateLastName($ln) {
			if(strlen($ln) > 25 || strlen($ln) < 2) {
				array_push($this->errorArray, 'Invalid Last Name');
				return;
			}
		}

		private function validateEmails($em, $em2) {
			if($em != $em2) {
				array_push($this->errorArray, 'Email Not same');
				return;
			}

			if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {
				array_push($this->errorArray, 'Invalid Email');
				return;
			}

			$checkEmailQuery = $this->con->connect_db->query("SELECT email FROM users WHERE email='$em'");
			if($checkEmailQuery->num_rows != 0) {
				array_push($this->errorArray, 'Email Already Exists');
				return;
			}

		}

		private function validatePasswords($pw, $pw2) {
			
			if($pw != $pw2) {
				array_push($this->errorArray, 'passwordsDoNoMatch');
				return;
			}

			if(preg_match('/[^A-Za-z0-9]/', $pw)) {
				array_push($this->errorArray, 'passwordNotAlphanumeric');
				return;
			}

			if(strlen($pw) > 30 || strlen($pw) < 5) {
				array_push($this->errorArray, 'Password Length');
				return;
			}

		}

		private function tableExists(){
			$result = $this->con->connect_db->query('SELECT 1 FROM '.$this->tableName.' LIMIT 1');
			$this->errorArray = array();
			if ($result == FALSE){
				array_push($this->errorArray, 'Table Doesnt Exist');
				return json_encode($this->errorArray);
			} else {
				return true;
			}

		}

		private function repairTable() {
			$this->errorArray = array();

			if ($this->tableExists() == 1){
				$this->dropTable();
				$this->createTable();
				return json_encode($this->errorArray);
			} else {
				return $this->createTable();
			}
		}

		private function createTable(){
			$result = $this->con->connect_db->query('CREATE TABLE '.$this->tableName.' (`id` int(11) NOT NULL,`username` varchar(25) NOT NULL,`firstName` varchar(50) NOT NULL,`lastName` varchar(50) NOT NULL,`email` varchar(200) NOT NULL,`password` varchar(32) NOT NULL,`signUpDate` datetime NOT NULL,`profilePic` varchar(500) NOT NULL,`adminStatus` varchar(10) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;');
			if ($result == TRUE) {
				return TRUE;
			} else {
				array_push($this->errorArray, 'Table cant be droped');
				return FALSE;
			}
		}

		private function dropTable(){
			$result = $this->con->connect_db->query('DROP TABLE '.$this->tableName);
			if ($result == TRUE) {
				return TRUE;
			} else {
				array_push($this->errorArray, 'Table cant be droped');
				return FALSE;
			}
		}

	}
?>
