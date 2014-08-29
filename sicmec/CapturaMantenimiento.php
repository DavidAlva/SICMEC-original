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

$query_Recordset1 = sprintf("SELECT CveAdscrip, Descripcion FROM adscripcion ORDER BY Descripcion ASC");
$Recordset1 = mysql_query($query_Recordset1, $SICMEC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

// LA PAGINA SE MANDA LLAMR A SI MISMA
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

// VALIDA SI YA OCURRIO UN SUBMIT EN LA PAGINA, DE SER ASI INSERTA EN LA BD
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO mantenimientos (Folio, FecManto, CveAdscrip, Reporta, Plataforma, CPU, Monitor, Teclado, Mouse, Switch, Impresora, Nobreak, Router, UPS, Servidor, Satisfaccion1, Satisfaccion2, Satisfaccion3, Satisfaccion4, Satisfaccion5, Observaciones) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')",$_POST['Folio'], $_POST['FecManto'], $_POST['CveAdscrip'], $_POST['Reporta'], $_POST['Plataforma'], $_POST['CPU'], $_POST['Monitor'], $_POST['Teclado'], $_POST['Mouse'], $_POST['Switch'], $_POST['Impresora'], $_POST['Nobreak'], $_POST['Router'], $_POST['UPS'], $_POST['Servidor'], $_POST['Satisfaccion1'], $_POST['Satisfaccion2'], $_POST['Satisfaccion3'], $_POST['Satisfaccion4'], $_POST['Satisfaccion5'], $_POST['Observaciones']);

  $Result1 = mysql_query($insertSQL, $SICMEC);
  if ($Result1 > 0)
  	{?> <script language="javascript"> alert('El registro ha sido insertado con exito.'); </script> <?php 	
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
document.form1.FecManto.value = TheDate;
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
			<li>Mantenimiento</li>
			<li><a href="#">Capturar Mantenimiento</a></li>
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
			<h1 class="pagetitle">Captura de Mantenimiento Preventivo</h1>
			<div class="column1-unit">

  			<form class="formulario" action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1" onSubmit="MM_validateForm('FecManto','','R','Folio','','RisNum','Reporta','','R','CPU','','RisNum','Monitor','','RisNum','Teclado','','RisNum','Mouse','','RisNum','Switch','','RisNum','Impresora','','RisNum','Nobreak','','RisNum','Router','','RisNum','UPS','','NisNum','Servidor','','RisNum','Observaciones','','R');return document.MM_returnValue">

    			<p>
    			<label for="FecManto" class="leftW">Fecha:</label>
				<input class='field' name="FecManto" type="text" id="FecManto" size="10" maxlength="10" />
				<label for="Folio" class="rightW">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;N&uacute;mero Folio:</label>
				<input name="Folio" type="text" class="right" id="Folio" value="" size="6"/>
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
          <label for="Reporta1" class="leftW">Reporta:</label>
          <input name="Reporta" type="hidden" id="Reporta" value="<?php echo $row_Recordset2['NomUsu']; ?>"/>
<input name="Reporta1" type="text" id="Reporta1" value="<?php echo $row_Recordset2['Nombre']; ?>" size="30" maxlength="50" disabled="disabled" />
          </p>

	  <div class="tabla">
	  <table align="center">
  		<thead>
    			<tr>
      				<th>PC</th>
      				<th>EMAC</th>
      				<th>IMAC</th>
      				<th>SUN</th>
			</tr>
    		</thead>
	  	<tbody>
			<tr>
				<th><input type="radio" name="Plataforma" value="PC"/></th>
      				<th><input type="radio" name="Plataforma" value="EMAC" /></th>
				<th><input type="radio" name="Plataforma" value="IMAC" /></th>
				<th><input type="radio" name="Plataforma" value="SUN" /></th>
			</tr>
	  	</tbody>
    	  </table>
	  </div>

	  <p>
              <label for="Teclado" class="leftW">Teclado:</label>
              <input name="Teclado" type="text" id="Teclado" size="3" maxlength="3" value="0"/>
          </p>
	  <p>
              <label for="Mouse" class="leftW">Mouse:</label>
              <input name="Mouse" type="text" id="Mouse"  size="3" maxlength="3" value="0"/>
          </p>
	   <p>
              <label for="Monitor" class="leftW">Monitor:</label>
              <input name="Monitor" type="text" id="Monitor"  size="3" maxlength="3" value="0"/>
          </p>	
	  <p>
              <label for="CPU" class="leftW">CPU:</label>
              <input name="CPU" type="text" id="CPU"  size="3" maxlength="3" value="0"/>
          </p>
	  <p>
              <label for="Switch" class="leftW">Switch:</label>
              <input name="Switch" type="text" id="Switch"  size="3" maxlength="3" value="0"/>
          </p>
	  <p>
              <label for="Impresora" class="leftW">Impresora:</label>
              <input name="Impresora" type="text" id="Impresora"  size="3" maxlength="3" value="0"/>
          </p>
	  <p>
              <label for="Router" class="leftW">Router:</label>
              <input name="Router" type="text" id="Router"  size="3" maxlength="3" value="0"/>
          </p>
	  
	  <p>
              <label for="Servidor" class="leftW">Servidor:</label>
              <input name="Servidor" type="text" id="Servidor"  size="3" maxlength="3" value="0"/>
          </p>
 	  <p>
              <label for="UPS" class="leftW">UPS:</label>
              <input name="UPS" type="text" id="UPS"  size="3" maxlength="3" value="0"/>
          </p>
	  <p>
              <label for="NoBreak" class="leftW">No-Break:</label>
              <input name="NoBreak" type="text" id="Nobreak"  size="3" maxlength="3" value="0" />
          </p>
	  </br>
 	  <p>
             <label for="Observaciones" class="leftW">Observaciones:</label>
             <textarea name="Observaciones" cols="100" rows="10" id="Observaciones" onChange="javascript: this.value=this.value.toUpperCase();"></textarea>
          </p>
	  </br>
	  <p>
          <label for="Satisfaccion1" class="leftW">El nivel de compromiso de la empresa de mantenimiento fu&eacute;:</label>
          <select class="combo" style="width:150px" name="Satisfaccion1" id="Satisfaccion1">
              <option value="Muy Bueno">Muy Bueno</option>
	      <option value="Bueno">Bueno</option>
	      <option value="Regular">Regular</option>
	      <option value="Malo">Malo</option>
	  </select>
	  </p>
	  <p>
          <label for="Satisfaccion2" class="leftW">Se cubrieron las espectativas del mantenimiento:</label>
          <select class="combo" style="width:150px" name="Satisfaccion2" id="Satisfaccion2">
              <option value="Muy Bueno">Muy Bueno</option>
	      <option value="Bueno">Bueno</option>
	      <option value="Regular">Regular</option>
	      <option value="Malo">Malo</option>
	  </select>
	  </p>
  	  <p>
          <label for="Satisfaccion3" class="leftW">los equipos quedaron como se esperaba:</label>
          <select class="combo" style="width:150px" name="Satisfaccion3" id="Satisfaccion3">
              <option value="Muy Bueno">Muy Bueno</option>
	      <option value="Bueno">Bueno</option>
	      <option value="Regular">Regular</option>
	      <option value="Malo">Malo</option>
	  </select>
	  </p>
	  <p>
          <label for="Satisfaccion4" class="leftW">La actitud del personal como la califica:</label>
          <select class="combo" style="width:150px" name="Satisfaccion4" id="Satisfaccion4">
              <option value="Muy Bueno">Muy Bueno</option>
	      <option value="Bueno">Bueno</option>
	      <option value="Regular">Regular</option>
	      <option value="Malo">Malo</option>
	  </select>
	  </p>
	  <p>
          <label for="Satisfaccion5" class="leftW">En general como califica el servicio:</label>
          <select class="combo" style="width:150px" name="Satisfaccion5" id="Satisfaccion5">
              <option value="Muy Bueno">Muy Bueno</option>
	      <option value="Bueno">Bueno</option>
	      <option value="Regular">Regular</option>
	      <option value="Malo">Malo</option>
	  </select>
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
mysql_free_result($Recordset2);
mysql_free_result($Recordset1);
?>
