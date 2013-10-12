<h1>Cadastro de Nucleos</h1>

<?php
/* Define what DB table and form will be used in this form */
$table = 'lr_nucleo';
$frm = 'frm_nucleo';
$id_col = 'id_nucleo';

/* Check id form should be displayed or not */
$st = true;
if (isset($_POST['add']) || isset($_POST['edit'])) {
	$st = false;
}
if (isset($_POST['del'])) {
	$st = true;
}
if (isset($_POST['edit'])) {
	$st = false;
}

/* Starting DB */
$db = new db();

if (isset($_POST['edit'])) {
	$list = $db->select($table,'*', "$id_col = ". $_POST['edit']);
	foreach ($list[0] as $k => $v) {
		${$k} = $v;
	}
}

/* Check if form was posted and if so, add record into DB */
if (isset($_POST['form'])) {
	/* Field mapping from form into DB table */
	$id_nucleo = $_POST['id_nucleo'];
	$descricao = $_POST['descricao'];
	/* Preparing array of values to be saved into DB */
	$cols = array('descricao' => "$descricao",
								);

	if ($_POST['enviar'] == 'edit_save') {
		$where = "$id_col = ". $_POST[$id_col];
		if ($db->update($table, $cols, $where)) {
			$st = true;
			print '<div class="msg success"><span class="icon"></span>O registro foi salvo com sucesso.</div>';
		} else {
			$st = false;
			print '<div class="msg fail"><span class="icon"></span>Não foi possível salvar o registro.</div>';
		}
	} elseif ($_POST['enviar'] == 'save') {
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
  if (isset($_POST['add'])) {
		$btnval = 'save';
	} elseif (isset($_POST['edit'])) {
		$btnval = 'edit_save';
	}
?>
<div id="form" class="">
	<form id="cadastro_nucleo" name="cadastro_nucleo" method="post" action="index.php">
  <input type="hidden" id="p" name="p" value="<?php print $frm; ?>" />
  <input type="hidden" id="form" name="form" value="save" />
  <input type="hidden" id="id_nucleo" name="id_nucleo" value="<?php print $id_nucleo; ?>" />
  <div class="field odd first">
    <div class="label">Descrição</div>
    <div class="field"><input type="text" id="descricao" name="descricao" value="<?php print $descricao; ?>" /></div>
  </div>
  <div class="field even"></div>
  <div class="field action">
    <div class="field"><button type="submit" id="enviar" name="enviar" value="<?php print $btnval; ?>"><span class="icon"></span>Salvar</button></div>
  </div>
  </form>
</div>
<?php 
} elseif (isset($_POST['edit'])) {
	
} elseif (isset($_POST['del'])) {
	$id = $_POST['del'];
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
	if (isset($_POST['delcfm'])) {
		$id = $_POST['delcfm'];
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
	$cols = $db->getColumnNames($table);
?>

<table id="table" class="<?php print $table; ?>">
  <thead>
    <tr><?php
    $cabecalho = array("Núcleo", "Descrição");
		foreach ($cabecalho as $k => $v) {
			print "<th class=". $v .">$v</th>";
		} ?>
    <td width="1"><!-- Action column --></td>
    <td width="1"><!-- Action column --></td>
		</tr>
	</thead>
  <tbody>
<?php
	$list = $db->select($table);
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