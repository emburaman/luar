<?php
/* Variables declaration */
$add = '';
$del = '';
$edit = '';

$screen = '';
if (isset($_REQUEST['p'])) { $screen = $_REQUEST['p']; }

include_once('header.php');

if (isset($_SESSION['user'])) {
	switch ($screen) {
		case 'frm_empresa':
			include_once('empresa.php');
			break;

		case 'frm_voluntario':
			include_once('voluntario.php');
			break;

		case 'frm_usuario':
			include_once('usuario.php');
			break;

		case 'frm_nucleo':
			include_once('nucleo.php');
			break;

		default:
			print 'Home';
			break;
	}
} 
if (!isset($_SESSION['user']) && isset($_REQUEST['p'])) {
	print '<div class="msg fail"><span class="icon"></span>Você precisa estar logado para visualizar esta página.</div>';
}
?>
<?php include_once('footer.php'); ?>
