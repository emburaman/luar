<h1>Cadastro de Usuários</h1>

<?php
/* Define what DB table and form will be used in this form */
$table = 'lr_usuario';
$frm = 'frm_usuario';
$id_col = 'username';

/* Check id form should be displayed or not */
$st = true;
if ($_REQUEST['add'] || $_REQUEST['edit']) {
	$st = false;
}
if ($_REQUEST['del']) {
	$st = true;
}
if ($_REQUEST['edit']) {
	$st = false;
}

/* Starting DB */
$db = new db();

if($_REQUEST['edit']) {
	$list = $db->select($table,'*', "$id_col = '". $_REQUEST['edit'] ."'");
	foreach ($list[0] as $k => $v) {
		${$k} = $v;
	}
}

/* Check if form was posted and if so, add record into DB */
if ($_REQUEST['form']) {
	/* Field mapping from form into DB table */
	$id_usuario = $_REQUEST['id_usuario'];
	$username = $_REQUEST['username'];
  $senha = sha1($_REQUEST['senha']);

	/* Preparing array of values to be saved into DB */
	$cols = array('username' => "$username",
								);
	if ($_REQUEST['senha'] != '') {
	  $cols = array('senha' => "$senha") + $cols;
	}

	if ($_REQUEST['enviar'] == 'edit_save') {
		$where = "$id_col = ". $_REQUEST[$id_col];
		if ($db->update($table, $cols, $where)) {
			$st = true;
			print '<div class="msg success"><span class="icon"></span>O registro foi salvo com sucesso.</div>';
		} else {
			$st = false;
			print '<div class="msg fail"><span class="icon"></span>Não foi possível salvar o registro.</div>';
		}
	} elseif ($_REQUEST['enviar'] == 'save') {
		/* Savind new record into DB */
		if ($db->insert($table, $cols)) {
			$st = true;
			print '<div class="msg success"><span class="icon"></span>O registro foi salvo com sucesso.</div>';
		} else {
			$st = false;
			print '<div class="msg fail"><span class="icon"></span>Não foi possível salvar o registro.</div>';
		}
	}
}

/* Start HTML */
if (!$st) { 
  if ($_REQUEST['add']) {
		$btnval = 'save';
	} elseif ($_REQUEST['edit']) {
		$btnval = 'edit_save';
	}
?>
<div id="form" class="">
	<form id="cadastro_nucleo" name="cadastro_nucleo" method="post" action="index.php">
  <input type="hidden" id="p" name="p" value="<?php print $frm; ?>" />
  <input type="hidden" id="form" name="form" value="save" />
  <input type="hidden" id="id_usuario" name="id_usuario" value="<?php print $id_usuario; ?>" />
  <div class="field odd first">
    <div class="label">Usuário</div>
    <div class="field"><input type="text" id="username" name="username" value="<?php print $username; ?>" /></div>
  </div>
  <div class="field even">
    <div class="label">Senha</div>
    <div class="field"><input type="password" id="senha" name="senha" value="<?php //print $senha; ?>" /></div>
  </div>
  <div class="field odd last">
    <div class="label">Confirme a Senha</div>
    <div class="field"><input type="password" id="cfsenha" name="cfsenha" value="<?php //print $senha; ?>" /></div>
  </div>
  <div class="field action">
    <div class="field"><button type="submit" id="enviar" name="enviar" value="<?php print $btnval; ?>"><span class="icon"></span>Salvar</button></div>
  </div>
  </form>
</div>
<?php 
} elseif ($_REQUEST['edit']) {
	
} elseif ($_REQUEST['del']) {
	$id = $_REQUEST['del'];
	?>
	<h3>Tem certeza que deseja excluir este registro?</h3>
	<div class="del-button"><form method="post" action="index.php">
		<input type="hidden" id="p" name="p" value="<?php print $frm; ?>" />
		<input type="hidden" id="delcfm" name="delcfm" value="<?php print $id; ?>" />
		<button type="submit" id="sim" name="sim"><span class="icon"></span>Sim</button>
	</form></div>
	<div class="del-button"><form method="post" action="index.php">
		<input type="hidden" id="p" name="p" value="<?php print $frm; ?>" />
		<button type="submit" id="cancel" name="cancel"><span class="icon"></span>Não</button>
	</form></div>
	<?php

} else {
	if ($_REQUEST['delcfm']) {
		$id = $_REQUEST['delcfm'];
	  $db = new db();
		if ($db->delete($table, "$id_col = $id")) {
			print '<div class="msg success"><span class="icon"></span>O registro foi excluído com sucesso.</div>';
		} else {
			print '<div class="msg fail"><span class="icon"></span>Não foi possível excluir o registro.</div>';
		}
	}
?>
<div class="add-button"><form method="post" action="index.php">
  <input type="hidden" id="p" name="p" value="<?php print $frm; ?>" />
  <input type="hidden" id="add" name="add" value="novo" />
  <button type="submit" id="novo" name="novo"><span class="icon"></span>Novo</button>
</form></div>

<?php
	/* List records */
?>
<table id="table" class="<?php print $table; ?>">
  <thead>
    <tr>
    <td class="username">Username</td>
    <td width="1"><!-- Action column --></td>
    <td width="1"><!-- Action column --></td>
		</tr>
	</thead>
  <tbody>
<?php
	$list = $db->getUsers();

	for ($i = 0; $i < count($list); $i++) {
		if ($i % 2 == 0) { $class = 'even'; } else { $class = 'odd'; }
		print '<tr class="'. $class .'">';
		foreach ($list[$i] as $k => $v) {
			if ($k == $id_col) { $id = $v; }
			print "<td class=". $k .">$v</td>";
		}
		print '<form method="post" action="index.php">
					<input type="hidden" id="p" name="p" value="'. $frm .'" />
					<td><button class="edit" type="submit" id="edit" name="edit" value="'. $id .'">Y</button></td>
					<td><button class="del" type="submit" id="del" name="del" value="'. $id .'">X</button></td>
					</form>';
		print '</tr>';
		$id = '';
	}
}
?>
	</tbody>
</table>