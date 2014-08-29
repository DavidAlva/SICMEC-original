<?php
session_start();
if($_SESSION['Validar'] != "OK")
		header("Location: index.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="sp">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="StyleSheet" type="text/css" media="screen,projection" href="css/present.css"  />
<link rel="StyleSheet" type="text/css" media="screen,projection" href="css/text.css"  />
<link rel="StyleSheet" type="text/css" media="screen,projection" href="css/formularios.css"  />
<title>Cambiar Password</title>
<script type="text/javascript" language="JavaScript" src="js/ajax.js"></script>
</head>
<div>
<div id="header">
	<!-- A.2 ENCABEZADO MEDIO -->
	<div id="header-middle">
  	<h1>SICMEC</h1>
  	<h2>SISTEMA DE CONTROL Y MANTENIMIENTO DE EQUIPO DE COMPUTO</h2>
	</div>
		 <!-- A.3 ENCABEZADO INFERIOR -->
      <div id="header-bottom">
			<?php
		//INSERTAR MENUS DE ACUERDO AL TIPO DE USUARIO
				require_once('php/Menus.class.php');
				$menu = new Menus($_SESSION["CveGrupo"]);
				$menu->Mostrar();
			?>
	  </div>
	</div>
	<!-- FIN DE ENCABEZADO -->
<div class="page-container">
	<div class="header-breadcrumbs">
		<ul>
			<li><a href="intro.php">Inicio</a></li>
			<li><a href="#">Cambiar Password</a></li>
		</ul>
		<!-- Cerrar Sesion -->
		<div class="boton">
        	<form class="form" name="close_session" action="php/close_session.php">
        		<input type="hidden" name="paginair" value="../index.php" />
        		<input type="submit" class="button" value="Cerrar Sesi&oacute;n" />
        	</form>
        </div>
	</div>
	<div class="main">
		<div class="main-content">
			<h1 class="pagetitle">Cambiar Password</h1>
			<div class="column1-unit">
				<h2>Recuerde que una vez que cambie su password este ser&aacute; v&aacute;lido a partir de la siguiente ocasi&oacute;n que inicie sesi&oacute;n.</h2>
				<form class="formulario" style="width:600px" action="" method="POST">
				<div id="MessOK" ></div>
					<fieldset>
						<legend>Datos Actuales</legend>
						<p>
							<label for="Pass" class="leftW">Password:</label>
							<input class="field" type="password" name="Pass" id="Pass" onblur="ConsulPass('php/VerificaPass.php','PasInc','Pass')">
						</p>
						<div id="PasInc"></div>
					</fieldset>
					<fieldset>
						<legend>Datos Nuevos</legend>
						<p>
							<label for="PassNew" class="leftW">Password:</label>
							<input class="field" type="password" name="PassNew" id="PassNew">
						</p>
						<p>
							<label for="PassNewC" class="leftW">Confirmar Password:</label>
							<input class="field" type="password" name="PassNewC" id="PassNewC" onblur="VerificaPass('PassNew','PassNewC','PasNI')">
						</p>
						<div id="PasNI"></div>
					</fieldset>
					<input class="button" type="button" value="Cambiar" onclick="CambiaPass('php/ChngPwd.php','MessOK','PasNI','Pass','PassNew','PassNewC')">
				</form>
			</div>
		</div>
	</div>
	<!-- PIE DE PAGINA -->
	<div id="footer">
      <p>Copyright  2007 INEA Delegaci&oacute;n Guanajuato | Todos los Derechos Reservados</p>
			<p>Blvd. Adolfo L&oacute;pez Mateos #913 poniente. | Celaya Guanajuato | Tel. 01-800-502-0121</p>
			<p class="credits">Dise&ntilde;ado por <a href="" title="">Departamento Inform&aacute;tica</a> | Powered by <a href="#" title="LINUX">Linux</a> | <img src="../imagenes/icon-css.gif" /> <img src="../imagenes/icon-xhtml.gif" /></p>
    </div>
</div>
</body>
</html>