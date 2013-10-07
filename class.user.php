<?php
class User {
  public $db;

	function login($username, $password) {
		if (!$username || !$password) {
			throw new Exception('Can\'t login');
		}
		
		$this->db = new db();
		$table = 'lr_usuario';
		$where = "username = '$username' AND senha = '$password'";
		$user = $this->db->select($table, $where);
		
		if (empty($user)) {
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
  function getUserProfile ($username) {
  }
  
  function saveUser ($uid, $pwd, $where) {
  }

  function updateUser ($uid, $pwd, $where) {
  }


	function validatePassword($candidate) {
		$r1='/[A-Z]/';  //Uppercase
		$r2='/[a-z]/';  //lowercase
		$r3='/[!@#$%^&*()\-_=+{};:,<.>]/';  // whatever you mean by 'special char'
		$r4='/[0-9]/';  //numbers
		
		if(preg_match_all($r1,$candidate, $o)<1) return FALSE;
		
		if(preg_match_all($r2,$candidate, $o)<1) return FALSE;
		
		if(preg_match_all($r3,$candidate, $o)<1) return FALSE;
		
		if(preg_match_all($r4,$candidate, $o)<1) return FALSE;
		
		if(strlen($candidate)<8) return FALSE;
		
		return TRUE;
	}
  
} /* End of class User{} */
?>