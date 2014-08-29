<?php
session_start();
//Validacion de Usuario
if($_SESSION['Validar'] != "OK" or $_SESSION["CveGrupo"] == 1){
		header("Location: index.php");
		exit();
	}

require_once('Connections/SICMEC.php');
mysql_select_db($database_SICMEC, $SICMEC);
/*SE RECUPERAN VALORES ENVIADOS EN EL SUBMIT*/
$CveHist = $_REQUEST['CveHist'];


/*QUERY QUE BUSCA EL ACTIVO DE ACUERDO A LOS FILTROS*/
$query_Recordset9 = sprintf("SELECT CveHist, NumInv, CveCatalogo, AnnoAlta, NumSerie, Diagnostico, CveStatus, CveUbic, FecHist FROM historialstatus WHERE CveHist = '%s'" , $CveHist);
$Recordset9 = mysql_query($query_Recordset9, $SICMEC) or die(mysql_error());
$row_Recordset9 = mysql_fetch_assoc($Recordset9);
$totalRows_Recordset9 = mysql_num_rows($Recordset9);

echo $row_Recordset9['CveHist'];
/*CONDICIONA SI ENCONTRO ALGUN ACTIVO CON LOS MISMOS VALORES DEL QUERY*/
if ($totalRows_Recordset9 <= 0)
	{
	$query_Recordset9 = sprintf("SELECT NumInv, CveCatalogo, AnnoAlta, NumSerie FROM actfijo WHERE CveCatalogo = '%s' AND NumInv = %s AND AnnoAlta = %s AND NumSerie = '%s'", $CveCatalogo, $NumInv, $AnnoAlta, $NumSerie);
	$Recordset9 = mysql_query($query_Recordset9, $SICMEC) or die(mysql_error());
	$row_Recordset9 = mysql_fetch_assoc($Recordset9);
	$totalRows_Recordset9 = mysql_num_rows($Recordset9);
	}	

/*QUERY QUE MUESTRA LOS VALORES DEL MENU DEL STATUS */
$query_Recordset1 = "SELECT * FROM status";
$Recordset1 = mysql_query($query_Recordset1, $SICMEC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

/*QUERY QUE MUESTRA LOS VALORES DEL MENU DE UBICACION */
$query_Recordset2 = "SELECT * FROM ubicacion";
$Recordset2 = mysql_query($query_Recordset2, $SICMEC) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

/*QUERY QUE MUESTRA LOS VALORES DEL MENU DE CATALOGO*/
$query_Recordset3 = "SELECT * FROM catbien WHERE (CveClasificacion = 4) OR (CveCatalogo = 'I150200060' OR CveCatalogo = 'I150200122') ORDER BY CveCatalogo ASC";
$Recordset3 = mysql_query($query_Recordset3, $SICMEC) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

/*QUERY QUE MUESTRA LOS VALORES DEL MENU DEL A� DE ALTA*/
$query_Recordset4 = "SELECT DISTINCT AnnoAlta FROM actfijo ORDER BY AnnoAlta DESC";
$Recordset4 = mysql_query($query_Recordset4, $SICMEC) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

$colname_Recordset5 = "1";
if (isset($_SESSION['NomUsu'])) {
  $colname_Recordset5 = (get_magic_quotes_gpc()) ? $_SESSION['NomUsu'] : addslashes($_SESSION['NomUsu']);
}

/*QUERY QUE OBTIENE EL NOMBRE DEL USUARIO*/
$query_Recordset5 = sprintf("SELECT Nombre, NomUsu FROM personal WHERE NomUsu = '%s'", $colname_Recordset5);
$Recordset5 = mysql_query($query_Recordset5, $SICMEC) or die(mysql_error());
$row_Recordset5 = mysql_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysql_num_rows($Recordset5);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="sp">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<link rel="StyleSheet" type="text/css" media="screen,projection" href="css/present.css"  />
<link rel="StyleSheet" type="text/css" media="screen,projection" href="css/text.css"  />
<link rel="StyleSheet" type="text/css" media="screen,projection" href="css/formularios.css"  />
<title>Actualizar Historial</title>

<!-- CODIGO GENERADO POR DREAMWEAVER PARA VALIDAR EL FORMATO DEL TIPO DE DATO DE LAS CAJAS DE TEXTO -->
<script>
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
-->
</script>
</head>
<!-- SE INICIALIZA LA FUNCION DEL CALENDARIO -->
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
			<li><a href="#">Modifica Historial</a></li>
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
			<h1 class="pagetitle">Cambio de Estatus</h1>
			<div class="column1-unit">
  			<form class="formulario" style="width:600px" action="ModificaHistorial1.php" method="POST" name="form1" id="form1" onSubmit="MM_validateForm('NumInv','','RisNum','Diagnostico','','R');return document.MM_returnValue" >
    			<p>
    				<label for="CveCatalogo" class="leftW">Clasificaci&oacute;n:</label>
     				<select class="combo" name="CveCatalogo" id="CveCatalogo" title="<?php echo $row_Recordset9['CveCatalogo']; ?>">
        		    	<option value="" <?php if (!(strcmp("", $row_Recordset9['CveHist']))) {echo "selected=\"selected\"";} ?>></option>
            				<?php
					do {
						?><option value="<?php echo $row_Recordset3['CveCatalogo']?>"<?php if (!(strcmp($row_Recordset3['CveCatalogo'], $row_Recordset9['CveCatalogo']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset3['CveCatalogo']?></option>
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
        			<label for="NumInv" class="leftW">No. Inventario:</label>
          			<input class="field" name="NumInv" type="text" id="NumInv" value="<?php echo $row_Recordset9['NumInv']; ?>" size="5" maxlength="5" />
          		</p>
          		<p>
        			<label for="AnnoAlta" class="leftW">A&ntilde;o de Alta:</label>
          			<select class="combo" name="AnnoAlta" id="AnnoAlta" title="<?php echo $_POST['AnnoAlta']; ?>">
            			<option value="" <?php if (!(strcmp("", $row_Recordset9['AnnoAlta']))) {echo "selected=\"selected\"";} ?>></option>
            				<?php
					do {
						?><option value="<?php echo $row_Recordset4['AnnoAlta']?>"<?php if (!(strcmp($row_Recordset4['AnnoAlta'], $row_Recordset9['AnnoAlta']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset4['AnnoAlta']?></option>
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
        		<p>
        			<label for="NumSerie" class="leftW">No. Serie:</label>
        			<input class="field" name="NumSerie" type="text" id="NumSerie" size="20" maxlength="20" value="<?php echo $row_Recordset9['NumSerie']; ?>" onChange="javascript: this.value=this.value.toUpperCase();"/>
        		</p>
        		<p>
        			<label for="FecHist" class="leftW">Fecha:</label>
              			<input name="FecHist" type="text" id="FecHist" size="10" maxlength="10" value="<?php echo $row_Recordset9['FecHist']; ?>" />
          		</p>
        		<p>
        			<label for="Problema" class="leftW">Problema:</label>
        			<select name="Problema" id="Problema" title="<?php echo $Problema; ?>">
          				<option value=" "></option>
		  			<option value="SOFTWARE">SOFTWARE</option>
          				<option value="HARDWARE">HARDWARE</option>
          				<option value="AMBOS">AMBOS</option>
        			</select>
        		</p>
        		<p>
        			<label for="Diagnostico" class="leftW">Diagn&oacute;stico:</label>
          			<textarea name="Diagnostico" cols="50" rows="10" id="Diagnostico"  onchange="javascript: this.value=this.value.toUpperCase();" ><?php echo $row_Recordset9['Diagnostico']; ?></textarea>
          		</p>
        		<p>
        			<label for="Nombre" class="leftW">T&eacute;cnico INEA:</label>
          			<input class="field" name="Nombre" type="text" id="Nombre" value="<?php echo $row_Recordset5['Nombre']; ?>" size="50" maxlength="50" disabled="disabled" />
          		</p>
			<input name="TecnicoINEA" type="hidden" id="TecnicoINEA" size="10" maxlength="10" value="<? echo $_SESSION["NomUsu"];?>"/>
        		<p>
        			<label for="CveStatus" class="leftW">Estatus:</label>
          			<select class="combo" name="CveStatus" id="CveStatus" title="<?php echo $_POST['CveStatus']; ?>">
            			<option value="" <?php if (!(strcmp("", $row_Recordset9['CveStatus']))) {echo "selected=\"selected\"";} ?>></option>
            				<?php
					do {
						?><option value="<?php echo $row_Recordset1['CveStatus']?>"<?php if (!(strcmp($row_Recordset1['CveStatus'], $row_Recordset9['CveStatus']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset1['Descripcion']?></option>
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
        			<label for="CveUbic" class="leftW">Ubicaci&oacute;n:</label>
          			<select class="combo" name="CveUbic" id="CveUbic" title="<?php echo $_POST['CveUbic']; ?>">
            			<option value="" <?php if (!(strcmp("", $row_Recordset9['CveUbic']))) {echo "selected=\"selected\"";} ?>></option>
            				<?php
					do {
						?><option value="<?php echo $row_Recordset2['CveUbic']?>"<?php if (!(strcmp($row_Recordset2['CveUbic'], $row_Recordset9['CveUbic']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset2['DescripUbic']?></option>
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
        			<label for="CveRep" class="leftW">Reporte:</label>
          			<input class="field" name="CveRep" type="text" id="CveRep" size="5" maxlength="5" />
         		 </p>
          		<input type="hidden" name="CveHist" value= "<?php echo $CveHist;?>"/>
          		<input class="button" type="submit" name="Submit" value="Enviar" />
    			<input type="hidden" name="MM_insert" value="form1">
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
mysql_free_result($Recordset3);
mysql_free_result($Recordset4);
mysql_free_result($Recordset5);
mysql_free_result($Recordset9);
?>
