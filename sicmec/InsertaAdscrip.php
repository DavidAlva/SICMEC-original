<?php
session_start();
//Validacion de Usuario
if($_SESSION['Validar'] != "OK" or $_SESSION["CveGrupo"] != 2){
		header("Location: index.php");
		exit();
	}
require_once('Connections/SICMEC.php');
mysql_select_db($database_SICMEC, $SICMEC);
/*CODIGO GENERADO POR  DREAMWEAVER PARA QUE LA PAGINA SE LLAME A SI MISMA AL MOMENTO DEL SUBMIT*/
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

/*QUERY QUE INSERTA EL REGISTRO CON LOS VALORES ENVIADOS EN EL SUBMIT*/
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO adscripcion (CveAdscrip, Descripcion, Responsable, Domicilio, Colonia, Poblacion, CodPostal, Telefono, Email, Horario, Red, IP, Mask) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",$_POST['CveAdscrip'],$_POST['Descripcion'],$_POST['Responsable'],$_POST['Domicilio'],$_POST['Colonia'],$_POST['Poblacion'],$_POST['CodPostal'],$_POST['telefono'],$_POST['Email'],$_POST['Horario'],$_POST['Red'],$_POST['IP'],$_POST['Mask']);
  mysql_select_db($database_SICMEC, $SICMEC);
  $Result1 = mysql_query($insertSQL, $SICMEC);

/*MENSAJE DE ERROR O DE EXITO EN LA QUERY*/
  if ($Result1 > 0)
  {?> <script language="javascript"> alert('El registro ha sido insertado con exito.'); </script> <?php }
  else
  {  ?> <script language="javascript"> alert('Error al intentar almacenar el registro en la Base de Datos.'); </script> <?php }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="sp">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<link rel="StyleSheet" type="text/css" media="screen,projection" href="css/present.css"  />
<link rel="StyleSheet" type="text/css" media="screen,projection" href="css/text.css"  />
<link rel="StyleSheet" type="text/css" media="screen,projection" href="css/formularios.css"  />
<title>Insertar Datos de Plazas</title>
<script type="text/JavaScript">

<!-- CODIGO GENERADO POR DREAMWEAVER PARA VALIDAR EL FORMATO DEL TIPO DE DATO DE LAS CAJAS DE TEXTO -->
<!--
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' Debe contener una direccion de e-mail.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' Debe contener un nmero.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' Debe contener nmeros entre '+min+' y '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' Es requerido.\n'; }
  } if (errors) alert('Los siguientes errores han ocurrido:\n'+errors);
  document.MM_returnValue = (errors == '');
}
//-->
</script>
</head>
<body>
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
			<li>Datos de Plazas</li>
			<li><a href="#">Inserta Datos de Plazas</a></li>
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
			<h1 class="pagetitle">Inserta Datos de Plazas Comunitarias y Coordinaciones de Zona</h1>
			<div class="column1-unit">

  			<form class="formulario" style="width:600px;" id="form2" name="form2" method="POST" action="<?php echo $editFormAction; ?>" onSubmit="MM_validateForm('CveAdscrip','','R','Descripcion','','R','Poblacion','','R','CodPostal','','NisNum','Email','','NisEmail','Red','','NisNum');return document.MM_returnValue">
    			<p>
    				<label for="CveAdscrip" class="leftW">Clave:</label>
          	<input class="field" name="CveAdscrip" type="Text" id="CveAdscrip" size="11" maxlength="11" onChange="javascript: this.value=this.value.toUpperCase();"/>
          </p>
          <p>
          	<label for="Descripcion" class="leftW">Descripci&oacute;n:</label>
          	<input class="field" name="Descripcion" type="text" id="Descripcion" size="70" maxlength="70" onChange="javascript: this.value=this.value.toUpperCase();"/>
          </p>
          <p>
          	<label for="Responsable" class="leftW">Responsable:</label>
          	<input class="field" name="Responsable" type="text" id="Responsable" size="50" maxlength="50" onChange="javascript: this.value=this.value.toUpperCase();"/>
          </p>
          <p>
          	<label for="Domicilio" class="leftW">Domicilio:</label>
          	<input class="field" name="Domicilio" type="text" id="Domicilio" size="50" maxlength="50" onChange="javascript: this.value=this.value.toUpperCase();"/>
          </p>
          <p>
          	<label for="Colonia" class="leftW">Colonia:</label>
          	<input class="field" name="Colonia" type="text" id="Colonia" size="20" maxlength="20"onchange="javascript: this.value=this.value.toUpperCase();" />
          </p>
          <p>
          	<label for="Poblacion" class="leftW">Poblaci&oacute;n:</label>
          	<input class="field" name="Poblacion" type="text" id="Poblacion" size="20" maxlength="20" onChange="javascript: this.value=this.value.toUpperCase();" />
          </p>
          <p>
          	<label for="CodPostal" class="leftW">C.P.:</label>
          	<input class="field" name="CodPostal" type="text" id="CodPostal" size="5" maxlength="5" />
          </p>
          <p>
          	<label for="telefono" class="leftW">Tel&eacute;fono:</label>
          	<input class="field" name="telefono" type="text" id="telefono" size="20" maxlength="20" />
          </p>
          <p>
          	<label for="Email" class="leftW">e-Mail:</label>
          	<input class="field" name="Email" type="text" id="Email" size="30" maxlength="30" />
          </p>
          <p>
          	<label for="Horario" class="leftW">Horario:</label>
          	<input class="field" name="Horario" type="text" id="Horario" size="20" maxlength="20" />
          </p>
          <p>
          	<label for="Red" class="leftW">Red:</label>
          	<input class="field" name="Red" type="text" id="Red" size="10" maxlength="10" />
          </p>
        	<p>
        		<label for="IP" class="leftW">IP&acute;s:</label>
        		<input name="IP" type="text" id="IP" value="0.0.0.0" size="15" maxlength="15" />
        	</p>
        	<p>
        		<label for="Mask" class="leftW">M&aacute;scara:</label>
        		<input class="field" name="Mask" type="text" id="Mask" value="255.255.255.255" size="15" maxlength="15" />
        	</p>
          <input class="button" name="Insertar" type="submit" id="Insertar" value="Insertar" />

    			<input type="hidden" name="MM_insert" value="form2">
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