<?php
/* Define what DB table and form will be used in this form */
$table = 'lr_nota';
$frm = 'frm_importacao';
$id_col = 'id_nota';

/* Load this screen's permissions for current user */
/*
if (isset($_SESSION['user']['permissions'][$frm])) {
	$access = $_SESSION['user']['permissions'][$frm];
} else {
	print '<div class="msg fail"><span class="icon"></span>Acesso restrito. Consulte um administrador para solicitar permissão para visualizar esta página.</div>';
	die;
}
*/

$MSG_PADRAO_ARQUIVO_CSV = 'Informe um arquivo .CSV para importação';
$EXTENSAO_VALIDA = 'csv';

if (isset($_FILES['arquivo'])) {
	$filename = $_FILES['arquivo']['tmp_name'];
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
	/* abrir arquivo em modo leitura */
  $file_handle = fopen($filename, "r");
  $count = 0;

  while (!feof($file_handle)) {
     $line = fgets($file_handle);
     $arr[$count] = explode(";", $line);
     $count++;
  }
  fclose($file_handle);

  include_once('class.db.php');
  $db = new db();
  
  $st = true;
  foreach ($arr as $item) {
    if (count($item) > 1 && is_numeric($item[$CONS_NUM_NOTA])) {
      $cols = array('data_importacao' => $import_timestamp,
                    'csv_numero_nota' => $item[$CONS_NUM_NOTA],
                    'csv_valor_nota' => onlyNumbersMonetary($item[$CONS_VALOR_NOTA]),
                    'csv_data_nota' => dateconvert($item[$CONS_DATA_NOTA], 1),
                    'csv_cnpj_entidade_social' => onlyNumbers($item[$CONS_CNPJ_ENT_SOCIAL]),
                    'csv_cpf_cadastrador' => onlyNumbers($item[$CONS_CPF_DOADOR_CADASTRADOR]),
                    'csv_data_pedido' => dateconvert($item[$CONS_DATA_PEDIDO], 1),
                    'csv_status_pedido' => $item[$CONS_STATUS_PEDIDO],
                    'csv_tipo_pedido' => $item[$CONS_TIPO_PEDIDO],
                    'csv_cnpj_estabelecimento' => onlyNumbers($item[$CONS_CNPJ_ESTABELECIMENTO]),
                    'csv_razao_social_estab' => $item[$CONS_RAZAO_SOCIAL_ESTABELECIMENTO],
                    );
    if (!$db->insert('lr_importa_arquivo_nota', $cols)) {
      print '<div class="msg fail"><span class="icon"></span>Não foi possível salvar o registro.</div>';
      $st = false;
    }
      /*
      $num_nota = $arr[$CONS_NUM_NOTA];
      $valor_nota = onlyNumbersMonetary($arr[$CONS_VALOR_NOTA]);
      $data_nota = $arr[$CONS_DATA_NOTA];
      $cnpj_ent_social = onlyNumbers($arr[$CONS_CNPJ_ENT_SOCIAL]);
      $cpf_doador_cadastrador = onlyNumbers($arr[$CONS_CPF_DOADOR_CADASTRADOR]);
      $data_pedido = $arr[$CONS_DATA_PEDIDO];
      $status_pedido = $arr[$CONS_STATUS_PEDIDO];
      $tipo_pedido = $arr[$CONS_TIPO_PEDIDO];
      $cnpj_estabelecimento = onlyNumbers($arr[$CONS_CNPJ_ESTABELECIMENTO]);
      $razao_social_estabelecimento = $arr[$CONS_RAZAO_SOCIAL_ESTABELECIMENTO];
      */
    }
  }
}
?>

<script type="text/javascript">
	function validar() {
		if (!verificarExtensao()){ //extensão inválida
			alert('<?php echo $MSG_PADRAO_ARQUIVO_CSV; ?>');
			return false;
		}
		
		return true;
	}
	
	function verificarExtensao() {
		return document.getElementById('arquivo').value.toLowerCase().indexOf('.<?php echo $EXTENSAO_VALIDA; ?>') > -1;
	}
</script>
<h1>Importação de Arquivo</h1>
<div id="form" class="">
  <form id="importacao" name="importacao" method="post" action="index.php?p=frm_importacao" enctype="multipart/form-data" onsubmit="return validar();">

  <div class="field odd first">
  <div class="label">Arquivo CSV de Importação</div>
  <div class="field"><input type="file" id="arquivo" name="arquivo" title="<?php echo $MSG_PADRAO_ARQUIVO_CSV; ?>" required /></div>
  </div>
  
  <div class="field action">
    <div class="field"><button type="submit" id="enviar" name="enviar" value="save"><span class="icon"></span>Salvar</button></div>
  </div>
  
  </form>
</div>