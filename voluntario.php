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

/* Declaring form variables */
$id_voluntario = '';
$id_tipo_voluntario = '';
$id_status = '';
$nome = '';
$cpf = '';
$rg = '';
$dt_nascimento = '';
$endereco = '';
$bairro = '';
$cidade = '';
$estado = '';
$cep = '';
$telefone = '';
$profissao = '';
$email  = '';
$id_entidade = '';
$id_nucleo = '';

$username = '';
$password = '';
$confirmp = '';

/* Check if form was posted and if so, add record into DB */
if (isset($_POST['form'])) {
	/* Field mapping from form into DB table */
	$id_voluntario = $_POST['id_voluntario'];
	$id_tipo_voluntario = $_POST['id_tipo_voluntario'];
	$id_status = $_POST['id_status'];
	$nome = $_POST['nome'];
	$cpf = $_POST['cpf'];
	$rg = $_POST['rg'];
	$dt_nascimento = $_POST['dt_nascimento'];
	$endereco = $_POST['endereco'];
	$bairro = $_POST['bairro'];
	$cidade = $_POST['cidade'];
	$estado = $_POST['estado'];
	$cep = $_POST['cep'];
	$telefone = $_POST['telefone'];
	$profissao = $_POST['profissao'];
	$email  = $_POST['email'];
	$id_entidade = $_POST['id_entidade'];
  $id_nucleo = $_POST['id_nucleo'];
	
  $username = $_POST['username'];
	$password = $_POST['senha'];
	$confirmp = $_POST['cfsenha'];

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

	if ($_POST['enviar'] == 'edit_save' && $st != false) {
		$where = "$id_col = ". $_POST[$id_col];
		if ($username != '' && $password != '') {
		  $where_user = "$id_col_user = '". $_POST[$id_col_user] ."'";
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
	} elseif ($_POST['enviar'] == 'save' && $st != false) {
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
  if (isset($_POST['add'])) {
		$btnval = 'save';
	} elseif (isset($_POST['edit'])) {
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

  <fieldset class="userdata">
  <p>Se você deseja criar um usuário para este voluntário, preencha os campos abaixo.</p>
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