<?php require_once('Connections/SICMEC.php'); ?>
<?php
ini_set('max_execution_time', 3600);

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
    $editFormAction = $_SERVER['PHP_SELF'];
    if (isset($_SERVER['QUERY_STRING'])) {
        $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
    }
//SELECCIONA TODO EL EQUIPO QUE HAY EN LA TABLA DE TEMPORAL
    mysql_select_db($database_SICMEC, $SICMEC);
    $query_constemp = sprintf("SELECT * FROM tempactivo GROUP BY CveCatalogo, NumInv, AnnoAlta ORDER BY CveAct");
    $constemp = mysql_query($query_constemp, $SICMEC) or die(mysql_error());
    $totalRows_constemp = mysql_num_rows($constemp);
    $actualizados = 0;
    $insertados = 0;
	//MIENTRAS QUE HAYA EQUIPOS EN TEMPACTIVO VA HACIENDO LAS COMPARACIONES CON TEMPORAL
    while ($row_constemp = mysql_fetch_assoc($constemp)) {
        $query_cons = sprintf("SELECT * FROM actfijo WHERE CveCatalogo = '%s' AND NumInv = %s AND AnnoAlta= %s AND NumSerie = '%s'",trim($row_constemp['CveCatalogo']), $row_constemp['NumInv'], $row_constemp['AnnoAlta'], trim($row_constemp['NumSerie']));
        $cons = mysql_query($query_cons, $SICMEC) or die(mysql_error());
        $row_cons = mysql_fetch_assoc($cons);
        $totalRows_cons = mysql_num_rows($cons);		
		// SI CveBaja DE TEMPACTIVO ES IGUAL A 0 SIGNIFICA QUE EL EQUIPO ESTA FUNCIONANDO SI ES DIFERENTE DE 0 ESTA DADO DE BAJA
        if ($row_constemp['CveBaja'] == 0)
            $status = 1; // CORRECTO
        else{
            if ($row_constemp['CveBaja'] == 2)
                $status = 12;  // BAJA
			else
				$status = $row_constemp['CveBaja'];} //EL VALOR QUE TENGAN
		// SI ENCONTRO UN EQUIPO EN AMBAS TABLAS SOLO ACTUALIZA LOS DATOS DE ESTE, SI NO INSERTA UN NUEVO EQUIPO	
        if ($totalRows_cons > 0) {
            $updateSQL = sprintf("UPDATE actfijo SET CaractAcf='%s', CveAdscrip='%s', CveStatus='%s' WHERE NumInv = %s And CveCatalogo = '%s' AND AnnoAlta = %s", $row_constemp['CaractAcf'], trim($row_constemp['CveAdscrip']), $status, $row_constemp['NumInv'], trim($row_constemp['CveCatalogo']), $row_constemp['AnnoAlta']);
            $Result1 = mysql_query($updateSQL, $SICMEC) or die(mysql_error());
            $actualizados = $actualizados + 1;
        } else {   // LOS VALORES '0' ES DE CveHist Y EL VALOR '2' ES DE LA UBICACION 'CORRECTO' 
			$insertSQL = sprintf("INSERT INTO actfijo (CveCatalogo, NumInv, AnnoAlta, CaractAcf, CveHist, CveStatus, CveUbic, CveAdscrip, NumSerie) VALUES ('%s', %s, %s, '%s',0, %s, 2, '%s', '%s')", trim($row_constemp['CveCatalogo']), $row_constemp['NumInv'], $row_constemp['AnnoAlta'], $row_constemp['CaractAcf'], $status, trim($row_constemp['CveAdscrip']), trim($row_constemp['NumSerie']));
            $Result1 = mysql_query($insertSQL, $SICMEC) or die(mysql_error());
            $insertados = $insertados + 1;
        }
    }
    ?>
    <script>
                <script language="javascript"> alert('Proceso Terminado!'); </script>
    </script>
    <?
    echo "Actualizados = " . $actualizados;
    echo " - Insertados = " . $insertados;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>Actualizaci?n de Registros</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    </head>
    <body>
        <table width="43%" border="0" align="center"><!--DWLayoutTable-->
            <tr>
                <td><div align="center" class="Estilo1">Procedimiento para Actualizar la BD del Activo Fijo </div></td>
            </tr>
            <tr>
                <td width="100%"><form name="form1" method="post" action="">
                        <div align="center">
                            <input type="submit" name="Submit" value="Actualiza Activo fijo">
                            <input type="hidden" name="MM_insert" value="form1">
                        </div>
                    </form></td>
            </tr>
        </table>
    </body>
</html>