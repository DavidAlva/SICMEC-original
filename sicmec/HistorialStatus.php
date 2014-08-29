<?php
session_start();
if ($_SESSION["CveGrupo"] != 2) {
    header("Location: index.php");
    exit(); }
require_once('Connections/SICMEC.php');
mysql_select_db($database_SICMEC, $SICMEC);
$query_Recordset8 = "SELECT MAX(CveHist) AS 'Total' FROM historialstatus";
$Recordset8 = mysql_query($query_Recordset8, $SICMEC) or die(mysql_error());
$row_Recordset8 = mysql_fetch_assoc($Recordset8);
$totalRows_Recordset8 = mysql_num_rows($Recordset8);
$Ultimo = $row_Recordset8['Total'] + 1;

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
/*
$query_Recordset7 = sprintf("SELECT * FROM actfijo WHERE( NumInv = %s AND CveCatalogo = '%s' AND AnnoAlta = %s ) AND (NumSerie = '%s')",$NumInv, $CveCatalogo, $AnnoAlta, $NumSerie);
$Recordset7 = mysql_query($query_Recordset7, $SICMEC) or die(mysql_error());
$row_Recordset7 = mysql_fetch_assoc($Recordset7);
$totalRows_Recordset7 = mysql_num_rows($Recordset7);

if ($totalRows_Recordset7 > 0)
{*/
	$query_Recordset6 = sprintf("SELECT * FROM actfijo a JOIN historialstatus h ON a.CveHist = h.CveHist WHERE a.NumInv = %s AND a.CveCatalogo = '%s' AND a.AnnoAlta = %s AND a.NumSerie ='%s' AND a.CveStatus = %s AND a.CveUbic = %s AND h.Diagnostico = '%s'",$NumInv, $CveCatalogo, $AnnoAlta, $NumSerie, $CveStatus, $CveUbic, $Diagnostico);
	$Recordset6 = mysql_query($query_Recordset6, $SICMEC) or die(mysql_error());
	$row_Recordset6 = mysql_fetch_assoc($Recordset6);
	$totalRows_Recordset6 = mysql_num_rows($Recordset6);
	if ($totalRows_Recordset6 <= 0)
		{
		 $insertSQL = "INSERT INTO historialstatus (NumInv, CveCatalogo, AnnoAlta, NumSerie, CveStatus, FecHist, CveUbic, Diagnostico, TecnicoINEA, CveRep, Problema) VALUES ('$NumInv', '$CveCatalogo', '$AnnoAlta', '$NumSerie', '$CveStatus', '$FecHist', '$CveUbic', '$Diagnostico', '$TecnicoINEA', '$CveRep', '$Problema')";
		 $insertSQL1 = "UPDATE actfijo SET CveHist = '$Ultimo', CveStatus = '$CveStatus', CveUbic = '$CveUbic' WHERE (NumInv = '$NumInv' AND CveCatalogo = '$CveCatalogo' AND AnnoAlta = '$AnnoAlta') AND NumSerie = '$NumSerie'";
		 mysql_select_db($database_SICMEC, $SICMEC);
		 $Result1 = mysql_query($insertSQL, $SICMEC) or die(mysql_error());
		 $Result2 = mysql_query($insertSQL1, $SICMEC) or die(mysql_error());
		 if ($Result1 > 0 AND $Result2 > 0)
		    {?> <script language="javascript"> alert('El registro ha sido insertado con exito.'); </script> <?php  }
		 else
		    {?> <script language="javascript"> alert('Error al intentar almacenar el registro en la Base de Datos.'); </script> <?php }       	}
	else
	 {?> <script language="javascript"> alert('Este equipo ya fue registrado con estos valores.'); </script> <?php }
	mysql_free_result($Recordset6);
//	mysql_free_result($Recordset7);
	mysql_free_result($Recordset8);

/*}
else
 {?> <script language="javascript"> alert('Este equipo no no se encuentra registrado en la Base de Datos.'); </script> <?php }
*/?>
<script language="javascript"> location.href="ListaHistorial.php" </script>