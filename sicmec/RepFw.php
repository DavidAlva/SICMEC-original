<?php
 // SE REALIZA LA CONEXION CON LA BASE DE DATOS
 require_once('Connections/SICMEC.php'); 
 include ("seguridad.php");
 session_start(); 
if ($_SESSION["CveGrupo"] != 2) { 
    header("Location: Index.html"); 
    exit(); }
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<HEAD>
	<TITLE>Reporte de firewall instalado</TITLE>
	<link rel="StyleSheet" type="text/css" media="screen,projection" href="../css/sicmec.css" />
	<link rel="StyleSheet" type="text/css" media="screen,projection" href="../css/sicmectext.css" />
</HEAD>
<div>
<div class="page-container">
	<div class="header">
		<h1>Reporte de la instalaci&oacute;n del Firewall</h1>
	</div>

<?php
	mysql_select_db($database_SICMEC, $SICMEC);
	// Obtener el nombre de la Plaza
	$nompza = mysql_query("SELECT Descripcion FROM adscripcion WHERE CveAdscrip = '" . $_SESSION["pzaid"] . "'",$SICMEC);
	$var = mysql_fetch_array($nompza);
?>
<div class="main-content">
	<h2>Plaza <B><?php echo $_SESSION["pzaid"] . " " . $var["Descripcion"]; ?></B></h2>
	<h2>FireWall <B><?php echo $_SESSION["serieFw"]; ?></B></h2>
	<h2>Ip Lan 1 <B><?php echo $_SESSION['iplan1'] . " </B> Mascara <B>" . $_SESSION['mask1'] . "</B> Gateway <B>" . $_SESSION['gat1'] . "</B> " ; ?></B></h2>
	<h2>Ip Lan 2 <B><?php echo $_SESSION['iplan2'] . "</B> Mascara <B>" . $_SESSION['mask2'] . "</B> Gateway <B>" . $_SESSION['gat2'] . "</B>" ; ?></B></h2>

	<table>
		<tr><th class="top" scope="col">No. Inventario</th><th class="top" scope="col">Ip</th></tr>
            <tr><th scope="row">Conmutador</th><td>500</td></tr>
		
		<?php
			$query = "SELECT NumInv, CveCatalogo, AnnoAlta, Ip FROM ip WHERE CveFw = '" . $_SESSION['serieFw'] . "'";
			$result = mysql_query($query,$SICMEC);
			if($result){
				while($var = mysql_fetch_array($result)){
					echo "<tr><th scope=\"row\">" . $var['CveCatalogo'] . "-" . $var['NumInv'] . "-". $var['AnnoAlta'] . "</th><td>" . $var['Ip'] . "</td></tr>";
				}//while
			}//if result
		?>
	
	</table>
	
</div>
</div>
</BODY>
</html>