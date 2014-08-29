<?php
include_once('equipoComputo.class.php');

function llenaTabla($datos){
    $par = 1;
    echo "<br/><p align='center'><a>Seleccionar:</a> <a href='javascript:SelecAllNone(\"CveActivo\",true)'>Todo,</a> <a href='javascript:SelecAllNone(\"CveActivo\",false)'>ninguno</a></p>
		<table id='activo' name='activo' cellpadding='0' cellspacing='0' border='0' class='rowstyle-alt colstyle-alt no-arrow sortable-onload-1'>
		<thead>
      <tr>
        <th></th>
        <th class='sortable-text'>Cat&aacute;logo</th>
        <th class='sortable-text'>Num Inventario</th>
        <th class='sortable-text'>Descripci&oacute;n</th>
      </tr>
    </thead><tbody>";
    while($campo = mysql_fetch_row($datos)){
    	if ($par == 2){
    		echo "<tr class='alt'>";
    		$par = 1;
    	}
    	else{
    		echo "<tr>";
    		$par = 2;
    	}
    	echo "<td><input type='checkbox' value=\"" . $campo[0] . "\"  name='CveActivo' /></td>
        		<td>" . $campo[1] . "</td>
        		<td>" . $campo[2] . "</td>
        		<td>" . $campo[3] . "</td>
      	</tr>";
    }
    echo "</tbody></table>";
}
$sCvecat = trim($_REQUEST['cvecatalogo']);
$sNuminv = trim($_REQUEST['numinv']);
$sAnio = trim($_REQUEST['annio']);

//Constructor de EquipoComputo(cveEquipo,CveCatalogo,NumInventario,Annio)
$equipo = new EquipoComputo('',$sCvecat,$sNuminv,$sAnio);
$datSet = $equipo->consultaEquipo();
llenaTabla($datSet);

?>