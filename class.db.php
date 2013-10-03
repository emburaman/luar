<?php
class db {
  private $db_host = 'localhost';
  private $db_user = 'root';
  private $db_password = '';
  private $db_database = 'db_luar';
	private $conn;
	
	public function __construct() {
    $this->conn = new PDO("mysql:host=$this->db_host;dbname=$this->db_database", $this->db_user, $this->db_password);
	}

  function select($table, $cols = "*", $where = NULL, $order = NULL) {
    $sql = "SELECT $cols FROM $table";
    if ($where != null) {
      $sql .= " WHERE $where";
    }
    if ($order != null) {
      $sql .= " ORDER BY $order";
    }
		
    $qry = $this->conn->prepare($sql);
		if ($qry->execute()) {
			$result = $qry->fetchAll(PDO::FETCH_ASSOC);
    	return $result;
		} else {
			return false;
		}
  } /* End of function select() */
	
	function getUsers() {
		return $this->select('lr_usuario', 'username');
	}
	
	function getColumnNames($table) {
		$qry = $this->conn->prepare("DESCRIBE $table");
		$qry->execute();
		$result = $qry->fetchAll(PDO::FETCH_COLUMN);
		return $result;
	}
	
	function insert($table, $columns = array()) {
		$col = '';
		$val = '';
		$i = 1;

		foreach ($columns as $k => $v) {
			if ($i < count($columns)) {
				$comma = ", ";
			} else {
				$comma = "";
			}

			$col .= $k . $comma;
			if (is_numeric($v)) {
				$val .= $v . $comma;
			} else {
				$val .= "'$v'$comma";
			}
			$i++;
		}
		
    $sql = "INSERT INTO $table ($col) VALUE ($val)";
    $qry = $this->conn->prepare($sql);
		if ($qry->execute()) {
		  return true;
		} else {
			return false;
		}
	}
	
	function update($table, $cols, $where) {
		$val = '';
		$i = 1;
		foreach ($cols as $k => $v) {
			if ($i < count($cols)) { $comma = ', '; } else { $comma = ''; }
			if (is_numeric($v)) {
				$val .= "$k = $v$comma";
			} else {
				$val .= "$k = '$v'$comma";
			}
			$i++;
		}
		
		$sql = "UPDATE $table SET $val WHERE $where";
    $qry = $this->conn->prepare($sql);
		if ($qry->execute()) {
		  return true;
		} else {
			return false;
		}
	}
	
	function delete($table, $where) {
		$sql = "DELETE FROM $table WHERE $where";
    $qry = $this->conn->prepare($sql);
		if ($qry->execute()) {
		  return true;
		} else {
			return false;
		}
	}
} /* End of Class db{} */