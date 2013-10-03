<?php
/* Define what DB table and form will be used in this form */
$table = 'lr_empresa';
$frm = 'frm_empresa';
$id_col = 'id_empresa';

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
	$list = $db->select($table, "$id_col = ". $_REQUEST['edit']);
	foreach ($list[0] as $k => $v) {
		${$k} = $v;
	}
}

/* Check if form was posted and if so, add record into DB */
if ($_REQUEST['form']) {
	/* Field mapping from form into DB table */
	$id_empresa = $_REQUEST['id_empresa'];
  $razao_social = $_REQUEST['razao_social'];
	$nome_fantasia = $_REQUEST['nome_fantasia'];
	$cnpj = $_REQUEST['cnpj'];
	$endereco = $_REQUEST['endereco'];
	$bairro = $_REQUEST['bairro'];
	$cidade = $_REQUEST['cidade'];
	$estado = $_REQUEST['estado'];
	$cep = $_REQUEST['cep'];
	$telefone = $_REQUEST['telefone'];
	$email = $_REQUEST['email'];
	$nome_responsavel = $_REQUEST['nome_responsavel'];
	$telefone_responsavel = $_REQUEST['telefone_responsavel'];
	$email_responsavel = $_REQUEST['email_responsavel'];
	$id_nucleo = $_REQUEST['id_nucleo'];
	$id_voluntario_captador = $_REQUEST['id_voluntario_captador'];
	$bservacao = $_REQUEST['observacao'];

	/* Preparing array of values to be saved into DB */
	$cols = array('razao_social' => $razao_social,
								'nome_fantasia' => $nome_fantasia,
								'cnpj' => $cnpj,
								'endereco' => $endereco,
								'bairro' => $bairro,
								'cidade' => $cidade,
								'estado' => $estado,
								'cep' => $cep,
								'telefone' => $telefone,
								'email' => $email,
								'nome_responsavel' => $nome_responsavel,
								'telefone_responsavel' => $telefone_responsavel,
								'email_responsavel' => $email_responsavel,
								'id_nucleo' => $id_nucleo,
								'id_voluntario_captador' => $id_voluntario_captador,
								'observacao' => $observacao,
								);

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
?>
<h1>Cadastro de Empresas</h1>

<?php 
if (!$st) { 
  if ($_REQUEST['add']) {
		$btnval = 'save';
	} elseif ($_REQUEST['edit']) {
		$btnval = 'edit_save';
	}
?>
<div id="form" class="">
  <form id="cadastro_empresa" name="cadastro_empresa" method="post" action="index.php">
  <input type="hidden" id="p" name="p" value="<?php print $frm; ?>" />
  <input type="hidden" id="form" name="form" value="save" />
  <input type="hidden" id="id_empresa" name="id_empresa" value="<?php print $id_empresa; ?>" />
  <input type="hidden" id="id_nucleo" name="id_nucleo" value="<?php print $id_nucleo; ?>" />
  <input type="hidden" id="id_voluntario_captador" name="id_voluntario_captador" value="<?php print $id_voluntario_captador; ?>" />

  <div class="field odd first">
  <div class="label">Razão Social</div>
  <div class="field"><input type="text" id="razao_social" name="razao_social" value="<?php print $razao_social; ?>" /></div>
  </div>
  
  <div class="field even">
  <div class="label">Nome Fantasia</div>
  <div class="field"><input type="text" id="nome_fantasia" name="nome_fantasia" value="<?php print $nome_fantasia; ?>" /></div>
  </div>
  
  <div class="field odd">
  <div class="label">Cnpj</div>
  <div class="field"><input type="text" id="cnpj" name="cnpj" value="<?php print $cnpj; ?>" /></div>
  </div>
  
  <div class="field even">
  <div class="label">Endereço</div>
  <div class="field"><input type="text" id="endereco" name="endereco" value="<?php print $endereco; ?>" /></div>
  </div>
  
  <div class="field odd">
  <div class="label">Bairro</div>
  <div class="field"><input type="text" id="bairro" name="bairro" value="<?php print $bairro; ?>" /></div>
  </div>
  
  <div class="field even">
  <div class="label">Cidade</div>
  <div class="field"><input type="text" id="cidade" name="cidade" value="<?php print $cidade; ?>" /></div>
  </div>
  
  <div class="field odd">
  <div class="label">Estado</div>
  <div class="field"><input type="text" id="estado" name="estado" value="<?php print $estado; ?>" /></div>
  </div>
  
  <div class="field even">
  <div class="label">CEP</div>
  <div class="field"><input type="text" id="cep" name="cep" value="<?php print $cep; ?>" /></div>
  </div>
  
  <div class="field odd">
  <div class="label">Telefone</div>
  <div class="field"><input type="text" id="telefone" name="telefone" value="<?php print $telefone; ?>" /></div>
  </div>
  
  <div class="field even">
  <div class="label">Email</div>
  <div class="field"><input type="text" id="email" name="email" value="<?php print $email; ?>" /></div>
  </div>
  
  <div class="field odd">
  <div class="label">Nome Responsável</div>
  <div class="field"><input type="text" id="nome_responsavel" name="nome_responsavel" value="<?php print $nome_responsavel; ?>" /></div>
  </div>
  
  <div class="field even">
  <div class="label">Telefone Responsável</div>
  <div class="field"><input type="text" id="telefone_responsavel" name="telefone_responsavel" value="<?php print $telefone_responsavel; ?>" /></div>
  </div>
  <div class="field odd">
  <div class="label">Email Responsável</div>
  <div class="field"><input type="text" id="email_responsavel" name="email_responsavel" value="<?php print $email_responsavel; ?>" /></div>
  </div>
  
  <div class="field even last">
  <div class="label">Observação</div>
  <div class="field"><input type="text" id="observacao" name="observacao" value="<?php print $observacao; ?>" /></div>
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
  $db = new db();
	$cols = $db->getColumnNames($table);
?>
<table id="table" class="<?php print $table; ?>">
  <thead>
    <tr><?php
		foreach ($cols as $k => $v) {
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