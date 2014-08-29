<?php
session_start();
//Validacion de Usuario
if($_SESSION['Validar'] != "OK" or $_SESSION["CveGrupo"] != 2){
		header("Location: index.php");
		exit();
	}
require_once('Connections/SICMEC.php');

$CveRep = $_REQUEST['CveRep'];

mysql_select_db($database_SICMEC, $SICMEC);
$query_Recordset5 = "SELECT CveRep, Titulo, Reporte, CveAdscrip FROM reporte WHERE CveRep = '".$CveRep."'";
$Recordset5=mysql_query($query_Recordset5,$SICMEC)or die(mysql_error());
$row_Recordset5=mysql_fetch_assoc($Recordset5);

$query_Recordset6 = "SELECT a.CveAdscrip, a.Descripcion FROM adscripcion a JOIN reporte r ON r.CveAdscrip = a.CveAdscrip WHERE r.CveRep = '".$CveRep."'";
$Recordset6=mysql_query($query_Recordset6,$SICMEC)or die(mysql_error());
$row_Recordset6=mysql_fetch_assoc($Recordset6);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
//INSERTAMOS EL SERVICIO DE LA PLAZA
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO servicioplaza (Descrip, Observaciones, TecnicoINEA, Encargado, CvePuesto, CveAdscrip, FecServ, CveRep, Titulo) VALUES ('%s', '%s', '%s', '%s', %s, '%s', '%s', '%s', '%s')",$_POST['Descrip'],$_POST['Observaciones'],$_POST['TecnicoINEA'],$_POST['Encargado'],$_POST['CvePuesto'],$_POST['CveAdscrip'],$_POST['FecServ'],$_POST['CveRep'],$_POST['Titulo']);  
   $Result1 = mysql_query($insertSQL, $SICMEC)or die(mysql_error());

//ACTUALIZAMOS EL ESTATUS DEL REPORTE COMO ATENDIDO
  if($CveRep != 0){
       $updateSQL = sprintf("UPDATE reporte SET Status= 'ATENDIDO' WHERE CveRep = %s ", $CveRep);
       $Result2 = mysql_query($updateSQL, $SICMEC);
  }
  else $Result2 =1;
   if ($Result1 > 0 AND $Result2 > 0)
  {
    ?> <script language="javascript"> alert('El reporte ha sido ATENDIDO con exito.'); </script> <?php
   }
  else
    {  ?> <script language="javascript"> alert('Error al intentar almacenar el registro en la Base de Datos.'); </script> <?php }
}

$query_Recordset1 = "SELECT CveAdscrip, Descripcion FROM adscripcion ORDER BY Descripcion ASC";
$Recordset1 = mysql_query($query_Recordset1, $SICMEC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset2 = "-1";
if (isset($_SESSION['NomUsu'])) {
  $colname_Recordset2 = (get_magic_quotes_gpc()) ? $_SESSION['NomUsu'] : addslashes($_SESSION['NomUsu']);
}

$query_Recordset2 = sprintf("SELECT Nombre, NomUsu FROM personal WHERE NomUsu = '%s'", $colname_Recordset2);
$Recordset2 = mysql_query($query_Recordset2, $SICMEC) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$query_Recordset4 = "SELECT CvePuesto, Descripcion FROM puesto ORDER BY Descripcion ASC";
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
<title>Servicio a Plaza</title>
<script Language="JavaScript">
function gettheDate() {
Todays = new Date();
//document.clock.thedate.value = TheDate;
if (Todays.getYear() < 2000)
TheDate = "" + (Todays.getYear()+ 1900) +"-"+ (Todays.getMonth()+ 1) + "-" + Todays.getDate()
else
TheDate = "" + Todays.getYear() +"-"+ (Todays.getMonth()+ 1) + "-" + Todays.getDate()
document.form1.FecServ.value = TheDate;
}
var timerID = null;
var timerRunning = false;
function stopclock (){
	if(timerRunning)
		clearTimeout(timerID);
	timerRunning = false;
}
function startclock () {
	// Make sure the clock is stopped
	stopclock();
	gettheDate()
	showtime();
}
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
<body onLoad="startclock()">
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
			<li>Servicio a Plazas</li>
			<li><a href="#">Servicio a Plaza</a></li>
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
			<h1 class="pagetitle">Registrar Servicio a Plaza</h1>
			<div class="column1-unit">

  			<form class="formulario" style="width:600px;" action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1" onSubmit="MM_validateForm('Titulo','','R','Encargado','','R','Descrip','','R');return document.MM_returnValue">
    			<p>
    				<label for="Titulo" class="leftW">T&iacute;tulo:</label>
			<input class="field" name="Titulo2" type="text" id="Titulo2" size="50" maxlength="50"  disabled="disabled" onChange="javascript: this.value=this.value.toUpperCase();" value="<? if($CveRep == 0)echo "SIN REPORTE"; else echo $row_Recordset5['Titulo']; ?>"/>		
          	<input class="field" name="Titulo" type="hidden" id="Titulo" value="<? if($CveRep == 0)echo "SIN REPORTE"; else echo $row_Recordset5['Titulo']; ?>"/>
          </p>
		  <p>
    		<label for="Reporte" class="leftW">Reporte</label>
          	<textarea name="Reporte" cols="50" rows="10" id="reporte" disabled="disabled"> <? if($CveRep == 0)echo "SERVICIO REALIZADO SIN PREVIO REPORTE"; else echo $row_Recordset5['Reporte'];?>"</textarea>
          </p>
          <p>
          	<label for="Descrip" class="leftW">Descripci&oacute;n:</label>
          	<textarea name="Descrip" cols="50" rows="10" id="Descrip" onChange="javascript: this.value=this.value.toUpperCase();"></textarea>
          </p>
        	<p>
        		<label for="Observaciones" class="leftW">Observaciones:</label>
          	<textarea name="Observaciones" cols="50" rows="4" id="Observaciones" onChange="javascript: this.value=this.value.toUpperCase();"></textarea>
          </p>
        	<p>
        		<label for="CveAdscrip" class="leftW">Plaza:</label>
			<? if ($CveRep != 0){?>
			<input type="hidden" name="CveAdscrip" value="<? echo $row_Recordset6['CveAdscrip']?>">
           <input class="field" name="CveAdscrip2" type="text" id="CveAdscrip2" size="50" maxlength="50" disabled="disabled" value="<? echo $row_Recordset6['Descripcion']?>" onChange="javascript: this.value=this.value.toUpperCase();">
		   
			<? } else { ?>	
          	<select class="combo" name="CveAdscrip" style="width:350px;" id="CveAdscrip">
            	<option value=""></option>
            	<?php
						do {
							?>
            	<option value="<?php echo $row_Recordset1['CveAdscrip']?>"><?php echo $row_Recordset1['Descripcion']?></option>
            	<?php
							} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  						$rows = mysql_num_rows($Recordset1);
  						if($rows > 0) {
      					mysql_data_seek($Recordset1, 0);
	  						$row_Recordset1 = mysql_fetch_assoc($Recordset1);
  						}
							?>
          	</select>
			<? } ?>
          </p>
        	<p>
        		<label for="Encargado" class="leftW">Encargado:</label>
          	<input class="field" name="Encargado" type="text" id="Encargado" size="50" maxlength="60" onChange="javascript: this.value=this.value.toUpperCase();"/>
          </p>
        	<p>
        		<label for="CvePuesto" class="leftW">Puesto:</label>
          	<select class="combo" name="CvePuesto" id="CvePuesto">
            	<option value=""></option>
            	<?php
						do {
							?>
            	<option value="<?php echo $row_Recordset4['CvePuesto']?>"><?php echo $row_Recordset4['Descripcion']?></option>
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
        		<label for="Nombre" class="leftW">T&eacute;cnico INEA:</label>
          	<input class="field" name="Nombre" type="text" id="Nombre" value="<?php echo $row_Recordset2['Nombre']; ?>" size="50" maxlength="50" disabled="disabled" />
          </p>
          	<input name="TecnicoINEA" type="hidden" id="TecnicoINEA" value= "<?php echo $_SESSION["NomUsu"] ?>" size="10" maxlength="10" />
        	<p>
        		<label for="FecServ" class="leftW">Fecha:</label>
          	<input class="field" name="FecServ" type="text" id="FecServ" size="10" maxlength="10" />
          </p>
          <p>
          	<label for="CveRep" class="leftW">Reporte:</label>
          	<input class="field" name="CveRep2" type="text" id="CveRep2" size="5" maxlength="5" disabled="disabled" value="<? if($CveRep)echo $CveRep; else echo 0; ?>" />
			<input class="field" name="CveRep" type="hidden" id="CveRep" value="<? if($CveRep)echo $CveRep; else echo 0; ?>" />
          </p>
          <input class="button" name="Registrar" type="submit" id="Registrar" value="Registrar" />
     	 		<input type="hidden" name="MM_insert" value="form1">
  			</form>

				<form name="clock" onSubmit="0">
					<input type="hidden" name="thedate" size=12 value="">
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


?>
