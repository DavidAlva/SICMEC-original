<? session_start();
if($_SESSION['Validar'] != "OK" or $_SESSION["CveGrupo"] != 2){
		header("Location: index.php");
		exit();
	}
require_once('Connections/SICMEC.php');
mysql_select_db($database_SICMEC, $SICMEC);
$query_Recordset1 = sprintf("SELECT sp.CveServicio, sp.Titulo, sp.Descrip, sp.Observaciones, p.Nombre, a.Descripcion, sp.FecServ, sp.Encargado, pt.descripcion, sp.CveRep FROM servicioplaza sp join personal p on  sp.TecnicoINEA = p.NomUsu JOIN adscripcion a on sp.CveAdscrip = a.CveAdscrip JOIN puesto pt ON pt.CvePuesto = sp.CvePuesto WHERE sp.CveServicio = %s ", $_REQUEST['CveServicio']);
$Recordset1 = mysql_query($query_Recordset1, $SICMEC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; encoding="utf-8" />
<title>Reporte se Servicio Tecnico</title>
<style type="text/css">
<!--
#Layer1 {
	position:absolute;
	left:490px;
	top:176px;
	width:181px;
	height:20px;
	z-index:1;
}
#Layer2 {
	position:absolute;
	left:46px;
	top:343px;
	width:624px;
	height:110px;
	z-index:2;
}
#Layer3 {
	position:absolute;
	left:49px;
	top:217px;
	width:623px;
	height:22px;
	z-index:3;
}
#Layer4 {
	position:absolute;
	left:365px;
	top:802px;
	width:266px;
	height:18px;
	z-index:4;
}
#Layer5 {
	position:absolute;
	left:47px;
	top:803px;
	width:277px;
	height:21px;
	z-index:5;
}
#Layer6 {
	position:absolute;
	left:96px;
	top:876px;
	width:282px;
	height:24px;
	z-index:6;
}
#Layer7 {
	position:absolute;
	left:48px;
	top:677px;
	width:626px;
	height:64px;
	z-index:7;
}
#Layer8 {
	position:absolute;
	left:280px;
	top:130px;
	width:87px;
	height:21px;
	z-index:8;
}
#Layer9 {
	position:absolute;
	left:47px;
	top:257px;
	width:627px;
	height:59px;
	z-index:9;
}
.Estilo1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
}
.Estilo2 {font-size: 10px}
.Estilo3 {font-family: Arial, Helvetica, sans-serif}
.Estilo4 {
	color: #CCCCCC;
	font-size: 16px;
	font-weight: bold;
}
#Layer10 {
	position:absolute;
	left:313px;
	top:903px;
	width:214px;
	height:50px;
	z-index:10;
}
#Layer11 {
	position:absolute;
	left:25px;
	top:464px;
	width:197px;
	height:16px;
	z-index:11;
}
.Estilo7 {font-size: 12px}
.Estilo8 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
-->
</style></head>

<body>
<div class="Estilo1" id="Layer1"><span class="Estilo7"><strong>Fecha:</strong> <?php echo $row_Recordset1['FecServ']; ?></span></div>
<div class="Estilo1" id="Layer2">
  <div align="left" class="Estilo7">
    <p><strong>Servicio Realizado en sitio:</strong></p>
    <p><?php echo $row_Recordset1['Descrip']; ?></p>
  </div>
</div>
<div class="Estilo1" id="Layer3">
  <div align="left" class="Estilo7"><strong>Sitio de Servicio:</strong> <?php echo $row_Recordset1['Descripcion']; ?></div>
</div>
<div class="Estilo1" id="Layer4">
  <div align="left" class="Estilo7">
    <p align="center"><?php echo $row_Recordset1['Nombre']; ?></p>
    <p align="center"><strong>T&eacute;cnico INEA</strong></p>
  </div>
</div>
<div class="Estilo1" id="Layer5">
  <div align="left" class="Estilo7">
    <p align="center"><?php echo $row_Recordset1['Encargado']; ?></p>
    <p align="center"><strong>Recibe servicio en sitio</strong></p>
  </div>
</div>
<div class="Estilo1" id="Layer6">
  <div align="left" class="Estilo7"><strong>Puesto:	</strong> <?php echo $row_Recordset1['descripcion']; ?></div>
</div>
<div class="Estilo1" id="Layer7">
  <div align="left" class="Estilo7">
    <p><strong>Observaciones:</strong></p>
    <p> <?php echo $row_Recordset1['Observaciones']; ?></p>
  </div>
</div>
<div class="Estilo1" id="Layer8">
  <div align="left" class="Estilo4"><?php echo $row_Recordset1['CveRep']; ?></div>
</div>
<div class="Estilo1" id="Layer9">
  <div align="left" class="Estilo7">
    <p><strong>Reporte realizado al centro de soporte: </strong></p>
    <p><?php echo $row_Recordset1['Titulo']; ?></p>
  </div>
</div>

<div class="Estilo8" id="Layer11"><strong>Equipo Da&ntilde;ado o en mal estado</strong>: </div>
<div align="left" class="Estilo2"><span class="Estilo3">
  <script> 
function window.onbeforeprint(){ 
noprint.style.visibility = 'hidden'; 
noprint.style.position = 'absolute';
}
function window.onafterprint(){ 
noprint.style.visibility = 'visible'; 
noprint.style.position = 'relative'; 
}
  </script>
  </span>
  <img src="servicioCompleto.gif" />
 <div id="Layer10">
 <table>
    <td class="Estilo3" id="noprint">
      <tr><input type="button" name="imprimir" value="imprimir" onclick="window.print();"/></tr>
    <td class="Estilo3"></td>
  </table></div>
  

</div>
</body>
</html>
