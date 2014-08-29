<?php
session_start();
//Validacion de Usuario
if($_SESSION['Validar'] != "OK" ){
		header("Location: index.php");
		exit();
	}
// VIENE DE LISTAREPORTE.PHP
 require_once('Connections/SICMEC.php');
mysql_select_db($database_SICMEC, $SICMEC);
//INICIAMOS LAS VARIABLES DE SESION Y HACEMOS EL QUERY CON EL VALOR GUARDADO EN "LISTAREPORTE.PHP"

$Recordset4 = mysql_query($_SESSION["query_Recordset4"], $SICMEC) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

//SE REALIZA UNA CONDICION PARA SABER SI EXISTEN REGISTROS QUE MOSTAR Y SER ESXPORTADOS
if ($totalRows_Recordset4 > 0)
{
  //SE CREA UNA VARIABLE QUE SE VA CONCATENANDO TODO EL CODIGO A SER EXPORTADO DENTRO DE UN CICLO
  //REPETIDO HASTA QUE EXISTAN REGISTROS
  $shtml = "<table>";
  $shtml = $shtml."<tr>REPORTE DE HISTORIAL DEL EQUIPO</span></tr>";
  $shtml = $shtml."<tr>";
  $shtml = $shtml."<th>Plaza</span></th>";
  $shtml = $shtml."<th>Inventario</span></th>";
  $shtml = $shtml."<th>Descripci&oacute;n</span></th>";
  $shtml = $shtml."<th>Caracter&iacute;ticas</span></th>";
  $shtml = $shtml."<th>Fecha</span></th>";
  $shtml = $shtml."<th>Diagn&oacute;stico</span></th>";
  $shtml = $shtml."<th>Status</span></th>";
  $shtml = $shtml."<th>Ubicaci&oacute;n</span></th>";
  $shtml = $shtml."<th>T&eacute;cnico INEA</span></th>";
  $shtml = $shtml."</tr>";
  do {
  //QUERY QUE OBTIENE EL NOMBRE DEL TECNICO INEA
      $query_Recordset5 = "SELECT Nombre FROM personal WHERE NomUsu = '".$row_Recordset4['TecnicoINEA']."'";
      $Recordset5 = mysql_query($query_Recordset5, $SICMEC) or die(mysql_error());
      $row_Recordset5 = mysql_fetch_assoc($Recordset5);
      $shtml = $shtml."<tr>";
      $shtml = $shtml."<td>".$row_Recordset4['CveAdscrip'].",   ";
      $shtml = $shtml.$row_Recordset4['Descripcion'].",   ";
      $shtml = $shtml.$row_Recordset4['Poblacion']."</td>";
      $shtml = $shtml."<td>".$row_Recordset4['CveCatalogo']."-";
      $shtml = $shtml.$row_Recordset4['NumInv'];
      $shtml = $shtml."-".$row_Recordset4['AnnoAlta']."</td>";
      $shtml = $shtml."<td>".$row_Recordset4['DescCatalogo']."</td>";
      $shtml = $shtml."<td>".$row_Recordset4['CaractAcf']."</td>";
      $shtml = $shtml."<td>".$row_Recordset4['FecHist']."</td>";
      $shtml = $shtml."<td>".$row_Recordset4['Diagnostico']."</td>";
      $shtml = $shtml."<td>".$row_Recordset4['descripcion']."</td>";
      $shtml = $shtml."<td>".$row_Recordset4['DescripUbic']."</td>";
      $shtml = $shtml."<td>".$row_Recordset5['Nombre']."</td>";
      $shtml = $shtml."</tr>";
  } while ($row_Recordset4 = mysql_fetch_assoc($Recordset4));
  $shtml = $shtml."</table>";
  //VALORES Y FUNCIONES REQUERIDOA A LA HORA DE EXPORTAR
  $scarpeta="/opt/lampp/htdocs/sicmec/Reportes"; //carpeta donde guardar el archivo.
  $sfile = $scarpeta."/Historial".$_SESSION["NomUsu"].".xls"; //ruta del archivo a generar
  $archivo = "http://Guanajuato.inea.gob.mx/sicmec/Reportes/Historial".$_SESSION["NomUsu"].".xls";
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
  <script language="javascript">
       alert('El Reporte no contiene ningun valor.');
  </script>
  <?
}
?>
