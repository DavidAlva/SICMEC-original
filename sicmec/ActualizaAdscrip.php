<?php
session_start();
//Validacion de Usuario
if($_SESSION['Validar'] != "OK" or $_SESSION["CveGrupo"] == 3 ){
		header("Location: index.php");
		exit();
}
require_once('Connections/SICMEC.php');

/*CODIGO GENERADO POR  DREAMWEAVER PARA QUE LA PAGINA SE LLAME A SI MISMA AL MOMENTO DEL SUBMIT*/
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
mysql_select_db($database_SICMEC, $SICMEC);
/*QUERY QUE ACTUALIZA EL REGISTRO CON LOS VALORES ENVIADOS EN EL SUBMIT*/
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE adscripcion SET Descripcion='%s', Responsable='%s', Domicilio='%s', Colonia='%s', Poblacion='%s', CodPostal='%s', Telefono='%s', Email='%s', Horario='%s', Red='%s', IP='%s', Mask='%s' WHERE CveAdscrip='%s'",$_POST['Descripcion'],$_POST['Responsable'],$_POST['Domicilio'],$_POST['Colonia'],$_POST['Poblacion'],$_POST['CodPostal'],$_POST['telefono'],$_POST['Email'],$_POST['Horario'],$_POST['Red'],$_POST['IP'],$_POST['Mask'],$_POST['CveAdscrip']);
  mysql_select_db($database_SICMEC, $SICMEC);

/*MENSAJE DE ERROR O DE EXITO EN LA QUERY*/
  $Result1 = mysql_query($updateSQL, $SICMEC) or die(mysql_error());
  if ($Result1 > 0)
  {?> <script language="javascript"> alert('El registro ha sido inserado con exito.'); </script> <?php }
  else
  {  ?> <script language="javascript"> alert('Error al intentar almacenar el registro en la Base de Datos.'); </script> <?php }
}

/*QUERY QUE BUSCA LA ADSCRIPCION DE ACUERDO A LOS FILTROS*/
$colname_Recordset1 = "-1";
if (isset($_POST['CveAdscrip'])) {
  $colname_Recordset1 = (get_magic_quotes_gpc()) ? $_POST['CveAdscrip'] : addslashes($_POST['CveAdscrip']);
}
$query_Recordset1 = sprintf("SELECT * FROM adscripcion WHERE CveAdscrip = '%s'", $colname_Recordset1);
$Recordset1 = mysql_query($query_Recordset1, $SICMEC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

/*QUERY QUE MUESTRA LOS VALORES DEL MENU DE ADSCRIPCION */
$query_Recordset2 = "SELECT CveAdscrip, Descripcion FROM adscripcion ORDER BY Descripcion ASC";
$Recordset2 = mysql_query($query_Recordset2, $SICMEC) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="sp">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<link rel="StyleSheet" type="text/css" media="screen,projection" href="css/present.css"  />
<link rel="StyleSheet" type="text/css" media="screen,projection" href="css/text.css"  />
<link rel="StyleSheet" type="text/css" media="screen,projection" href="css/formularios.css"  />
<title>Actualizar Datos de Plazas</title>
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
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' Debe contener una direcci� de e-mail.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' Debe contener un nmero.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' Debe contener nmeros entre '+min+' y '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' Es requerido.\n'; }
  } if (errors) alert('Los siguientes errores han ocurido:\n'+errors);
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
			<li><a href="#">Actualiza Datos de Plazas</a></li>
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
			<h1 class="pagetitle">Actualiza Datos de Plazas Comunitarias y Coordinaciones de Zona</h1>
			<div class="column1-unit">

			  <form id="form1" name="form1" method="post" action="" class="formulario" style="width:440px;">
    			<label for="CveAdscrip" class="left">No. Plaza:</label>
            <select class="combo" name="CveAdscrip" id="CveAdscrip" style="width:350px" title="<?php echo $_POST['CveAdscrip']; ?>">
              <option value=""></option>
              <?php
						do {
							?>
              <option value="<?php echo $row_Recordset2['CveAdscrip']?>"><?php echo $row_Recordset2['Descripcion'] ." - ".$row_Recordset2['CveAdscrip']?></option>
              <?php
								} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  							$rows = mysql_num_rows($Recordset2);
  							if($rows > 0) {
      						mysql_data_seek($Recordset2, 0);
	  							$row_Recordset2 = mysql_fetch_assoc($Recordset2);
  							}
							?>
            </select>
          	<input class="button" name="Buscar" type="submit" id="Buscar" value="Buscar" />
	  		</form>

  			<form class="formulario" style="width:600px;" id="form2" name="form2" method="POST" action="<?php echo $editFormAction; ?>" onSubmit="MM_validateForm('Descripcion','','R','Poblacion','','R','CodPostal','','NisNum','Email','','NisEmail');return document.MM_returnValue">
        <input name="CveAdscrip" type="hidden" id="CveAdscrip" value="<?php echo $row_Recordset1['CveAdscrip']; ?>" size="11" maxlength="11" />
        <p>
        <label for="Descripcion" class="leftW">Descripci&oacute;n:</label>
        <input class="field" name="Descripcion" type="text" id="Descripcion" value="<?php echo $row_Recordset1['Descripcion']; ?>" size="70" maxlength="70" onChange="javascript: this.value=this.value.toUpperCase();"/>
        </p>
        <p>
        <label for="Responsable" class="leftW">Responsable:</label>
        <input class="field" name="Responsable" type="text" id="Responsable" value="<?php echo $row_Recordset1['Responsable']; ?>" size="50" maxlength="50" onChange="javascript: this.value=this.value.toUpperCase();"/>
        </p>
        <p>
        <label for="Domicilio" class="leftW">Domicilio:</label>
        <input class="field" name="Domicilio" type="text" id="Domicilio" value="<?php echo $row_Recordset1['Domicilio']; ?>" size="50" maxlength="50" onChange="javascript: this.value=this.value.toUpperCase();"/>
        </p>
        <p>
        <label for="Colonia" class="leftW">Colonia:</label>
        <input class="field" name="Colonia" type="text" id="Colonia" value="<?php echo $row_Recordset1['Colonia']; ?>" size="20" maxlength="20" onChange="javascript: this.value=this.value.toUpperCase();"/>
        </p>
        <p>
        <label for="Poblacion" class="leftW">Poblaci&oacute;n:</label>
        <input class="field" name="Poblacion" type="text" id="Poblacion" value="<?php echo $row_Recordset1['Poblacion']; ?>" size="20" maxlength="20" onChange="javascript: this.value=this.value.toUpperCase();"/>
        </p>
        <p>
        <label for="CodPostal" class="leftW">C.P.:</label>
        <input class="field" name="CodPostal" type="text" id="CodPostal" value="<?php echo $row_Recordset1['CodPostal']; ?>" size="5" maxlength="5" />
        </p>
        <p>
        <label for="telefono" class="leftW">Tel&eacute;fono:</label>
        <input class="field" name="telefono" type="text" id="telefono" value="<?php echo $row_Recordset1['Telefono']; ?>" size="20" maxlength="20" />
        </p>
        <p>
        <label for="Email" class="leftW">e-Mail:</label>
        <input class="field" name="Email" type="text" id="Email" value="<?php echo $row_Recordset1['Email']; ?>" size="30" maxlength="30" />
        </p>
        <p>
        <label for="Horario" class="leftW">Horario:</label>
        <input class="field" name="Horario" type="text" id="Horario" value="<?php echo $row_Recordset1['Horario']; ?>" size="20" maxlength="20" />
        </p>
        <p>
        <label for="Red" class="leftW">Red:</label>
        <input class="field" name="Red" type="text" id="Red" value="<?php echo $row_Recordset1['Red']; ?>" size="10" maxlength="10" />
        </p>
        <p>
        <label for="IP" class="leftW">IP&acute;s:</label>
        <input class="field" name="IP" type="text" id="IP" value="<?php echo $row_Recordset1['IP']; ?>" size="15" maxlength="15" />
        </p>
        <p>
        <label for="Mask" class="leftW">M&aacute;scara:</label>
        <input class="field" name="Mask" type="text" id="Mask" value="<?php echo $row_Recordset1['Mask']; ?>" size="15" maxlength="15" />
        </p>
        <input class="button" name="Actualizar" type="submit" id="Actualizar" value="Actualizar" />
    <input type="hidden" name="MM_update" value="form2">
  </form>
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
<!-- SE LIBERAN LOS RESULTADOS DE LAS QUERYS-->
<?php
mysql_free_result($Recordset1);
mysql_free_result($Recordset2);
?>
