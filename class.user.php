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
  
} /* End of class User{} */
?>