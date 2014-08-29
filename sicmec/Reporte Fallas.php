<?php
session_start();
//Validacion de Usuario
if($_SESSION['Validar'] != "OK" or $_SESSION["CveGrupo"] == 1){
		header("Location: index.php");
		exit();
	}
// VIENE DE LISTAREPORTE.PHP

 require_once('Connections/SICMEC.php');

mysql_select_db($database_SICMEC, $SICMEC);
//INICIAMOS LAS VARIABLES DE SESION Y HACEMOS EL QUERY CON EL VALOR GUARDADO EN "LISTAREPORTE.PHP"
$Recordset3 = mysql_query($_SESSION["query_Recordset3"], $SICMEC) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);
//SE REALIZA UNA CONDICION PARA SABER SI EXISTEN REGISTROS QUE MOSTAR Y SER ESXPORTADOS
if ($totalRows_Recordset3 > 0)
{
//SE CREA UNA VARIABLE QUE SE VA CONCATENANDO TODO EL CODIGO A SER EXPORTADO DENTRO DE UN CICLO
//REPETIDO HASTA QUE EXISTAN REGISTROS
$shtml = "<table>";
$shtml = $shtml."<tr>REPORTE DE FALLAS REPORTADAS</span></tr><tr>";
$shtml = $shtml."<th>Reporte</span></th>";
$shtml = $shtml."<th>Fecha</span></th>";
$shtml = $shtml."<th>Titulo</span></th>";
$shtml = $shtml."<th>Reporto</span></th>";
$shtml = $shtml."<th>Plaza</span></th>";
$shtml = $shtml."<th>Reporte</span></th>";
$shtml = $shtml."<th>Status</span></th>";
$shtml = $shtml."</tr>";
     do {
$shtml = $shtml."<tr>";
$shtml = $shtml."<td>".$row_Recordset3['CveRep']."</td>";
$shtml = $shtml."<td>".$row_Recordset3['FecRep']."</td>";
$shtml = $shtml."<td>".$row_Recordset3['Titulo']."</td>";
$shtml = $shtml."<td>".$row_Recordset3['Nombre']."</td>";
$shtml = $shtml."<td>".$row_Recordset3['Descripcion']."</td>";
$shtml = $shtml."<td>".$row_Recordset3['Reporte']."</td>";
$shtml = $shtml."<td>".$row_Recordset3['Status']."</td>";
$shtml = $shtml."</tr>";
      } while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));
 $shtml = $shtml."</table>";
 $fecha = date(' Y-m-d ');
$fecha.= date('H-i-s');
//VALORES Y FUNCIONES REQUERIDOA A LA HORA DE EXPORTAR
$scarpeta="/opt/lampp/htdocs/sicmec/Reportes"; //carpeta donde guardar el archivo.
$sfile=$scarpeta."/Fallas".$_SESSION["NomUsu"].".xls"; //ruta del archivo a generar
$archivo = "http://guanajuato.inea.gob.mx/sicmec/Reportes/Fallas".$_SESSION["NomUsu"].".xls";
$fp=fopen($sfile,"w+");
fwrite($fp,$shtml);
fclose($fp);
//SE MANDA UNA VENTANA EMERGENTE DONDE SE PIDE GUARDAR O ABRIR EL ARCHIVO
header("Location:$archivo");
}
//EN CASO DE QUE LA CONDICION NO SE CULPLA MANDAMOS UN MENSAJE
else
{
?>
 <script language="javascript"> alert('El Reporte no contiene ningun valor.');
 </script>
<?
}
?>

