<?php
if (!isset($_SESSION)) { session_start(); }

include_once('class.db.php');
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

<link type="text/css" rel="stylesheet" href="style.css" media="all">

</head>

<body>
<div id="header">
  <?php if (!empty($_SESSION['user'])) { ?>
  <ul id="main-menu">
    <li class="odd first <?php if ($screen == '') { print 'active'; } ?>"><a href="index.php">Home</a></li>
    <li class="even <?php if ($screen == 'frm_empresa') { print 'active'; } ?>"><a href="index.php?p=frm_empresa">Cadastro de Empresas</a></li>
    <li class="odd <?php if ($screen == 'frm_voluntario') { print 'active'; } ?>"><a href="index.php?p=frm_voluntario">Cadastro de Voluntários</a></li>
    <li class="even <?php if ($screen == 'frm_nucleo') { print 'active'; } ?>"><a href="index.php?p=frm_nucleo">Cadastro de Núcleos</a></li>
    <li class="odd last <?php if ($screen == 'frm_usuario') { print 'active'; } ?>"><a href="index.php?p=frm_usuario">Cadastro de Usuários</a></li>
  </ul>
  <?php } ?>

  <ul id="user-menu">
    <?php if (!empty($_SESSION['user'])) { ?><li class="welcome">Bem-vindo, <?php print $_SESSION['user']['username']. "</li>"; } ?>
    <li class="odd"><?php if (empty($_SESSION['user'])) { ?><a href="login.php">Login</a><?php } else { ?><a href="logout.php">Logout</a><?php } ?></li>
  </ul>
</div>