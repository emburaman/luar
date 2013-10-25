	<?php
	$error = "";
	$msg = "";
	$upload_file = $_GET['sender'];

	if (!empty($_FILES[$upload_file]['error'])) {
		switch($_FILES[$upload_file]['error']) {
			case '1':
				$error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
				break;
			case '2':
				$error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
				break;
			case '3':
				$error = 'The uploaded file was only partially uploaded';
				break;
			case '4':
				$error = 'No file was uploaded.';
				break;
			case '6':
				$error = 'Missing a temporary folder';
				break;
			case '7':
				$error = 'Failed to write file to disk';
				break;
			case '8':
				$error = 'File upload stopped by extension';
				break;
			default:
				$error = 'No error code avaiable';
		}
	}

	if (empty($_FILES[$upload_file]['tmp_name']) || $_FILES[$upload_file]['tmp_name'] == 'none') {
		$error = 'No file was uploaded..';
	}

	$msg .= " File Name: " . $_FILES[$upload_file]['name'] . ", ";
	$msg .= " File Size: " . @filesize($_FILES[$upload_file]['tmp_name']);

	if ($upload_file == 'importacaoArquivoNota') {
		uploadArquivoImportacaoNota($upload_file);
	}

	//for security reason, we force to remove all uploaded file
	@unlink($_FILES[$upload_file]);

	echo "{";
	echo	"error: '" . $error . "',\n";
	echo	"msg: '" . $msg . "'\n";
	echo "}";

	function uploadArquivoImportacaoNota($upload_file) {
		/* Define what DB table and form will be used in this form */
		$table = 'lr_nota';
		$table_importacao = 'lr_importa_arquivo_nota';

		if (isset($_FILES[$upload_file])) {
		  $filename = $_FILES[$upload_file]['tmp_name'];
		  $lines = count(file($filename));

		  date_default_timezone_set('America/Sao_Paulo');
		  $import_timestamp = date('Y-m-d H:i:s');

		  /*valores constantes, posições das colunas*/
		  $CONS_NUM_NOTA = 0; #Número da Nota;
		  $CONS_VALOR_NOTA = 1; #Valor da Nota;
		  $CONS_DATA_NOTA = 2; #Data da Nota;
		  $CONS_CNPJ_ENT_SOCIAL = 3; #CNPJ Entidade Social;
		  $CONS_CPF_DOADOR_CADASTRADOR = 4; #CPF Doador/Cadastrador;
		  $CONS_DATA_PEDIDO = 5; #Data do Pedido;
		  $CONS_STATUS_PEDIDO = 6; #Status do Pedido;
		  $CONS_TIPO_PEDIDO = 7; #Tipo do Pedido;
		  $CONS_CNPJ_ESTABELECIMENTO = 8; #CNPJ Estabelecimento;
		  $CONS_RAZAO_SOCIAL_ESTABELECIMENTO = 9; #Razão Social Estabelecimento;
		  
		  include_once('class.db.php');

		  $db = new db();

		  function onlyNumbers($oldValue) {
		    return preg_replace("/[^0-9]/", "", $oldValue);
		  }
		  function onlyNumbersMonetary($oldValue) {
		    return str_replace(',', '.', str_replace('.', '', preg_replace("/[^0-9,.]/", "", $oldValue)));
		  }
		  function dateconvert($date, $func) {
		    if ($func == 1){ //insert conversion
		      list($day, $month, $year) = preg_split('/[-\.\/ ]/', $date); 
		      $date = "$year-$month-$day"; 
		      return $date;
		    }
		    if ($func == 2){ //output conversion
		      list($year, $month, $day) = preg_split('/[-\.\/ ]/', $date); 
		      $date = "$day/$month/$year"; 
		      return $date;
		    }
		  }
		  function obterIdVoluntario($cpf, $db) {
		    $arr_cpf_cadastrador = $db->select('lr_voluntario','id_voluntario', "cpf = ". $cpf);

		    if (count($arr_cpf_cadastrador[0]) == 0) {
		      #cadastrar voluntário
		      $cols_voluntario = array('id_tipo_voluntario' => 4,
		                              'id_status' => 3,
		                              'cpf' => $cpf
		                              );

		      $db->insert('lr_voluntario', $cols_voluntario);

		      #consulta novamente para obter o id_voluntario
		      $arr_cpf_cadastrador = $db->select('lr_voluntario','id_voluntario', "cpf = ". $cpf);
		    }

		    #retorna id_voluntario
		    return $arr_cpf_cadastrador[0]['id_voluntario'];
		  }
		  function obterIdEmpresa($cnpj_estabelecimento, $razao_social, $db) {
		    $arr_cnpj_entidade = $db->select('lr_empresa','id_empresa', "cnpj = ". $cnpj_estabelecimento);

		    if (count($arr_cnpj_entidade[0]) == 0) {
		      #cadastrar empresa
		      $cols_empresa = array('cnpj' => $cnpj_estabelecimento,
		                              'razao_social' => $razao_social,
		                              'nome_fantasia' => $razao_social
		                              );

		      $db->insert('lr_empresa', $cols_empresa);

		      #consulta novamente para obter o id_empresa
		      $arr_cnpj_entidade = $db->select('lr_empresa','id_empresa', "cnpj = ". $cnpj_estabelecimento);
		    }

		    #retorna id_empresa
		    return $arr_cnpj_entidade[0]['id_empresa'];
		  }

		  #abrir arquivo em modo leitura
		  $file_handle = fopen($filename, "r");
		  $count = 0;

		  while (!feof($file_handle)) {
		     $line = fgets($file_handle);
		     $arr[$count] = explode(";", $line);
		     $count++;
		  }

		  #fechar arquivo
		  fclose($file_handle);

		  foreach ($arr as $item) {
		    if (count($item) > 1 && is_numeric($item[$CONS_NUM_NOTA])) {
		      $cpf_cadastrador = onlyNumbers($item[$CONS_CPF_DOADOR_CADASTRADOR]);
		      $cnpj_estabelecimento = onlyNumbers($item[$CONS_CNPJ_ESTABELECIMENTO]);
		      $nome_estabelecimento = $item[$CONS_RAZAO_SOCIAL_ESTABELECIMENTO];
		      $valor_nota = onlyNumbersMonetary($item[$CONS_VALOR_NOTA]);
		      $numero_nota = $item[$CONS_NUM_NOTA];
		      $data_nota = dateconvert($item[$CONS_DATA_NOTA], 1);

		      $cols = array('data_importacao' => $import_timestamp,
		                    'csv_numero_nota' => $numero_nota,
		                    'csv_valor_nota' => $valor_nota,
		                    'csv_data_nota' => $data_nota,
		                    'csv_cnpj_entidade_social' => onlyNumbers($item[$CONS_CNPJ_ENT_SOCIAL]),
		                    'csv_cpf_cadastrador' => $cpf_cadastrador,
		                    'csv_data_pedido' => dateconvert($item[$CONS_DATA_PEDIDO], 1),
		                    'csv_status_pedido' => $item[$CONS_STATUS_PEDIDO],
		                    'csv_tipo_pedido' => $item[$CONS_TIPO_PEDIDO],
		                    'csv_cnpj_estabelecimento' => $cnpj_estabelecimento,
		                    'csv_razao_social_estab' => $nome_estabelecimento
		                    );

		      #busca em lr_voluntario pelo cpf e retorna o id_voluntario, caso não encontre o voluntario insere o registro
		      $id_voluntario = obterIdVoluntario($cpf_cadastrador, $db);

		      #busca em lr_empresa pelo cnpj e retorna o id_empresa, caso não encontre a empresa insere o registro
		      $id_empresa = obterIdEmpresa($cnpj_estabelecimento, $nome_estabelecimento, $db);

		      $cols_nota = array('numero_nota' => $numero_nota,
		        'id_empresa' => $id_empresa,
		        'id_voluntario_digitador' => $id_voluntario,
		        'valor_nota' => $valor_nota,
		        'data_nota' => $data_nota,
		        'cod_status_nota' => 'CADASTRADA');

		      #insere nota em lr_importa_arquivo_nota e lr_nota
		      if (!$db->insert($table_importacao, $cols)) {
		        #informa qual número da nota não foi inserida
		        print '<div class="msg fail"><span class="icon"></span>Não foi possível salvar o registro '. $item[$CONS_NUM_NOTA] .'.</div>';
		      }

		      $db->insert($table, $cols_nota);
		    }
		  }
		}
		return $msg;
	}

?>