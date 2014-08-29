<?php
session_start();
//Validacion de Usuario
if($_SESSION['Validar'] != "OK" or $_SESSION["CveGrupo"] != 2){
		header("Location: index.php");
		exit();
	}
require_once('Connections/SICMEC.php');
mysql_select_db($database_SICMEC, $SICMEC);
/*SE ASIGNA VALORES INICIALES A LA VARIABLE UTILIZADA EN LA QUERY*/
$colname_Recordset1 = "";
if (isset($_POST['TecnicoINEA'])) {
  $colname_Recordset1 = (get_magic_quotes_gpc()) ? $_POST['TecnicoINEA'] : addslashes($_POST['TecnicoINEA']);
}
$colname1_Recordset1 = "";
if (isset($_POST['FecServ'])) {
  $colname1_Recordset1 = (get_magic_quotes_gpc()) ? $_POST['FecServ'] : addslashes($_POST['FecServ']);
}
$colname2_Recordset1 = "";
if (isset($_POST['Titulo'])) {
  $colname2_Recordset1 = (get_magic_quotes_gpc()) ? $_POST['Titulo'] : addslashes($_POST['Titulo']);
}
$colname3_Recordset1 = "";
if (isset($_POST['CveAdscrip'])) {
  $colname3_Recordset1 = (get_magic_quotes_gpc()) ? $_POST['CveAdscrip'] : addslashes($_POST['CveAdscrip']);
}
$colname5_Recordset1 = "";
if (isset($_POST['FecInicial'])) {
  $colname5_Recordset1 = (get_magic_quotes_gpc()) ? $_POST['FecInicial'] : addslashes($_POST['FecInicial']);
}
$colname6_Recordset1 = $_REQUEST['CveRep'];
if (isset($_POST['CveRep'])) {
  $colname6_Recordset1 = (get_magic_quotes_gpc()) ? $_POST['CveRep'] : addslashes($_POST['CveRep']);
}
/*QUERY QUE MUESTRA LOS VALORES DEL SERVICIO DE ADSCRIPCION SEGUN LOS VALORE ENVIADOS POR LOS FILTROS*/
mysql_select_db($database_SICMEC, $SICMEC);
if ($colname6_Recordset1)
    $query_Recordset1 = sprintf("SELECT sp.CveServicio, sp.Titulo, sp.Descrip, sp.Observaciones, p.Nombre, a.Descripcion, sp.FecServ, sp.Encargado, pt.descripcion, sp.CveRep FROM servicioplaza sp join personal p on  sp.TecnicoINEA = p.NomUsu JOIN adscripcion a on sp.CveAdscrip = a.CveAdscrip JOIN puesto pt ON pt.CvePuesto = sp.CvePuesto WHERE sp.CveRep = %s", $colname6_Recordset1);
else
    $query_Recordset1 = sprintf("SELECT sp.CveServicio, sp.Titulo, sp.Descrip, sp.Observaciones, p.Nombre, a.Descripcion, sp.FecServ, sp.Encargado, pt.descripcion, sp.CveRep FROM servicioplaza sp join personal p on  sp.TecnicoINEA = p.NomUsu JOIN adscripcion a on sp.CveAdscrip = a.CveAdscrip JOIN puesto pt ON pt.CvePuesto = sp.CvePuesto WHERE (p.Nombre LIKE '%%%s%%' OR sp.TecnicoINEA LIKE '%s%%') AND sp.Titulo LIKE '%%%s%%' AND sp.FecServ >= '%s' AND sp.FecServ <= '%s'  AND sp.CveAdscrip LIKE '%s%%'  AND sp.CveRep LIKE '%%%s%%' ORDER BY sp.FecServ DESC", $colname_Recordset1, $colname_Recordset1, $colname2_Recordset1,$colname5_Recordset1, $colname1_Recordset1, $colname3_Recordset1,$colname6_Recordset1);
$Recordset1 = mysql_query($query_Recordset1, $SICMEC) or die(mysql_error());
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
<title>Visualizar Servicios a Plazas</title>
<!-- SE REALIZA UNA FUNCION PARA ASIGNAR A UNA CAJA DE TEXTO EL VALOR DE LA FECHA ACTUAL -->
<script Language="JavaScript">
function gettheDate() {
Todays = new Date();
if (Todays.getYear() < 2000)
TheDate = "" + (Todays.getYear()+ 1900) +"-"+ (Todays.getMonth()+ 1) + "-" + Todays.getDate()
else
TheDate = "" + Todays.getYear() +"-"+ (Todays.getMonth()+ 1) + "-" + Todays.getDate()
document.form1.FecServ.value = TheDate;
document.form1.FecInicial.value = "2006-01-01";
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

function mandarValor(variable){
	window.open('printServicio.php?CveServicio=' + variable,'','width=708, height=3365');
}
</script>

</head>
<!-- SE INICIALIZA LA FUNCION DEL CALENDARIO -->
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
			<li>Servicio a Plazas</li>
			<li><a href="#">Visualizar Servicios</a></li>
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
			<h1 class="pagetitle">Visualizar Servicios a Plazas</h1>
			<div class="column1-unit">

  			<form class="formulario" id="form1" name="form1" method="post" action="">
    			<p>
    				<label for="Titulo" class="left">T&iacute;tulo:</label>
            <input class="field" name="Titulo" type="text" id="Titulo" value="<?php echo $_POST['Titulo']; ?>" size="50" maxlength="50" onChange="javascript: this.value=this.value.toUpperCase();" />
            <label for="FecInicial">Fecha del</label>
            <input class="field" name="FecInicial" style="width:100px;" type="text" id="FecInicial" value="<?php echo $_POST['FecInicial']; ?>" size="10" maxlength="10"/>
            <label for="FecServ">al:</label>
            <input class="field" name="FecServ" style="width:100px;" type="text" id="FecServ" value="<?php echo $_POST['FecServ']; ?>" size="10" maxlength="10" />
          </p>
        	<p>
        		<label for="CveAdscrip" class="left">Plaza:</label>
              <select class="combo" name="CveAdscrip" style="width:350px;" id="CveAdscrip" title="<?php echo $_POST['CveAdscrip']; ?>">
            		<option value="">TODAS</option>
            		<?php
							do {
								?>
            		<option value="<?php echo $row_Recordset2['CveAdscrip']?>"><?php echo $row_Recordset2['Descripcion']?></option>
            		<?php
							} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  						$rows = mysql_num_rows($Recordset2);
  						if($rows > 0) {
      					mysql_data_seek($Recordset2, 0);
	  						$row_Recordset2 = mysql_fetch_assoc($Recordset2);
  						}
							?>
          		</select>
          		<label for="TecnicoINEA">T&eacute;cnico INEA</label>
            	<input class="field" name="TecnicoINEA" style="width:100px;" type="text" id="TecnicoINEA" value="<?php echo $_POST['TecnicoINEA']; ?>" size="10" maxlength="10" onChange="javascript: this.value=this.value.toUpperCase();"/>
            </p>
            <input class="button" type="submit" name="Submit" value="Enviar" />
           </form>
				<div class="tabla">
  				<table>
  					<thead>
    					<tr>
						<th></th>
      					<th>T&iacute;tulo</th>
      					<th>Descripci&oacute;n</th>
      					<th>Observaciones</th>
      					<th>Plaza</th>
      					<th>Fecha</th>
	  					<th>T&eacute;cnico INEA</th>
	  					<th>Encargado</th>
	    				<th>Puesto</th>
						<th>No. Reporte</th>
    					</tr>
    				</thead>
    				<tbody>
    			<?php $par = 1; while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)) { ?>
      				<tr <?php if($par == 2){$par = 1; echo "class='alt'";}else $par = 2; ?>>
						<td>
							<input type="button"  name="popup" value="print" id="<?php echo $row_Recordset1['CveServicio'];?> " onclick="mandarValor(this.id)"/>
						</td>
						<td><?php echo $row_Recordset1['Titulo']; ?></td>
        				<td><?php echo $row_Recordset1['Descrip']; ?></td>
        				<td><?php echo $row_Recordset1['Observaciones']; ?></td>
        				<td><?php echo $row_Recordset1['Descripcion']; ?></td>
        				<td><?php echo $row_Recordset1['FecServ']; ?></td>
        				<td><?php echo $row_Recordset1['Nombre']; ?></td>
		 				<td><?php echo $row_Recordset1['Encargado']; ?></td>
		 				<td><?php echo $row_Recordset1['descripcion']; ?></td>
						<td><?php echo $row_Recordset1['CveRep']; ?></td>
	  					</tr>
      <?php }  ?>
      			</tbody>
  				</table>
  			</div>
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
?>
