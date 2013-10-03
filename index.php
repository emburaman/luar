<?php include_once('header.php'); ?>
<?php
$screen = '';
if ($_REQUEST['p']) { $screen = $_REQUEST['p']; }

switch ($screen) {
	case 'frm_empresa':
		include_once('empresa.php');
		break;

	case 'frm_voluntario':
		include_once('voluntario.php');
		break;

	case 'frm_nucleo':
		include_once('nucleo.php');
		break;

	default:
		print 'Home';
		break;
}

?>
<?php include_once('footer.php'); ?>
