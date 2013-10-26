<?php
/* Define what DB table and form will be used in this form */
$id_col = 'id_nota';
$frm = 'frm_importacao';

/* Load this screen's permissions for current user */
if (isset($_SESSION['user']['permissions'][$frm])) {
	$access = $_SESSION['user']['permissions'][$frm];
} else {
	print '<div class="msg fail"><span class="icon"></span>Acesso restrito. Consulte um administrador para solicitar permissão para visualizar esta página.</div>';
	die;
}

$MSG_PADRAO_ARQUIVO_CSV = 'Informe um arquivo .CSV para importação';
$EXTENSAO_VALIDA = 'csv';
?>

<style type="text/css">
</style>
<script type="text/javascript" src="jquery.min.js"></script>
<script type="text/javascript">
  var error = ''; //mensagem de erro

	function validar() {
		if (!verificarExtensao()){ //extensão inválida
			alert('<?php echo $MSG_PADRAO_ARQUIVO_CSV; ?>');
			return false;
		}
		
		return true;
	}
	
	function verificarExtensao() {
		return document.getElementById('importacaoArquivoNota').value.toLowerCase().indexOf('.<?php echo $EXTENSAO_VALIDA; ?>') > -1;
	}

  function ajaxFileUpload(self, sender) {
    if (self.disabled == 'disabled')
      return false;

    if (!validar())
      return false;

    self.disabled = 'disabled';

    $("#loading")
      .ajaxStart(function(){
        $(this).fadeIn();
      })
      .ajaxComplete(function(){
        if (error.length == 0) {
          $(this).removeClass('fail');
          $(this).html('Importação realizada com sucesso.');
          $(this).addClass('success');
        }
        else {
          $(this).html('Houve algum erro na importação.<br>Mensagem: ' + error);
        }
      });

    $.ajaxFileUpload({
      url:'ajaxupload.php?sender=' + sender, 
      secureuri: false,
      fileElementId: sender,
      dataType: 'json',
      success: function (data, status) {
        if(typeof(data.error) != 'undefined' && data.error != '') {
          error = data.error;
        }
      },
      error: function (data, status, e) {
        error = e;
      }
    });

    return false;
  }
</script>
<h1>Importação de Arquivo</h1>
<div id="form" class="">
  <form id="importacao" name="importacao" action="" method="POST" enctype="multipart/form-data">
    <div class="field odd first">
      <div class="label">Arquivo CSV de Importação</div>
      <div class="field"><input type="file" id="importacaoArquivoNota" name="importacaoArquivoNota" title="<?php echo $MSG_PADRAO_ARQUIVO_CSV; ?>" required /></div>
    </div>
    <div id="loading" class="msg fail" style="display: none;">Carregando arquivo...</div>
    <div class="field action">
      <div class="field"><button type="submit" id="enviar" name="enviar" value="save" onclick="return ajaxFileUpload(this, 'importacaoArquivoNota');"><span class="icon"></span>Importar</button></div>
    </div>
  </form>
</div>