<?php

$MSG_PADRAO_ARQUIVO_CSV = 'Informe um arquivo .CSV para importação';
$EXTENSAO_VALIDA = 'csv';

if (isset($_FILES['arquivo'])) {
	$filename = $_FILES['arquivo']['tmp_name'];

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
	$CONS_RAZAO_SOCIAL_ESTABELECIMENTO = 9; #Razão Social Estabelecimento
	
	function onlyNumbers($oldValue) {
		return preg_replace("/[^0-9]/", "", $oldValue);
	}

	function onlyNumbersMonetary($oldValue) {
		return str_replace(',', '.', str_replace('.', '', preg_replace("/[^0-9,.]/", "", $oldValue)));
	}

	//abrir arquivo em modo leitura
	if ($file_handle = fopen($filename, "r")) {
		$count = 0;
		
		//loop na leitura
		while (!feof($file_handle)) {
		   $line = fgets($file_handle);
		   $arr = explode(";", $line);
		   
		   if ($count > 0 && is_numeric($arr[$CONS_NUM_NOTA])) { //ignorar a primeira coluna e quaisquer outra que a primeira coluna não seja numérica (última linha)
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

				
		   }
		   
		   $count++;
		}

		fclose($file_handle);
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