<?php
if (!isset($_SESSION)) { session_start(); }

include_once 'class.db.php';
include_once 'class.user.php';

$action = 0;
$error  = '';
$error_div = '';
$username = '';

if (isset($_POST['a'])) { $action = $_POST['a']; }

switch ($action) {
	case 0: 
		$action = 1;
		break;
		
	case 1: 
		$username = $_POST['username'];
		$password = $_POST['password'];
		$action   = 2;
		if ($username == '' || $password == '') {
			$error .= '<p>Campo usuário ou senha preenchidos incorretamente.</p>';
			$action = 1;
		} else {
			$user = new User();
			$password = sha1($password);
			$login = $user->login($username, $password);
			
			if ($login == TRUE) {
				$_SESSION['user']['username'] = $username;
				$permissions = $user->getUserPermissions($username);
				for ($i = 0; $i < count($permissions); $i++) { 
					$nome_tela = strtolower($permissions[$i]['nome_tela']);
					$nivel_acesso = $permissions[$i]['cod_nivel_acesso'];
					$_SESSION['user']['permissions'][$nome_tela] = $nivel_acesso;
				}
				$profile = $user->getUserProfile($username);
				$_SESSION['user']['id_profile'] = $profile[0]['id_tipo_voluntario'];
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