<?php
session_start();
//Validacion de Usuario
if($_SESSION['Validar'] != "OK" or $_SESSION["CveGrupo"] == 1){
		header("Location: index.php");
		exit();
	}
require_once('Connections/SICMEC.php');
mysql_select_db($database_SICMEC, $SICMEC);
$colname_Recordset2 = "";
if (isset($_SESSION['NomUsu'])) {
  $colname_Recordset2 = (get_magic_quotes_gpc()) ? $_SESSION['NomUsu'] : addslashes($_SESSION['NomUsu']);
}
$query_Recordset2 = sprintf("SELECT Nombre, NomUsu FROM personal WHERE NomUsu = '%s'", $colname_Recordset2);
$Recordset2 = mysql_query($query_Recordset2, $SICMEC) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$colname_Recordset1 = "";
if (isset($_SESSION["NomUsu"])) {
  $colname_Recordset1 = (get_magic_quotes_gpc()) ? $_SESSION["NomUsu"] : addslashes($_SESSION["NomUsu"]);
}

if ($_SESSION["CveGrupo"] == 1)
   $query_Recordset1 = sprintf("SELECT a.CveAdscrip, a.Descripcion FROM adscripcion a JOIN responsable r ON a.CveAdscrip = r.CveAdscrip WHERE r.NomUsu = '%s'   ORDER BY a.Descripcion ASC", $colname_Recordset1);
else
   $query_Recordset1 = sprintf("SELECT CveAdscrip, Descripcion FROM adscripcion ORDER BY Descripcion ASC");
$Recordset1 = mysql_query($query_Recordset1, $SICMEC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

//obtiene el numero de reporte que sigue 
$query_Recordset3 = sprintf("SELECT CveRep FROM reporte ORDER BY CveRep DESC LIMIT 1");
$Recordset3 = mysql_query($query_Recordset3, $SICMEC) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);

// LA PAGINA SE MANDA LLAMR A SI MISMA
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

// VALIDA SI YA OCURRIO UN SUBMIT EN LA PAGINA, DE SER ASI INSERTA EN LA BD
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO reporte (FecRep, Titulo, CveAdscrip, Reporta, Reporte, Status) VALUES ('%s', '%s', '%s', '%s', '%s' ,'%s')",$_POST['FecRep'],$_POST['Titulo'],$_POST['CveAdscrip'],$_POST['Reporta'],$_POST['Reporte'],$_POST['Status']);
  $Result1 = mysql_query($insertSQL, $SICMEC);
  if ($Result1 > 0)
  {?> <script language="javascript"> alert('El registro ha sido insertado con exito.'); </script> <?php 
	$query_Recordset3 = sprintf("SELECT CveRep FROM reporte ORDER BY CveRep DESC LIMIT 1");
        $Recordset3 = mysql_query($query_Recordset3, $SICMEC) or die(mysql_error());
        $row_Recordset3 = mysql_fetch_assoc($Recordset3);	
  }
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
<title>Reportar Falla</title>
<script Language="JavaScript">
function gettheDate() {
Todays = new Date();
if (Todays.getYear() < 2000)
TheDate = "" + (Todays.getYear()+ 1900) +"-"+ (Todays.getMonth()+ 1) + "-" + Todays.getDate()
else
TheDate = "" + Todays.getYear() +"-"+ (Todays.getMonth()+ 1) + "-" + Todays.getDate()//document.clock.thedate.value = TheDate;
document.form1.FecRep.value = TheDate;
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
//-->
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
			<li>Reporte de Falla</li>
			<li><a href="#">Reportar</a></li>
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
			<h1 class="pagetitle">Reporte de Falla</h1>
			<div class="column1-unit">

  			<form class="formulario" action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1" onSubmit="MM_validateForm('Titulo','','R','Reporte','','R');return document.MM_returnValue">
    			<p>
    			<label for="FecRep" class="leftW">Fecha:</label>
				<input name="FecRep" type="hidden" id="FecRep" size="10" maxlength="10" />
				<input class="field" name="Fecha" type="text" id="Fecha" size="10" maxlength="10" disabled="disabled"/>
				<label for="numero" class="rightW">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;N&uacute;mero de Reporte:</label>
				<input name="numero" type="text" class="right" id="numero" value="<?php echo $row_Recordset3['CveRep'] + 1; ?>" disabled="disabled" size="6"/>
					</p>
					
					<p>
          <label for="Titulo" class="leftW">Falla:</label>
          <input class="field" name="Titulo" type="text" id="Titulo" size="50" maxlength="100" onChange="javascript: this.value=this.value.toUpperCase();"/>
          </p>
          <p>
          <label for="CveAdscrip" class="leftW">Plaza:</label>
          <select class="combo" style="width:350px" name="CveAdscrip" id="CveAdscrip">
            <option value=""></option>
						<?php
					do {
						?>
            <option value="<?php echo $row_Recordset1['CveAdscrip']?>"><?php echo $row_Recordset1['Descripcion']." - ".$row_Recordset1['CveAdscrip']?></option>
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
        	<label for="Nombre" class="leftW">Reporta:</label>
          <input name="Nombre" type="text" id="Nombre" value="<?php echo $row_Recordset2['Nombre']; ?>" size="30" maxlength="50" disabled="disabled" />
          </p>
        	<p>
        	<label for="Reporte" class="leftW">Reporte:</label>
          <textarea name="Reporte" cols="50" rows="10" id="Reporte" onChange="javascript: this.value=this.value.toUpperCase();"></textarea>
          </p>
          <input name="Status" type="hidden" id="Status" value="PENDIENTE" />
          <input name="Reporta" type="hidden" id="Reporta" value= "<?php echo $_SESSION["NomUsu"] ?>" size="10" maxlength="10" />
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
mysql_free_result($Recordset2);
mysql_free_result($Recordset1);
?>
