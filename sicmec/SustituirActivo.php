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


/*QUERY QUE ACTUALIZA EL REGISTRO DEL ACTIVO CON LOS VALORES ENVIADOS EN EL SUBMIT*/
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
   mysql_select_db($database_SICMEC, $SICMEC);
   $Aux = "S-".$_POST[CveCatalogo2];
   $query_Recordset7 = sprintf("SELECT * FROM catbien WHERE CveCatalogo = '%s'", $Aux);
   $Recordset7 = mysql_query($query_Recordset7, $SICMEC) or die(mysql_error());
   $row_Recordset7 = mysql_fetch_assoc($Recordset7);
   $totalRows_Recordset7 = mysql_num_rows($Recordset7);
   
  //SE CONDICIONA SI YA EXISTE ESTE CATALOGO
   if ($totalRows_Recordset7 <= 0){
       $query_Recordset8 = sprintf("SELECT * FROM catbien WHERE CveCatalogo = '%s'", $_POST[CveCatalogo2]);
       $Recordset8 = mysql_query($query_Recordset8, $SICMEC) or die(mysql_error());
       $row_Recordset8 = mysql_fetch_assoc($Recordset8);
       $totalRows_Recordset8 = mysql_num_rows($Recordset8);
	
	   //EN CASO DE NO EXISTIR SE INSERTA EN LA BD
       $insert1SQL = sprintf("INSERT INTO catbien (CveCatalogo, CveClasificacion, DescCatalogo) VALUES ('%s', %s, '%s')",
				$Aux,$row_Recordset8['CveClasificacion'],$row_Recordset8['DescCatalogo']);
	  $Result2 = mysql_query($insert1SQL, $SICMEC) or die(mysql_error());
      }
	  
  //QUERY PARA OBTENER EL ULTIMO EQUIPO EN HISTORIALSTATUS Y ASIGNARLO A LA TABLA
  $query_Recordset9= sprintf("SELECT CveHist FROM historialstatus ORDER BY CveHist DESC LIMIT 1");
  $Recordset9= mysql_query($query_Recordset9,$SICMEC) or die(mysql_error());  
  $row_Recordset9 = mysql_fetch_assoc($Recordset9);
  
  //INSERTAMOS EL EQUIPO A SUSTITUIR EN LA TABLA DE HISTORIAL ESTATUS
  $insertSQL = sprintf("INSERT INTO historialstatus (NumInv, CveCatalogo, AnnoAlta, NumSerie, CveStatus, FecHist, CveUbic, Diagnostico, TecnicoINEA, CveRep, Problema) VALUES (%s, '%s', %s, '%s', %s, '%s', %s, 'ESTE EQUIPO SUSTITUYE A UN EQUIPO DAÑADO' , '%s', %s, 'HARDWARE')",$_POST['NumInv2'],$Aux, $_POST['AnnoAlta2'], $_POST['NumSerie'], $_POST['CveStatus'], $_POST['FecHist'], $_POST['CveUbic'], $_SESSION["NomUsu"], 0);
  mysql_select_db($database_SICMEC, $SICMEC);
  $Result1 = mysql_query($insertSQL, $SICMEC) or die(mysql_error());
  
  //QUERY PARA OBTENER EL ULTIMO EQUIPO EN HISTORIALSTATUS Y ASIGNARLO A LA TABLA
  $query_Recordset9= sprintf("SELECT CveHist FROM historialstatus ORDER BY CveHist DESC LIMIT 1");
  $Recordset9= mysql_query($query_Recordset9,$SICMEC) or die(mysql_error());  
  $row_Recordset9 = mysql_fetch_assoc($Recordset9);
  		
   //SE INSERTAN LOS VALORES DEL NUEVO ACTIVO QUE SUSTITUIRA AL VIEJO
  $insertSQL = sprintf("INSERT INTO actfijo (CveCatalogo, NumInv, AnnoAlta, CaractAcf, CveStatus, CveUbic, CveAdscrip, NumSerie, CveHist) VALUES ('%s', %s, %s, '%s', %s, %s, '%s', '%s', 0)",$Aux,$_POST['NumInv2'],$_POST['AnnoAlta2'],$_POST['CaractAcf'],$_POST['CveStatus'],$_POST['CveUbic'],$_POST['CveAdscrip'],$_POST['NumSerie']);
  $Result2 = mysql_query($insertSQL, $SICMEC) or die(mysql_error());
 
 $ultimo = $row_Recordset9['CveHist'];
  $insertSQL1 = "UPDATE actfijo SET CveHist = '$ultimo', CveStatus = '".$_POST['CveStatus']."', CveUbic = '".$_POST['CveUbic']."' WHERE (NumInv = '".$_POST['NumInv2']."' AND CveCatalogo = '".$Aux."' AND AnnoAlta = '".$_POST['AnnoAlta2']."') AND NumSerie = '".$_POST['NumSerie']."'";
  $Result3 = mysql_query($insertSQL1, $SICMEC) or die(mysql_error());
		 
  /*MENSAJE DE ERROR O DE EXITO EN LA QUERY*/
   if ($Result1 > 0 AND $Result2 > 0 AND $Result3 > 0)
     { ?> <script language="javascript"> alert('El registro ha sido insertado con exito.'); </script> <?php }
  else
     { ?> <script language="javascript"> alert('Error al intentar almacenar el registro en la Base de Datos.'); </script> <?php }
}
/*QUERY QUE MUESTRA LOS VALORES DEL MENU DE CATALOGO*/
$query_Recordset1 = "SELECT * FROM catbien WHERE (CveClasificacion = 4) OR (CveCatalogo = 'I150200060' OR CveCatalogo = 'I150200122') ORDER BY CveCatalogo ASC";
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

/*SE ASIGNAN VALORES INICIALES A LAS VARIABLES ENVIADAS EN EL SUBMIT*/
$colname2_Recordset5 = "0";
if (isset($_POST['AnnoAlta'])) {
  $colname2_Recordset5 = (get_magic_quotes_gpc()) ? $_POST['AnnoAlta'] : addslashes($_POST['AnnoAlta']);
}
$colname_Recordset5 = "99999";
if (isset($_POST['NumInv'])) {
  $colname_Recordset5 = (get_magic_quotes_gpc()) ? $_POST['NumInv'] : addslashes($_POST['NumInv']);
}
$colname1_Recordset5 = "1";
if (isset($_POST['CveCatalogo'])) {
  $colname1_Recordset5 = (get_magic_quotes_gpc()) ? $_POST['CveCatalogo'] : addslashes($_POST['CveCatalogo']);
}
/*QUERY QUE BUSCA EL ACTIVO DE ACUERDO A LOS FILTROS*/
$query_Recordset5 = sprintf("SELECT * FROM actfijo WHERE NumInv = '%s' AND CveCatalogo = '%s' AND AnnoAlta = '%s'", $colname_Recordset5,$colname1_Recordset5,$colname2_Recordset5);
$Recordset5 = mysql_query($query_Recordset5, $SICMEC) or die(mysql_error());
$row_Recordset5 = mysql_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysql_num_rows($Recordset5);

/*QUERY QUE MUESTRA LOS VALORES DEL MENU DEL Aï¿½ DE ALTA*/
$query_Recordset6 = "SELECT DISTINCT AnnoAlta FROM actfijo ORDER BY AnnoAlta DESC";
$Recordset6 = mysql_query($query_Recordset6, $SICMEC) or die(mysql_error());
$row_Recordset6 = mysql_fetch_assoc($Recordset6);
$totalRows_Recordset6 = mysql_num_rows($Recordset6);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="sp">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<link rel="StyleSheet" type="text/css" media="screen,projection" href="css/present.css"  />
<link rel="StyleSheet" type="text/css" media="screen,projection" href="css/text.css"  />
<link rel="StyleSheet" type="text/css" media="screen,projection" href="css/formularios.css"  />
<title>Sustituir Equipo de C&oacute;mputo</title>

<!-- SE REALIZA UNA FUNCION PARA ASIGNAR A UNA CAJA DE TEXTO EL VALOR DE LA FECHA ACTUAL -->
<script Language="JavaScript">
function gettheDate() {
Todays = new Date();
if (Todays.getYear() < 2000)
TheDate = "" + (Todays.getYear()+ 1900) +"-"+ (Todays.getMonth()+ 1) + "-" + Todays.getDate()
else
TheDate = "" + Todays.getYear() +"-"+ (Todays.getMonth()+ 1) + "-" + Todays.getDate()
document.form1.FecHist.value = TheDate;
document.form1.Fecha.value = TheDate;
}
var timerID = null;
var timerRunning = false;
function stopclock (){
	if(timerRunning)
		clearTimeout(timerID);
	timerRunning = false;
}
function startclock () {
	stopclock();
	gettheDate()
	showtime();
}
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
-->
</script>
</head>
<body onLoad="startclock();">
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
			<li><a href="#">Sustituir Equipo de C&oacute;mputo</a></li>
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
  			<form class="formulario" action="" method="post" name="form2" id="form2" onSubmit="MM_validateForm('NumInv','','RisNum');return document.MM_returnValue" >
						<p><label for="CveCatalogo" class="left">Catalogo:</label>
            	<select class="combo" name="CveCatalogo" id="CveCatalogo" title="<?php echo $_POST['CveCatalogo']; ?>">
              	<option value="" <?php if (!(strcmp("", $row_Recordset5['CveCatalogo']))) {echo "selected=\"selected\"";} ?>></option>
              	<?php do { ?>
              	      <option value="<?php echo $row_Recordset1['CveCatalogo']?>"<?php if (!(strcmp($row_Recordset1['CveCatalogo'], $row_Recordset5['CveCatalogo']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset1['CveCatalogo']?></option>
              	<?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  							$rows = mysql_num_rows($Recordset1);
  							if($rows > 0) {
      						mysql_data_seek($Recordset1, 0);
	  							$row_Recordset1 = mysql_fetch_assoc($Recordset1);
  							} ?>
            	</select>
        			<label for="NumInv">No. Inventario:</label>
            	<input class="field" name="NumInv" type="text" id="NumInv" value="<?php echo $_POST['NumInv']; ?>" size="5" maxlength="5" />
							<label for="AnnoAlta">A&ntilde;o:</label>
          		<select class="combo" style="width:60px;" name="AnnoAlta" id="AnnoAlta" title="<?php echo $_POST['AnnoAlta']; ?>">
            		<option value="" <?php if (!(strcmp("", $row_Recordset5['AnnoAlta']))) {echo "selected=\"selected\"";} ?>></option>
            		<?php do { ?><option value="<?php echo $row_Recordset6['AnnoAlta']?>"<?php if (!(strcmp($row_Recordset6['AnnoAlta'], $row_Recordset5['AnnoAlta']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset6['AnnoAlta']?></option>
            		<?php } while ($row_Recordset6 = mysql_fetch_assoc($Recordset6));
  							$rows = mysql_num_rows($Recordset6);
  							if($rows > 0) {
      						mysql_data_seek($Recordset6, 0);
	  							$row_Recordset6 = mysql_fetch_assoc($Recordset6);
  							} ?>
          		</select>
          	</p>
          	<input class="button" name="Buscar" type="submit" id="Buscar" value="Buscar" />
			<input type="hidden" name="MM_busca" value="form2">
  		</form>
				
				
    	<form class="formulario" style="width:600px;" action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1" onSubmit="MM_validateForm('NumInv2','','RisNum','CveCatalogo2','','R','AnnoAlta2','','RisNum');return document.MM_returnValue" >
          	<p><label for="Fecha" class="leftW">Fecha:</label>
          	<input name="Fecha" type="text" id="Fecha" size="10" maxlength="10" disabled="disabled" />
          	<input name="FecHist" type="hidden" id="FecHist" size="10" maxlength="10" />
            </p>
			<input name="NumInv2" type="hidden" id="NumInv2" value="<?php echo $_POST['NumInv']; ?>" size="5" maxlength="5" />
            <input name="CveCatalogo2" type="hidden" id="CveCatalogo2" value="<?php echo $row_Recordset5['CveCatalogo']; ?>" size="10" maxlength="10" />
            <input name="AnnoAlta2" type="hidden" id="AnnoAlta2" value="<?php echo $row_Recordset5['AnnoAlta']; ?>" size="2" maxlength="2" />
            <p>
            	<label for="NumSerie" class="leftW">Serie:</label>
            	<input class="field" name="NumSerie" type="text" id="NumSerie" value="<?php echo $row_Recordset5['NumSerie']; ?>" size="20" maxlength="20" onChange="javascript: this.value=this.value.toUpperCase();"/>
            </p>
            <p>
            	<label for="CaractAcf" class="leftW">Caracter&iacute;sticas:</label>
            	<textarea name="CaractAcf" cols="60" rows="3" onChange="javascript: this.value=this.value.toUpperCase();" id="CaractAcf"><?php echo $row_Recordset5['CaractAcf']; ?></textarea>
            </p>
          	<p>
          		<label for="CveStatus" class="leftW">Status:</label>
            	<select class="combo" name="CveStatus" id="CveStatus" title="<?php echo $row_Recordset5['CveStatus']; ?>">
              	<option value="" <?php if (!(strcmp("", $row_Recordset5['CveStatus']))) {echo "selected=\"selected\"";} ?>></option>
					<?php do {
								?><option value="<?php echo $row_Recordset2['CveStatus']?>"<?php if (!(strcmp($row_Recordset2['CveStatus'], $row_Recordset5['CveStatus']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset2['Descripcion']?></option>
              	 <?php } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  							$rows = mysql_num_rows($Recordset2);
  							if($rows > 0) {
      						mysql_data_seek($Recordset2, 0);
	  							$row_Recordset2 = mysql_fetch_assoc($Recordset2);
  							} ?>
            	</select>
            </p>
          	<p>	<label for="CveUbic" class="leftW">Ubicacion:</label>
            	<select class="combo" name="CveUbic" id="CveUbic" title="<?php echo $row_Recordset5['CveUbic']; ?>">
              	<option value="" <?php if (!(strcmp("", $row_Recordset5['CveUbic']))) {echo "selected=\"selected\"";} ?>></option>
					<?php do {
								?><option value="<?php echo $row_Recordset3['CveUbic']?>"<?php if (!(strcmp($row_Recordset3['CveUbic'], $row_Recordset5['CveUbic']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset3['DescripUbic']?></option>
              	<?php } while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));
  							$rows = mysql_num_rows($Recordset3);
  							if($rows > 0) {
      						mysql_data_seek($Recordset3, 0);
	  							$row_Recordset3 = mysql_fetch_assoc($Recordset3);
  							} ?>
            	</select>
            </p>
          	<p>	<label for="CveAdscrip" class="leftW">Adscripcion:</label>
            	<select class="combo" style="width:350px;" name="CveAdscrip" id="CveAdscrip" title="<?php echo $row_Recordset5['CveAdscrip']; ?>">
              	<option value="" <?php if (!(strcmp("", $row_Recordset5['CveAdscrip']))) {echo "selected=\"selected\"";} ?>></option>
              	<?php do {
						?><option value="<?php echo $row_Recordset4['CveAdscrip']?>"<?php if (!(strcmp($row_Recordset4['CveAdscrip'], $row_Recordset5['CveAdscrip']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset4['Descripcion']?></option>
              	<?php } while ($row_Recordset4 = mysql_fetch_assoc($Recordset4));
  								$rows = mysql_num_rows($Recordset4);
  								if($rows > 0) {
      							mysql_data_seek($Recordset4, 0);
	  								$row_Recordset4 = mysql_fetch_assoc($Recordset4);
  								} ?>
            		</select>
            	</p>
              <input class="button" name="Sustituir" type="submit" id="Sustituir" value="Sustituir" />
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
if ((isset($_POST["MM_busca"])) && ($_POST["MM_busca"] == "form2")) {
   mysql_select_db($database_SICMEC, $SICMEC);
   $query_Recordset5 = sprintf("SELECT * FROM actfijo WHERE (NumInv = '%s' AND CveCatalogo = '%s' AND AnnoAlta = '%s') AND (CveStatus = '8' OR CveStatus = '12')", $colname_Recordset5,$colname1_Recordset5, $colname2_Recordset5);
   $Recordset5 = mysql_query($query_Recordset5, $SICMEC) or die(mysql_error());
   $row_Recordset5 = mysql_fetch_assoc($Recordset5);
   $totalRows_Recordset5 = mysql_num_rows($Recordset5);
    if ($totalRows_Recordset5 <= 0)
     { ?> <script language="javascript"> alert('Te falta dar de baja este equipo.'); </script> 
  	      <script language="javascript"> location.href="ListaActivo.php" </script><?php }
}
mysql_free_result($Recordset1);
mysql_free_result($Recordset2);
mysql_free_result($Recordset3);
mysql_free_result($Recordset4);
mysql_free_result($Recordset5);
mysql_free_result($Recordset6);
?>
