<?php
session_start();

include_once 'class.db.php';
include_once 'class.user.php';

$error  = '';
$action = 0;

if (isset($_REQUEST['a'])) { $action = $_REQUEST['a']; }

switch ($action) {
	case 0: 
		$action = 1;
		break;
		
	case 1: 
		$username = $_REQUEST['username'];
		$password = $_REQUEST['password'];
		$action   = 2;
		if ($username == '' || $password == '') {
			$error .= '<p>Campo usuário ou senha preenchidos incorretamente.</p>';
			$action = 1;
		} else {
			$user = new User();
			$password = sha1($password);
			$user = $user->login($username, $password);
			
			if ($user == TRUE) {
				$_SESSION['user']['username'] = $username;
				$action = 2;
			} else {
				$error .= '<p>Usuário não existe ou senha inválida, por favor tente novamente.</p>';
			}
		}
		break;
} /* End of switch($action) */

if (!empty($_SESSION['user'])) {
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'index.php';
	header("Location: http://$host$uri/$extra");
}

/* INITIATE HTML */
include_once('header.php');

if ($error <> '') {
	$error_div = "<div id='error'>". $error ."</div>";
}

if ($action < 2) {
print "<h1>Login</h1>
  <div id='login-form'>
	  $error_div
    <form id='login' action='login.php' method='post'>
      <input type='hidden' name='a' value='". $action ."' />
      
      <div class='field-collection'>
        <div class='label'>Usuário</div>
        <div class='field'><input type='text' name='username' value='". $username ."' /></div>
      </div>
    
      <div class='field-collection'>
        <div class='label'>Senha</div>
        <div class='field'><input type='password' name='password' value='' /></div>
      </div>

      <div class='field-collection'>
        <div class='field'><button name='submit' value=''>Logar</button></div>
      </div>
    </form>
  </div>";
}
	
include_once('footer.php');
?>