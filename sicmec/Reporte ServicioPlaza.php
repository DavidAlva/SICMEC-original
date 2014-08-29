<?php
session_start();
//Validacion de Usuario
if($_SESSION['Validar'] != "OK" or $_SESSION["CveGrupo"] == 1){
		header("Location: index.php");
		exit();
	}
// VIENE DE LISTA SEREVICIOPLAZA.PHP

require_once('Connections/SICMEC.php');
mysql_select_db($database_SICMEC, $SICMEC);
//QUERYS QUE MUESTRAN LOS VALORES DEL SERVIOCIO REALIZADOA A LAS PLAZAS
$query_Recordset4 = "SELECT a.Descripcion, p.Nombre, sp.Descrip, sp.Observaciones, sp. FecServ, sp.Titulo, sp.Encargado FROM servicioplaza sp JOIN adscripcion a ON sp.CveAdscrip = a.CveAdscrip JOIN personal p ON sp.TecnicoINEA = p.NomUsu WHERE sp.CveServicio = '".$_REQUEST["CveServicio"]."' ORDER BY sp.FecServ DESC";
$Recordset4 = mysql_query($query_Recordset4, $SICMEC) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

$query_Recordset5 = "SELECT pt.Descripcion FROM servicioplaza sp JOIN puesto pt ON sp.CvePuesto = pt.CvePuesto WHERE sp.CveServicio = '".$_SESSION["CveServicio"]."' ORDER BY sp.FecServ DESC";
$Recordset5 = mysql_query($query_Recordset5, $SICMEC) or die(mysql_error());
$row_Recordset5 = mysql_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysql_num_rows($Recordset5);

//SE REALIZA UNA CONDICION PARA SABER SI EXISTEN REGISTROS QUE MOSTAR Y SER ESXPORTADOS
if ($totalRows_Recordset4 > 0)
{
//SE CREA UNA VARIABLE QUE SE VA CONCATENANDO TODO EL CODIGO A SER EXPORTADO DENTRO DE UN CICLO
//REPETIDO HASTA QUE EXISTAN REGISTROS
$shtml = $shtml."<table>";
$shtml = $shtml."  <tr>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."  </tr>";
$shtml = $shtml."  <tr>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."  </tr>";
$shtml = $shtml."  <tr>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."  </tr>";
$shtml = $shtml."  <tr>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."  </tr>";
$shtml = $shtml."  <tr>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."  </tr>";
$shtml = $shtml."  <tr>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."    <td><strong>SERVICO TCNICO A PLAZAS COMUNITARIAS</strong></td>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."  </tr>";
$shtml = $shtml."  <tr>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."  </tr>";
$shtml = $shtml."  <tr>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."    <td><strong>Fecha:  </strong>".$row_Recordset4['FecServ']."</td>";
$shtml = $shtml."  </tr>";
$shtml = $shtml."  <tr>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."  </tr>";
$shtml = $shtml."  <tr>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."    <td><strong>Plaza Comunitaria:</strong></td>";
$shtml = $shtml."    <td>".$row_Recordset4['Descripcion']."</td>";
$shtml = $shtml."  </tr>";
$shtml = $shtml."  <tr>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."  </tr>";
$shtml = $shtml."  <tr>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."  </tr>";
$shtml = $shtml."  <tr>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."    <td><strong>T&iacute;tulo:</strong></td>";
$shtml = $shtml."    <td>".$row_Recordset4['Titulo']."</td>";
$shtml = $shtml."  </tr>";
$shtml = $shtml."  <tr>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."  </tr>";
$shtml = $shtml."  <tr>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."  </tr>";
$shtml = $shtml."  <tr>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."    <td><strong>Descripci&oacute;n:</strong></td>";
$shtml = $shtml."    <td>".$row_Recordset4['Descrip']."</td>";
$shtml = $shtml."  </tr>";
$shtml = $shtml."  <tr>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."  </tr>";
$shtml = $shtml."  <tr>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."  </tr>";
$shtml = $shtml."  <tr>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."    <td><strong>Observaciones: </strong></td>";
$shtml = $shtml."    <td>".$row_Recordset4['Observaciones']."</td>";
$shtml = $shtml."  </tr>";
$shtml = $shtml."   <tr>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."  </tr>";
$shtml = $shtml."   <tr>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."  </tr>";
$shtml = $shtml."  <tr>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."  </tr>";
$shtml = $shtml."  <tr>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."  </tr>";
$shtml = $shtml."  <tr>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."  </tr>";
$shtml = $shtml."   <tr>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."    <td>".$row_Recordset4['Encargado']."</td>";
$shtml = $shtml."    <td>".$row_Recordset4['Nombre']."</td>";
$shtml = $shtml."  </tr>";
$shtml = $shtml."   <tr>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."    <td><strong>".$row_Recordset5['Descripcion']."</strong></td>";
$shtml = $shtml."    <td><strong>T&eacute;cnico INEA</strong></td>";
$shtml = $shtml."  </tr>";
$shtml = $shtml."   <tr>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."    <td>Recibe Servicio</td>";
$shtml = $shtml."    <td></td>";
$shtml = $shtml."  </tr>";
$shtml = $shtml."</table>";
//VALORES Y FUNCIONES REQUERIDOA A LA HORA DE EXPORTAR
$fecha = date(' Y-m-d ');
//$fecha.= date('H-i-s');
$scarpeta="/opt/lampp/htdocs/sicmec/Reportes"; //carpeta donde guardar el archivo.
$sfile=$scarpeta."/Servicio ".$_SESSION["NomUsu"].".xls"; //ruta del archivo a generar
$archivo = "http://guanajuato.inea.gob.mx/sicmec/Reportes/Servicio ".$_SESSION["NomUsu"].".xls";
$fp=fopen($sfile,"w+");
fwrite($fp,$shtml);
fclose($fp);
?>
<script language="javascript">
      location.href="<? echo $archivo; ?>"
</script>
<?
}
//EN CASO DE QUE LA CONDICION NO SE CULPLA MANDAMOS UN MENSAJE
else
{
?>
 <script language="javascript"> alert('El Reporte no contiene ningun valor.'); </script>
<?
}
