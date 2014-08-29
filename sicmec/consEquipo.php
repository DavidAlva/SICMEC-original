<?php
 // SE REALIZA LA CONEXION CON LA BASE DE DATOS
 require_once('Connections/SICMEC.php'); 
 include ("seguridad.php");
 session_start(); 
if ($_SESSION["CveGrupo"] != 2) { 
    header("Location: Index.html"); 
    exit(); }

//consulta todos los empleados
mysql_select_db($database_SICMEC, $SICMEC);
$query = "SELECT NumInv, CveCatalogo, AnnoAlta FROM actfijo WHERE CveAdscrip = '" .$_REQUEST['plazaid'] ."' AND (CveCatalogo = 'I180000064' OR CveCatalogo = 'I180000096' OR CveCatalogo = 'I180000116' OR CveCatalogo = 'I180000156' OR CveCatalogo = 'I180000072' OR CveCatalogo = 'I180000012')";
$sql=mysql_query($query,$SICMEC);

//muestra los datos consultados
if($sql){
//Quitar el ultimo numero a la ip
		$ip = $_REQUEST['ip1val'];
		// funcion para separar en una array cada vez que se encuentre un punto
		$ips = explode(".",$ip);
		echo "<table><tr><td><h2>No. Inventario</h2></td><td><h2>Ip</h2></td></tr>";
while($var = mysql_fetch_array($sql)){
			echo "<tr><td>" . $var['CveCatalogo'] . "-" . $var['NumInv'] . "-". $var['AnnoAlta'] . "<td><input name=\"" . $var['CveCatalogo'] . "-" . $var['NumInv'] . "-" . $var['AnnoAlta'] . "\" type=\"text\" value=\"" . $ips[0] . '.' . $ips[1] . '.' . $ips[2] . '.' .  "\"/></td></tr>";
		}//while
		echo "</table>";
		echo "<p align=\"center\"><input name=\"submit\" type=\"submit\" value=\"Registrar\"> <input name=\"Limpiar\" type=\"reset\" value=\"Limpiar\"></p>";
}
?>