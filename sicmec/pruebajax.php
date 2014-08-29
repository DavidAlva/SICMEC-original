<?php
 // SE REALIZA LA CONEXION CON LA BASE DE DATOS
 require_once('Conexion/SICMEC.php'); 
 $con = new MySqlConnection("sicmec","root","$4bi4n");
 $con->Open();
 //require_once('Connections/SICMEC.php'); 
 /*include ("seguridad.php");
 session_start(); 
if ($_SESSION["CveGrupo"] != 2) { 
    header("Location: Index.html"); 
    exit(); }*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Consulta Registro con AJAX</title>

<!-- referenciamos al archivo ajax.js donde se encuentra nuestra funcion objetoAjax-->
<script language="JavaScript" type="text/javascript" src="ajax.js"></script>
<script language="JavaScript" type="text/javascript">
<!-- //Ocultar
function cargaNoPlaza(){
	document.Regfw.pzaid.value=document.Regfw.nompza[document.Regfw.nompza.selectedIndex].value ;
	MostrarConsulta('consulta.php');
}
-->
</script>
</head>
<body>
<p>Consultar registros con ajax</p>

<!-- En "onsubmit" escribimos la funci� 'MostrarConsulta' que creamos en javascript, con su parametro que es el archivo que vamos a mostrar, en este caso 'consulta.php'-->
<form name="Regfw" method="POST"  action="req.php">
<H2>Datos Plaza</H2>
<p>Numero Plaza <input  name="pzaid" id="nopza" type="text">
Plaza <select  name="nompza" id="nompza" type="text" onchange="cargaNoPlaza()">
<OPTION value="">Selecciona una Plaza</OPTION>
<?php 
	//mysql_select_db($database_SICMEC, $SICMEC);
	$result = mysql_query("SELECT CveAdscrip, Descripcion FROM adscripcion ORDER BY Descripcion ASC",$con->idConecction());
	if($result){
		//$nums = mysql_num_rows($result);
	//for($i=1; $i<=$nums ; $i++){
	while($var = mysql_fetch_array($result)){
			//$var = mysql_fetch_array($result);
			/*value="loadBox.php?cveAd=<?php echo $var['CveAdscrip']; ?>&pagina=RegFw.php"*/
			
			echo "<option value=" . $var['CveAdscrip'] . ">" . $var["Descripcion"] . "</option>";
		} //cierre while
	}; //cierre if 
?>
    </select>
    Serie fw Nokia <input name="serieFw" id="serieFw" type="text" maxlength="11"></p>
<h2>LAN 1</h2>
<p>IP <input name="iplan1" id="iplan1" type="text" maxlength="15"> Mascara <input name="mask1" id="mask1" type="text" maxlength="15"> Gateway <input name="gat1" id="gat1" type="text" maxlength="15"></p>
<h2>LAN 2</h2>
<p>IP <input name="iplan2" id="iplan2" type="text" maxlength="15"> Mascara <input name="mask2" id="mask2" type="text" maxlength="15"> Gateway <input name="gat2" id="gat2" type="text" maxlength="15"></p>
<H2>Configuracion Ips</H2>
<p>Rango Ip de <input name="dirIp1" id="ip1valida" type="text" maxlength="15"> al <input name="dirIp2" id="dirIp2" type="text" maxlength="15"></p>
<div id="resultado"></div>
</form>
</body>
</html>
