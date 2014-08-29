<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="sp">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<link rel="StyleSheet" type="text/css" media="screen,projection" href="css/present.css"  />
<link rel="StyleSheet" type="text/css" media="screen,projection" href="css/text.css"  />
<link rel="StyleSheet" type="text/css" media="screen,projection" href="css/formularios.css"  />
<title>Recuperar Password</title>
</head>
<body>
<div id="header">
	<!-- A.2 ENCABEZADO MEDIO -->
	<div id="header-middle">
  	<h1>SICMEC</h1>
  	<h2>SISTEMA DE CONTROL Y MANTENIMIENTO DE EQUIPO DE COMPUTO</h2>
	</div>
</div>
	<!-- FIN DE ENCABEZADO -->
<div class="page-container">
	<!--Navegacion de la pagina-->
	<div class="header-breadcrumbs">
		<ul>
			<li><a href="index.php">Inicio</a></li>
			<li><a href="#">Recuperar Password</a></li>
		</ul>
	</div>
	<!--Principal-->
	<div class="main">
		<div class="main-navigation">
			<div class="loginform">
				<form id="form3" name="form3" method="post" action="php/verificaUser.php">
    				<fieldset>
						<?php
							//Destruir la Sesion en caso de que no se haya logeado correctamente
							if(isset($_SESSION['Validar']) && $_SESSION['Validar'] != "OK"){
								session_destroy();
						?>
      			<p id="MensajeError" class="error">El usuario o password son incorrectos</p>
						<?php } ?>
        		<p><label for="NomUsu" class="top">Usuario:</label><br />
        		<input name="NomUsu" type="text" class="field" id="NomUsu" onChange="javascript: this.value=this.value.toUpperCase();" value="" size="15" maxlength="15"/></p>
    	  		<p><label for="Password" class="top">Password:</label><br />
        		<input name="Password" type="password" class="field" id="Password" onChange="javascript: this.value=this.value.toUpperCase();" value="" size="15" maxlength="15"/></p>
        		<input type="hidden" name="paginaReg" id="paginaReg" value="../RecPass.php">
    	  		<p><input type="submit" name="butReg" class="button" value="Entrar"  /></p>
  	   			</fieldset>
    			</form>
			</div>
		</div>
		<div class="main-content" style="width:650px;">
			<h1 class="pagetitle">Recuperar Password</h1>
			<div class="column1-unit" style="width:650px;">
				<p class="center">Introduzca su nombre de Usuario y un nuevo password ser&aacute; enviado a su correo electr&oacute;nico.</p>
				<p class="center">Su correo del nuevo password puede estar en la carpeta de CORREO NO DESEADO</p>
				<p class="center"><a href="index.php">Volver a la p&aacute;gina principal</a></p>
				<form class="formulario" style="width:440px" action="php/RecuPxx.php" method="POST">
				<?php
					if(isset($_REQUEST['message']) && $_REQUEST['message'] == true){
				?>
          <p class="<?php echo $_REQUEST['clase']; ?>"><?php echo $_REQUEST['texto']; ?></p>
				<?php }?>
					<p>
						<label for="User" class="left">Usuario:</label>
						<input class="field" type="text" name="User" id="User">
					</p>
					<input type="hidden" name="pagina" id="pagina" value="../RecPass.php">
					<input class="button" type="submit" value="Enviar">
				</form>
				<br />
				<p class="center">En caso de que usted tenga problemas al recibir su password por favor contacte con el administrador o envienos un correo a <a href="mailto:gto1@inea.gob.mx">gto1&#064;inea.gob.mx</a></p>
			</div>
		</div>
	</div>
	<!-- PIE DE PAGINA -->
	<div id="footer">
      <p>Copyright  2007 INEA Delegaci&oacute;n Guanajuato | Todos los Derechos Reservados</p>
			<p>Blvd. Adolfo L&oacute;pez Mateos #913 poniente. | Celaya Guanajuato | Tel. 01-800-502-0121</p>
			<p class="credits">Dise&ntilde;ado por <a href="" title="">Departamento Inform&aacute;tica</a> | Powered by <a href="#" title="LINUX">Linux</a> | <img src="imagenes/icon-css.gif" /> <img src="imagenes/icon-xhtml.gif" /></p>
  </div>
</div>
</body>
</html>