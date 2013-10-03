<?php
function comboBox($name, $list, $id_consulta = null) {
  $resultado = "<select name='$name' id='$name' class='combo'><option value=0>-- Selecione --</option>";
 
  for ($i = 0; $i < count($list); $i++) {
    $sel = '';
    if ($list[$i][$name] == $id_consulta) {
      $sel = ' selected="selected"';
    }
    $resultado .= '<option value="'. $list[$i][$name] .'"'. $sel .'>'. $list[$i]['descricao'] .'</option>';
  }
  $resultado .='</select>';
 
  return $resultado;
}
?>