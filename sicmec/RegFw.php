<?php
 // SE REALIZA LA CONEXION CON LA BASE DE DATOS
 require_once('Connections/SICMEC.php'); 
 include ("seguridad.php");
 session_start(); 
if ($_SESSION["CveGrupo"] != 2) { 
    header("Location: Index.html"); 
    exit(); }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="StyleSheet" type="text/css" media="screen,projection" href="../css/sicmec.css" />
<link rel="StyleSheet" type="text/css" media="screen,projection" href="../css/sicmectext.css" />
<TITLE>Registro FireWall</TITLE>
<!-- referenciamos al archivo ajax.js donde se encuentra nuestra funcion objetoAjax-->
<script language="JavaScript" type="text/javascript" src="ajax.js"></script>
<script language="JavaScript" type="text/JavaScript">
<!-- //Ocultar javascript
// funcion para cargar el numero de plaza en una caja de texto,
// dependiendo de cual plaza se seleccione del combo
function cargaNoPlaza(){
	document.Regfw.pzaid.value=document.Regfw.nompza[document.Regfw.nompza.selectedIndex].value ;
	//Cargar las computadoras de las plazas a traves de xmlhttprequest
	MostrarConsulta('consEquipo.php');
}
-->
</script>
</head>
<body>
<div class="page-container">
<div class="header">
	<h1>Sistema de Registro de FireWall</h1>
</div>
	<form name="Regfw" method="POST"  action="inFw.php">
	<div class="content-box-red" id="boxerror" >
   		<fieldset class="red">
   		<legend>Error</legend>
   		<p>Error debe de hacer lo sndksfa;ksdf;n djhf  ajdhfaheroad dsf fauf ufahdf d fahdf hahd;f ad fadfhahd</p>
   			<ul><li>hola</li></ul>
   		</fieldset>
  </div>
	<div class="content-box">
		<fieldset>
		<legend>Datos Plaza</legend>
		<label for="nopza">N&uacute;mero Plaza <input  name="pzaid" id="nopza" type="text"></label>
		<label for="nompza">Plaza <select class="combo" name="nompza" id="nompza" type="text"  onchange="cargaNoPlaza()">
				<OPTION value="">Selecciona una Plaza</OPTION>
				<?php 
					mysql_select_db($database_SICMEC, $SICMEC);
					$result = mysql_query("SELECT CveAdscrip, Descripcion FROM adscripcion ORDER BY Descripcion ASC",$SICMEC);
					if($result){
						$nums = mysql_num_rows($result);
					for($i=1; $i<=$nums ; $i++){
						$var = mysql_fetch_array($result);
						/*value="loadBox.php?cveAd=<?php echo $var['CveAdscrip']; ?>&pagina=RegFw.php"*/
				?>
						<option value="<?php echo $var['CveAdscrip']; ?> "><?php echo $var["Descripcion"]; ?> </option>
				<?php } //cierre for
					}; //cierre if ?>
   			</select>
   	</label>
   	</fieldset>
   </div>
   <div class="content-box">
   	<fieldset>
   		<legend>Datos Firewall</legend>
			<label for="serieFw">Serie fw Nokia <input name="serieFw" id="serieFw" type="text" maxlength="11"></label>
			<label class="title">LAN 1</label>
			<label for="iplan1">IP <input name="iplan1" id="iplan1" type="text" maxlength="15" size="15"></label>
			<label for="mask1">Mascara <input name="mask1" id="mask1" type="text" maxlength="15" size="15"></label>
			<label for="gat1">Gateway <input name="gat1" id="gat1" type="text" maxlength="15" size="15"></label>
			<label class="title">LAN 2</label>
			<label for="iplan2">IP <input name="iplan2" id="iplan2" type="text" maxlength="15" size="15"></label>
			<label for="mask2">Mascara <input name="mask2" id="mask2" type="text" maxlength="15" size="15"></label>
			<label for="gat2">Gateway <input name="gat2" id="gat2" type="text" maxlength="15" size="15"></label>
			<label class="title">Configuracion Ips</label>
			<label for="ip1valida">Rango Ip de <input name="dirIp1" id="ip1valida" type="text" maxlength="15" size="15" onblur="cargaNoPlaza()"></label>
			<label for="dirIp2">al <input name="dirIp2" id="dirIp2" type="text" maxlength="15" size="15"></label>
		</fieldset>
	</div>
	<!-- TABLA DE EQUIPOS QUE TIENE LA PLAZA
		UNA VEZ QUE SE SELECCIONA LA PLAZA APARECEN LOS EQUIPOS QUE ESTA TIENE -->
	<div id="resultado"></div>
	<p align="center" style="color:red;"><?php if(isset($_REQUEST["error"])) echo $_REQUEST["error"]; ?></p>
	</form>
</div>
</body>
</html>