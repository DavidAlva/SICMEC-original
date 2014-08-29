<?php
session_start();
if ($_SESSION["CveGrupo"] != 2) {
    header("Location: index.php");
    exit(); }
require_once('Connections/SICMEC.php');
mysql_select_db($database_SICMEC, $SICMEC);

$CveHist = $_REQUEST['CveHist'];
$NumInv = $_REQUEST['NumInv'];
$CveCatalogo = $_REQUEST['CveCatalogo'];
$AnnoAlta = $_REQUEST['AnnoAlta'];
$NumSerie =$_REQUEST['NumSerie'];
$CveStatus = $_REQUEST['CveStatus'];
$FecHist  = $_REQUEST['FecHist'];
$CveUbic = $_REQUEST['CveUbic'];
$Diagnostico = $_REQUEST['Diagnostico'];
$Problema = $_REQUEST['Problema'];
$TecnicoINEA = $_REQUEST['TecnicoINEA'];
$CveRep = $_REQUEST['CveRep'];

$updateSQL = "UPDATE historialstatus SET NumInv=$NumInv, CveCatalogo='$CveCatalogo', AnnoAlta=$AnnoAlta, NumSerie='$NumSerie', CveStatus=$CveStatus, FecHist='$FecHist',CveUbic=$CveUbic, Diagnostico='$Diagnostico', Problema='$Problema', TecnicoINEA='$TecnicoINEA' WHERE CveHist=$CveHist";

mysql_select_db($database_SICMEC, $SICMEC);
$Result1 = mysql_query($updateSQL, $SICMEC) or die(mysql_error());
if ($Result1 > 0)
	{?> <script language="javascript"> alert('El registro ha sido insertado con exito.'); </script> <?php  }
else
	{?> <script language="javascript"> alert('Error al intentar almacenar el registro en la Base de Datos.'); </script> <?php }
?>
<script language="javascript"> location.href="ListaHistorialEquipo.php" </script>