<?php require_once('Connections/SICMEC.php'); ?>
<?php
ini_set('max_execution_time', 3600);

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
    $editFormAction = $_SERVER['PHP_SELF'];
    if (isset($_SERVER['QUERY_STRING'])) {
        $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
    }
//SELECCIONA TODOS LAS ADSCRIPCIONES QUE HAY EN LA TABLA DE TEMPADSCRIP
    mysql_select_db($database_SICMEC, $SICMEC);
    $query_constemp = sprintf("SELECT * FROM tempadscripcion ORDER BY CveAdscrip");
    $constemp = mysql_query($query_constemp, $SICMEC) or die(mysql_error());
    $totalRows_constemp = mysql_num_rows($constemp);
    $actualizados = 0;
    $insertados = 0;
	//MIENTRAS QUE HAYA ADSCRIPCIONES VA HACIENDO LAS COMPARACIONES CON TEMPORAL
    while ($row_constemp = mysql_fetch_assoc($constemp)) {
        $query_cons = sprintf("SELECT * FROM adscripcion WHERE CveAdscrip = '%s'", trim($row_constemp['CveAdscrip']));
        $cons = mysql_query($query_cons, $SICMEC) or die(mysql_error());
        $row_cons = mysql_fetch_assoc($cons);
        $totalRows_cons = mysql_num_rows($cons);
	// SI ENCONTRO UNA ADSCRIPCION EN AMBAS TABLAS SOLO ACTUALIZA LOS DATOS DE ESTA, SI NO INSERTA UNA NUEVA	
        if ($totalRows_cons > 0) {
			
            $updateSQL = sprintf("UPDATE adscripcion SET Descripcion='%s', Responsable='%s', Domicilio='%s', Colonia='%s', Poblacion='%s', CodPostal='%s', Telefono='%s', TipoAdsc='%s' WHERE CveAdscrip='%s'", $row_constemp['Descripcion'], $row_constemp['Responsable'], trim($row_constemp['Domicilio']), $row_constemp['Colonia'], trim($row_constemp['Poblacion']), trim($row_constemp['CodPostal']), $row_constemp['telefono'], $row_constemp['TipoAdsc'], trim($row_constemp['CveAdscrip']));
			$Result1 = mysql_query($updateSQL, $SICMEC) or die(mysql_error());
            $actualizados = $actualizados + 1;
        } else {
            $insertSQL = sprintf("INSERT INTO adscripcion (CveAdscrip, Descripcion, Responsable, Domicilio, Colonia, Poblacion, CodPostal, Telefono, TipoAdsc) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",trim($row_constemp['CveAdscrip']), $row_constemp['Descripcion'], $row_constemp['Responsable'], trim($row_constemp['Domicilio']), $row_constemp['Colonia'], trim($row_constemp['Poblacion']), trim($row_constemp['CodPostal']), $row_constemp['telefono'], $row_constemp['TipoAdsc']);
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
                            <input type="submit" name="Submit" value="Actualiza Adscripciones">
                            <input type="hidden" name="MM_insert" value="form1">
                        </div>
                    </form></td>
            </tr>
        </table>
    </body>
</html>