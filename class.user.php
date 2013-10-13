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
		$user = $this->db->select($table, '*', $where);
		
		if (empty($user)) {
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
  function getUserProfile($username) {
		$this->db = new db();
		$table = 'lr_voluntario';
		$where = "username = '$username'";
		$user = $this->db->select($table, '*', $where);
		return $user;
  }
  
	function updateUserPermission($username, $id_tipo_voluntario) {
		$st = true;
		$this->db = new db();
		$scr = $this->db->select('vlr_acesso_tela_usuario', '*', "id_tipo_voluntario = $id_tipo_voluntario");

		for ($i = 0; $i < count($scr); $i++) {
			$cols_acesso = array('username' => $username, 'id_tela' => $scr[$i]['id_tela'], 'cod_nivel_acesso' => $scr[$i]['cod_nivel_acesso']);
			if ($this->db->insert('lr_rel_acesso_usuario_tela', $cols_acesso)) {
				$st = true;
			} else {
				$st = false;
			}
		}
		if ($st == true) {
			return true;
		} else {
			return false;
		}
	}
	
	function getUserPermissions($username) {
		$db = new db();
		$acesso = $db->select('vlr_rel_acesso_usuario_tela', '*', "username = '$username'");
		return $acesso;
	}
	
  function saveUser($uid, $pwd, $where) {
  }

  function updateUser($uid, $pwd, $where) {
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