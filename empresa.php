<?php
/* Define what DB table and form will be used in this form */
$table = 'lr_empresa';
$view   = 'vlr_empresa';
$frm = 'frm_empresa';
$id_col = 'id_empresa';

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

if(isset($_POST['edit'])) {
	$list = $db->select($table,'*', "$id_col = ". $_POST['edit']);
	foreach ($list[0] as $k => $v) {
		$$k = $v;
	}
}

/* Declaring the form variables */
$id_empresa = '';
$razao_social = '';
$nome_fantasia = '';
$cnpj = '';
$endereco = '';
$bairro = '';
$cidade = '';
$estado = '';
$cep = '';
$telefone = '';
$email = '';
$nome_responsavel = '';
$telefone_responsavel = '';
$email_responsavel = '';
$id_nucleo = '';
$id_voluntario_captador = '';
$observacao = '';

/* Check if form was posted and if so, add record into DB */
if (isset($_POST['form'])) {
	/* Field mapping from form into DB table */
	$id_empresa = $_POST['id_empresa'];
  $razao_social = $_POST['razao_social'];
	$nome_fantasia = $_POST['nome_fantasia'];
	$cnpj = $_POST['cnpj'];
	$endereco = $_POST['endereco'];
	$bairro = $_POST['bairro'];
	$cidade = $_POST['cidade'];
	$estado = $_POST['estado'];
	$cep = $_POST['cep'];
	$telefone = $_POST['telefone'];
	$email = $_POST['email'];
	$nome_responsavel = $_POST['nome_responsavel'];
	$telefone_responsavel = $_POST['telefone_responsavel'];
	$email_responsavel = $_POST['email_responsavel'];
	$id_nucleo = $_POST['id_nucleo'];
	$id_voluntario_captador = $_POST['id_voluntario_captador'];
	$observacao = $_POST['observacao'];

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
?>
<h1>Cadastro de Empresas</h1>

<?php 

//importa o arquivo funcao_combo.php
  include_once('combobox.php');
  
if (!$st) { 
  if (isset($_POST['add'])) {
		$btnval = 'save';
	} elseif (isset($_POST['edit'])) {
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
          <div class="label">Núcleo</div>
          <div class="field"> 
					<?php
            $db = new db();
            $list = $db->select('lr_nucleo');
            print ComboBox('id_nucleo', $list, $id_nucleo);
          ?>
          </div>
  </div>
  
  <div class="field odd">
  <div class="label">CNPJ</div>
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
  $db = new db();
	$cols = $db->getColumnNames($view);
?>
<table id="table" class="<?php print $view; ?>">
  <thead>
    <tr><?php
    $cabecalho = array("Nome Empresa", "CNPJ", "Endereço",  "Bairro", "Responsável", "Tel. Resp.", "Email", "Núcleo");
    foreach ($cabecalho as $k => $v) {
			print "<th class=". $v .">$v</th>";
		} ?>
    <td width="1"><!-- Action column --></td>
    <td width="1"><!-- Action column --></td>
		</tr>
	</thead>
  <tbody>
<?php
	$list = $db->select($view);

	for ($i = 0; $i < count($list); $i++) {
		if ($i % 2 == 0) { $class = 'even'; } else { $class = 'odd'; }
		print '<tr class="'. $class .'">';
		foreach ($list[$i] as $k => $v) {
			if ($k == $id_col) { $id = $v; }
			print "<td class=". $k .">$v</td>";
		}
		
		$id = $db->select($table, 'id_empresa', "cnpj = ". $list[$i]['cnpj']);
		$id = $id[0]['id_empresa'];
		
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