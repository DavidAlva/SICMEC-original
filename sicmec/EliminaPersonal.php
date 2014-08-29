<?php
session_start();
//Validacion de Usuario
if($_SESSION['Validar'] != "OK" or $_SESSION["CveGrupo"] != 2){
		header("Location: index.php");
		exit();
	}
require_once('Connections/SICMEC.php');
mysql_select_db($database_SICMEC, $SICMEC);
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_delete"])) && ($_POST["MM_delete"] == "form3")) {
  $deleteSQL = sprintf("DELETE FROM personal WHERE NomUsu = '%s'",$_POST['NomUsu2']);
  $Result = mysql_query($deleteSQL, $SICMEC);
  $deleteSQL = sprintf("DELETE FROM responsable WHERE NomUsu = '%s'",$_POST['NomUsu2']);
  $Result1 = mysql_query($deleteSQL, $SICMEC);
  if (($Result1 > 0) AND ($Result1 > 0))
  {?> <script language="javascript"> alert('El registro ha sido eliminado con exito.'); </script> <?php }
  else
  {  ?> <script language="javascript"> alert('Error al intentar almacenar el registro en la Base de Datos.'); </script> <?php }
}

$query_Recordset1 = "SELECT * FROM puesto ORDER BY Descripcion ASC";
$Recordset1 = mysql_query($query_Recordset1, $SICMEC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$query_Recordset2 = "SELECT * FROM grupo ORDER BY Descripcion ASC";
$Recordset2 = mysql_query($query_Recordset2, $SICMEC) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$query_Recordset3 = "SELECT CveAdscrip, Descripcion FROM adscripcion ORDER BY Descripcion ASC";
$Recordset3 = mysql_query($query_Recordset3, $SICMEC) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$colname_Recordset4 = "-1";
if (isset($_POST['NomUsu'])) {
  $colname_Recordset4 = (get_magic_quotes_gpc()) ? $_POST['NomUsu'] : addslashes($_POST['NomUsu']);
}

$query_Recordset4 = sprintf("SELECT * FROM personal WHERE NomUsu = '%s'", $colname_Recordset4);
$Recordset4 = mysql_query($query_Recordset4, $SICMEC) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="sp">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<link rel="StyleSheet" type="text/css" media="screen,projection" href="css/present.css"  />
<link rel="StyleSheet" type="text/css" media="screen,projection" href="css/text.css"  />
<link rel="StyleSheet" type="text/css" media="screen,projection" href="css/formularios.css"  />
<title>Elimina Personal</title>
<script type="text/JavaScript">
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
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
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
			<li>Personal</li>
			<li><a href="#">Elimina Personal</a></li>
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
			<h1 class="pagetitle">Sustituir Equipo de C&oacute;mputo</h1>
			<div class="column1-unit">

				<form class="formulario" style="width:440px" id="form1" name="form1" method="post" action="">
    			<p>
    				<label for="NomUsu" class="left">Nombre de Usuario: </label>
        		<input class="field" name="NomUsu" type="text" id="NomUsu" value="<?php echo $_POST['NomUsu']; ?>" size="15" maxlength="15" onChange="javascript: this.value=this.value.toUpperCase();"/>
        	</p>
          <input class="button" name="Buscar" type="submit" id="Buscar" value="Buscar" />
  			</form>

  			<form class="formulario" style="width:600px" action="<?php echo $editFormAction; ?>" method="POST" name="form3" id="form3" onSubmit="MM_validateForm('Nombre','','R','NomUsu','','R','Password','','R','Email','','NisEmail','Telefono','','NisNum','NomUsu','','R');return document.MM_returnValue">
    			<p>
    				<label for="Nombre" class="leftW">Nombre:</label>
            <input class="field" name="Nombre" type="text" id="Nombre" disabled="disabled" value="<?php echo $row_Recordset4['Nombre']; ?>" size="50" maxlength="50" onChange="javascript: this.value=this.value.toUpperCase();"/>
          </p>
          <input name="NomUsu2" type="hidden" id="NomUsu2" value="<?php echo $row_Recordset4['NomUsu']; ?>" size="15" maxlength="15" onChange="javascript: this.value=<?php echo $row_Recordset4['NomUsu']; ?> "/>
          <p>
          	<label for="Password" class="leftW">Password:</label>
            <input class="field" name="Password" type="text" id="Password" value="<?php echo $row_Recordset4['Password']; ?>" size="18" maxlength="15" onChange="javascript: this.value=this.value.toUpperCase();" disabled="disabled"/>
          </p>
          <p>
          	<label for="Direccion" class="leftW">Direcci&oacute;n:</label>
          	<textarea name="Direccion" cols="50" rows="2" disabled="disabled" onChange="javascript: this.value=this.value.toUpperCase();" id="Direccion"><?php echo $row_Recordset4['Direccion']; ?> </textarea>
          </p>
        	<p>
        		<label for="Email" class="leftW">e-Mail:</label>
            <input class="field" name="Email" type="text" id="Email"  disabled="disabled" value="<?php echo $row_Recordset4['Email']; ?>" size="50" maxlength="50" />
          </p>
        	<p>
        		<label for="Telefono" class="leftW">Tel&eacute;fono:</label>
            <input class="field" name="Telefono" type="text" id="Telefono" disabled="disabled" value="<?php echo $row_Recordset4['Telefono']; ?>" size="20" maxlength="20" />
          </p>
        	<p>
        		<label for="CvePuesto" class="leftW">Puesto:</label>
            <select class="combo" name="CvePuesto" id="CvePuesto" disabled="disabled" title="<?php echo $row_Recordset4['CvePuesto']; ?>">
              <option value="" <?php if (!(strcmp("", $row_Recordset4['CvePuesto']))) {echo "selected=\"selected\"";} ?>></option>
							<?php
						do {
							?><option value="<?php echo $row_Recordset1['CvePuesto']?>"<?php if (!(strcmp($row_Recordset1['CvePuesto'], $row_Recordset4['CvePuesto']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset1['Descripcion']?></option>
              <?php
							} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  						$rows = mysql_num_rows($Recordset1);
  						if($rows > 0) {
      					mysql_data_seek($Recordset1, 0);
	  						$row_Recordset1 = mysql_fetch_assoc($Recordset1);
  						}
							?>
          	</select>
          </p>
        	<p>
        		<label for="CveGrupo" class="leftW">Grupo:</label>
          	<select class="combo" name="CveGrupo" id="CveGrupo" disabled="disabled" title="<?php echo $row_Recordset4['CveGrupo']; ?>">
            	<option value="" <?php if (!(strcmp("", $row_Recordset4['CveGrupo']))) {echo "selected=\"selected\"";} ?>></option>
            	<?php
						do {
							?><option value="<?php echo $row_Recordset2['CveGrupo']?>"<?php if (!(strcmp($row_Recordset2['CveGrupo'], $row_Recordset4['CveGrupo']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset2['Descripcion']?></option>
            	<?php
							} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  						$rows = mysql_num_rows($Recordset2);
  						if($rows > 0) {
      					mysql_data_seek($Recordset2, 0);
	  						$row_Recordset2 = mysql_fetch_assoc($Recordset2);
  						}
							?>
          	</select>
          </p>
        	<input class="button" name="Baja" type="submit" id="Baja" value="Eliminar" /></td>
					<input type="hidden" name="MM_delete" value="form3">
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
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);

mysql_free_result($Recordset4);
?>
