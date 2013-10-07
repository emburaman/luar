<?php
/* Define what DB table and form will be used in this form */
$table  = 'lr_voluntario';
$table_user  = 'lr_usuario';
$view   = 'vlr_voluntario';
$frm    = 'frm_voluntario';
$id_col = 'id_voluntario';
$id_col_user = 'username';

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
	$list = $db->select($table,'*', "$id_col = ". $_REQUEST['edit']);
	foreach ($list[0] as $k => $v) {
		${$k} = $v;
	}
}

/* Check if form was posted and if so, add record into DB */
if ($_REQUEST['form']) {
	/* Field mapping from form into DB table */
	$id_voluntario = $_REQUEST['id_voluntario'];
	$id_tipo_voluntario = $_REQUEST['id_tipo_voluntario'];
	$id_status = $_REQUEST['id_status'];
	$nome = $_REQUEST['nome'];
	$cpf = $_REQUEST['cpf'];
	$rg = $_REQUEST['rg'];
	$dt_nascimento = $_REQUEST['dt_nascimento'];
	$endereco = $_REQUEST['endereco'];
	$bairro = $_REQUEST['bairro'];
	$cidade = $_REQUEST['cidade'];
	$estado = $_REQUEST['estado'];
	$cep = $_REQUEST['cep'];
	$telefone = $_REQUEST['telefone'];
	$profissao = $_REQUEST['profissao'];
	$email  = $_REQUEST['email'];
	$id_entidade = $_REQUEST['id_entidade'];
  $id_nucleo = $_REQUEST['id_nucleo'];
	
  $username = $_REQUEST['username'];
	$password = $_REQUEST['senha'];
	$confirmp = $_REQUEST['cfsenha'];

	if (($username != '' && $password == '') || ($username == '' && $password != '')) {
		print '<div class="msg fail"><span class="icon"></span>Você está tentando criar um usuário para este voluntário? Parece que você não digitou os dados corretamente.</div>';
		$st = false;
	}
	if ($username != '' && $password != '') {
		include_once "class.user.php";
		$usr = new User();
		$cols_user = array();
		
		if ($password != $confirmp) {
			print '<div class="msg fail"><span class="icon"></span>Ops! Parece que você não digitou a senha corretamente.</div>';
			$st = false;
		}
		if ($usr->validatePassword($password) != true) {
			print '<div class="msg fail"><span class="icon"></span>Oh oh! Sua senha não é forte o suficiente. Feche os olhos, respire fundo e pense no Chuck Norris. Em seguida tente novamente. Dica: sua senha deve ter no mínimo: 8 caracteres, uma letra maiúscula, uma letra minúscula, um número e um caractér especial (.:<>:! etc.).</div>';
			$st = false;
		}
		
		/* Preparing array of values to be saved into DB */
		$cols_user = array('username' => "$username", 'senha' => sha1($password));
	}


	/* Preparing array of values to be saved into DB */
	$cols = array('id_tipo_voluntario' => $id_tipo_voluntario,
                'id_status' => $id_status,
                'nome' => $nome,
                'cpf' => $cpf,
                'rg' => "$rg ",
                'dt_nascimento' => $dt_nascimento,
                'endereco' => $endereco,
                'bairro' => $bairro,
                'cidade' => $cidade,
                'estado' => $estado,
                'cep' => $cep,
                'telefone' => $telefone,
                'profissao' => $profissao,
                'email ' => $email,
                'id_entidade' => $id_entidade,
                'id_nucleo' => $id_nucleo,
                'username' => $username
							 );

	if ($_REQUEST['enviar'] == 'edit_save' && $st != false) {
		$where = "$id_col = ". $_REQUEST[$id_col];
		if ($username != '' && $password != '') {
		  $where_user = "$id_col_user = '". $_REQUEST[$id_col_user] ."'";
		}

		if ($db->update($table, $cols, $where)) {
			$st = true;
			print '<div class="msg success"><span class="icon"></span>O registro foi salvo com sucesso.</div>';
			if ($username != '' && $password != '') {
				if ($db->update($table_user, $cols_user, $where_user)) {
					print '<div class="msg success"><span class="icon"></span>O usuário deste voluntário foi salvo com sucesso.</div>';
				} else {
					print '<div class="msg fail"><span class="icon"></span>Não foi possível salvar o usuário deste voluntário.</div>';
				}
			}
		} else {
			$st = false;
			print '<div class="msg fail"><span class="icon"></span>Não foi possível salvar o registro.</div>';
		}
	} elseif ($_REQUEST['enviar'] == 'save' && $st != false) {
		/* Savind new record into DB */
		if ($db->insert($table, $cols)) {
			$st = true;
			print '<div class="msg success"><span class="icon"></span>O registro foi salvo com sucesso.</div>';
			if ($username != '' && $password != '') {
				if ($db->insert($table_user, $cols_user, $where_user)) {
					print '<div class="msg success"><span class="icon"></span>O usuário deste voluntário foi salvo com sucesso.</div>';
				} else {
					print '<div class="msg fail"><span class="icon"></span>Não foi possível salvar o usuário deste voluntário.</div>';
				}
			}
		} else {
			$st = false;
			print '<div class="msg fail"><span class="icon"></span>Não foi possível salvar o registro.</div>';
		}
	}
}


/* Start HTML */
?>
<h1>Cadastro de Voluntarios</h1>

<?php

//importa o arquivo funcao_combo.php
  include_once('combobox.php');
    
if (!$st) {
  if ($_REQUEST['add']) {
		$btnval = 'save';
	} elseif ($_REQUEST['edit']) {
		$btnval = 'edit_save';
	}
?>
<div id="form" class="">
  <form id="cadastro_voluntario" name="cadastro_voluntario" method="post" action="index.php">
  <input type="hidden" id="p" name="p" value="<?php print $frm; ?>" />
  <input type="hidden" id="form" name="form" value="save" />
  <input type="hidden" id="id_voluntario" name="id_voluntario" value="<?php print $id_voluntario; ?>" />
  <input type="hidden" id="id_tipo_voluntario" name="id_tipo_voluntario" value="<?php print $id_tipo_voluntario; ?>" />
  <input type="hidden" id="id_status" name="id_status" value="<?php print $id_status; ?>" />
  <input type="hidden" id="id_entidade" name="id_entidade" value="<?php print $id_entidade; ?>" />
  <input type="hidden" id="id_nucleo" name="id_nucleo" value="<?php print $id_nucleo; ?>" />

  <div class="field odd first">
    <div class="label">Nome</div>
    <div class="field"><input type="text" id="nome" name="nome" value="<?php print $nome; ?>" /></div>
  </div>
  
  <div class="field even">
        <div class="label">Tipo Voluntário</div>
        <div class="field"> 
          <?php
            $db = new db();
            $list = $db->select('lr_tipo_voluntario');
            print ComboBox('id_tipo_voluntario', $list, $id_tipo_voluntario);
          ?>
        </div>
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
  
  <div class="field even">
    <div class="label">Entidade</div>
    <div class="field"> 
      <?php
        $db = new db();
        $list = $db->select('lr_entidade');
        print ComboBox('id_entidade', $list, $id_entidade);
      ?>
    </div>
  </div>
  
  <div class="field odd">
        <div class="label">Status</div>
        <div class="field"> 
          <?php
            $db = new db();
            $list = $db->select('lr_status');
            print ComboBox('id_status', $list, $id_status);
          ?>
        </div>
  </div>
  
  <div class="field even">
    <div class="label">CPF</div>
    <div class="field"><input type="number" id="cpf" name="cpf" value="<?php print $cpf; ?>" /></div>
  </div>
  
  <div class="field odd">
    <div class="label">RG</div>
    <div class="field"><input type="text" id="rg" name="rg" value="<?php print $rg; ?>" /></div>
  </div>
  
  <div class="field even">
    <div class="label">Data Nascimento</div>
    <div class="field"><input type="date" id="dt_nascimento" name="dt_nascimento" value="<?php print $dt_nascimento; ?>" /></div>
  </div>
  
  <div class="field odd">
    <div class="label">Endereco</div>
    <div class="field"><input type="text" id="endereco" name="endereco" value="<?php print $endereco; ?>" /></div>
  </div>
  
  <div class="field even">
    <div class="label">Bairro</div>
    <div class="field"><input type="text" id="bairro" name="bairro" value="<?php print $bairro; ?>" /></div>
  </div>
  
  <div class="field odd">
    <div class="label">Cidade</div>
    <div class="field"><input type="text" id="cidade" name="cidade" value="<?php print $cidade; ?>" /></div>
  </div>
  
  <div class="field even">
    <div class="label">Estado</div>
    <div class="field"><input type="text" id="estado" name="estado" value="<?php print $estado; ?>" /></div>
  </div>
  
  <div class="field odd">
    <div class="label">Cep</div>
    <div class="field"><input type="number" id="cep" name="cep" value="<?php print $cep; ?>" /></div>
  </div>
  
  <div class="field even">
    <div class="label">Telefone</div>
    <div class="field"><input type="text" id="telefone" name="telefone" value="<?php print $telefone; ?>" /></div>
  </div>
  
  <div class="field odd">
    <div class="label">Profissao</div>
    <div class="field"><input type="text" id="profissao" name="profissao" value="<?php print $profissao; ?>" /></div>
  </div>
  
  <div class="field even last">
    <div class="label">E-mail</div>
    <div class="field"><input type="email" id="email" name="email" value="<?php print $email; ?>" /></div>
  </div>

  <fieldset>
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
  </fieldset>


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
	$cols = $db->getColumnNames($view);
?>
<table id="table" class="<?php print $view; ?>">
  <thead>
    <tr><?php
    $cabecalho = array("ID Voluntário", "Nome", "Tipo Voluntário",  "Núcleo", "Bairro", "Telefone", "Email", "Entidade", "UserName");
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