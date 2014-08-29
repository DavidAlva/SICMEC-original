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
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO actfijo (CveCatalogo, NumInv, AnnoAlta, CaractAcf, CveStatus, CveUbic, CveAdscrip, NumSerie) VALUES ('%s', %s, %s, %s, %s, %s, '%s', '%s')",$_POST['CveCatalogo'],$_POST['NumInv'],$_POST['AnnoAlta'],$_POST['CaractAcf'],$_POST['CveStatus'],$_POST['CveUbic'],$_POST['CveAdscrip'],$_POST['NumSerie']);
  $Result1 = mysql_query($insertSQL, $SICMEC);

/*MENSAJE DE ERROR O DE EXITO EN LA QUERY*/
   if ($Result1 > 0)
  {?> <script language="javascript"> alert('El registro ha sido insertado con exito.'); </script> <?php }
  else
  {  ?> <script language="javascript"> alert('Error al intentar almacenar el registro en la Base de Datos.'); </script> <?php }
}

/*QUERY QUE MUESTRA LOS VALORES DEL MENU DE CATALOGO*/
$query_Recordset1 = "SELECT CveCatalogo FROM catbien WHERE (CveClasificacion = 4) OR (CveCatalogo = 'I150200060' OR CveCatalogo = 'I150200122') ORDER BY CveCatalogo ASC";
$Recordset1 = mysql_query($query_Recordset1, $SICMEC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

/*QUERY QUE MUESTRA LOS VALORES DEL MENU DEL STATUS */
$query_Recordset2 = "SELECT * FROM status ORDER BY Descripcion ASC";
$Recordset2 = mysql_query($query_Recordset2, $SICMEC) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

/*QUERY QUE MUESTRA LOS VALORES DEL MENU DE UBICACION */
$query_Recordset3 = "SELECT * FROM ubicacion ORDER BY DescripUbic ASC";
$Recordset3 = mysql_query($query_Recordset3, $SICMEC) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

/*QUERY QUE MUESTRA LOS VALORES DEL MENU DE ADSCRIPCION */
$query_Recordset4 = "SELECT CveAdscrip, Descripcion FROM adscripcion ORDER BY Descripcion ASC";
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
<title>Alta de Equipo de C&oacute;mputo</title>
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
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
  } if (errors) alert('The following error(s) occurred:\n'+errors);
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
			<li>Datos de Equipo</li>
			<li><a href="#">Alta de Equipo de C&oacute;mputo</a></li>
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
			<h1 class="pagetitle">Alta de Equipo de C&oacute;mputo</h1>
			<div class="column1-unit">
  			<form class="formulario" style="width:600px;" action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1" onSubmit="MM_validateForm('NumInv','','RisNum','AnnoAlta','','RisNum','CaractAcf','','R');return document.MM_returnValue">
    			<p>
    				<label for="CveCatalogo" class="leftW">Catalogo:</label>
          	<select class="combo" name="CveCatalogo" id="CveCatalogo">
            	<option value=""></option>
            	<?php
						do {
							?>
            	<option value="<?php echo $row_Recordset1['CveCatalogo']?>"><?php echo $row_Recordset1['CveCatalogo']?></option>
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
          	<label for="NumInv" class="leftW">Inventario:</label>
          	<input class="field" name="NumInv" type="text" id="NumInv" size="5" maxlength="5" />
          </p>
        	<p>
        		<label for="AnnoAlta" class="leftW">A&ntilde;o de alta:</label>
          	<input class="field" name="AnnoAlta" type="text" id="AnnoAlta" size="2" maxlength="2" />
          </p>
        	<p>
        		<label for="NumSerie" class="leftW">Serie:</label>
          	<input class="field" name="NumSerie" type="text" id="NumSerie" size="20" maxlength="20" onChange="javascript: this.value=this.value.toUpperCase();"/>
          </p>
        	<p>
        		<label for="CaractAcf" class="leftW">Caracter&iacute;sticas:</label>
          	<textarea name="CaractAcf" cols="60" rows="3" id="CaractAcf" onChange="javascript: this.value=this.value.toUpperCase();"></textarea>
          </p>
        	<p>
        		<label for="CveStatus" class="leftW">Status:</label>
          	<select class="combo" name="CveStatus" id="CveStatus">
            	<option value=""></option>
            	<?php
						do {
							?>
            	<option value="<?php echo $row_Recordset2['CveStatus']?>"><?php echo $row_Recordset2['Descripcion']?></option>
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
          <p>
        		<label for="CveUbic" class="leftW">Ubicaci&oacute;n:</label>
          	<select class="combo" name="CveUbic" id="CveUbic">
            	<option value=""></option>
            	<?php
						do {
							?>
            	<option value="<?php echo $row_Recordset3['CveUbic']?>"><?php echo $row_Recordset3['DescripUbic']?></option>
            	<?php
						} while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));
  					$rows = mysql_num_rows($Recordset3);
  					if($rows > 0) {
      				mysql_data_seek($Recordset3, 0);
	  					$row_Recordset3 = mysql_fetch_assoc($Recordset3);
  					}
							?>
          	</select>
          </p>
          <p>
          	<label for="CveAdscrip" class="leftW">Adscripci&oacute;n:</label>
          	<select class="combo" style="width:350px;" name="CveAdscrip" id="CveAdscrip">
            	<option value=""></option>
            	<?php
						do {
							?>
            	<option value="<?php echo $row_Recordset4['CveAdscrip']?>"><?php echo $row_Recordset4['Descripcion']?></option>
            	<?php
							} while ($row_Recordset4 = mysql_fetch_assoc($Recordset4));
  						$rows = mysql_num_rows($Recordset4);
  						if($rows > 0) {
      					mysql_data_seek($Recordset4, 0);
	  						$row_Recordset4 = mysql_fetch_assoc($Recordset4);
  						}
							?>
          	</select>
          </p>
					<input class="button" name="Insertar" type="submit" id="Insertar" value="Insertar" /></td>
          <input type="hidden" name="MM_insert" value="form1">
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
<!-- SE LIBERAN LOS RESULTADOS DE LAS QUERYS-->
<?php
mysql_free_result($Recordset1);
mysql_free_result($Recordset2);
mysql_free_result($Recordset3);
mysql_free_result($Recordset4);
?>
