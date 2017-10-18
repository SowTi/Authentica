<?php
	class Authentica{
		private $con = NULL;
		private $database = NULL;
		private $table = NULL;
		private $errors = array();
		public $auth_status = false;

		public function Authentica($con, $database, $table){
			if(is_resource($con)){
				$this->con = $con;
				$this->database = $database;
				$this->table = $table;
			}
			else{
				$errors[] .= "Invalid or Empty CONNECTION_IDENTIFIER.";
			}
			if(strlen(trim($database)) < 1){
				$errors[] .= "Invalid or Empty DATABASE_NAME.";	
			}
			if(strlen(trim($table)) < 1){
				$errors[] .= "Invalid or Empty TABLE_NAME.";	
			}
			if(! empty($errors)){
				/*
					If there are errors throw them.
				*/	
				echo "Unable to initiate Authentica. Following are the causes:<br>";			
				foreach ($errors as $msg) {
					echo "<li>".$msg."</li>";
				}
				exit;
			}
			else{
				mysql_select_db($this->database);
			}
		}

		public function authenticate($auth_details){
			$args = array_keys($auth_details);
			$vals = array_values($auth_details);
			/*
				If the password is plaintext. MD5 it!
			*/
			if(in_array("PASSWORD_ENCRYPTED", $args)){
				switch (strtolower($vals[2])) {
					case 'sha1':
						$vals[1] = sha1($vals[1]);
						break;

					case 'md5':
						$vals[1] = md5($vals[1]);
						break;
					
					default:					
						break;
				}
			}
			$check = mysql_query("SELECT * FROM $this->table WHERE $args[0] = '$vals[0]' AND $args[1] = '$vals[1]' ", $this->con);
			if(mysql_num_rows($check) > 0){
				$this->auth_status = true;
			}
			return mysql_fetch_assoc($check);
		}

		public function getAuthenticationStatus(){
			return intval($this->auth_status);
		}
	}
?>