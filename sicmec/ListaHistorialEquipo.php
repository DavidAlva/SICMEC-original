<?php
session_start();
//Validacion de Usuario
if($_SESSION['Validar'] != "OK" or $_SESSION["CveGrupo"] == 1){
		header("Location: index.php");
		exit();
	}
require_once('Connections/SICMEC.php');
mysql_select_db($database_SICMEC, $SICMEC);
/*QUERY QUE MUESTRA LOS VALORES DEL MENU DE CATALOGO*/
$query_Recordset1 = "SELECT * FROM catbien WHERE (CveClasificacion = 4) OR (CveCatalogo = 'I150200060' OR CveCatalogo = 'I150200122')";
$Recordset1 = mysql_query($query_Recordset1, $SICMEC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

/*QUERY QUE MUESTRA LOS VALORES DEL MENU DEL A� DE ALTA*/
$query_Recordset2 = "SELECT DISTINCT  AnnoAlta FROM actfijo ORDER BY AnnoAlta DESC";
$Recordset2 = mysql_query($query_Recordset2, $SICMEC) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

/*QUERY QUE MUESTRA LOS VALORES DEL MENU DEL STATUS */
$query_Recordset5 = "SELECT * FROM status ORDER BY Descripcion ASC";
$Recordset5 = mysql_query($query_Recordset5, $SICMEC) or die(mysql_error());
$row_Recordset5 = mysql_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysql_num_rows($Recordset5);

/*QUERY QUE MUESTRA LOS VALORES DEL MENU DE UBICACION */
$query_Recordset6 = "SELECT * FROM ubicacion ORDER BY DescripUbic ASC";
$Recordset6 = mysql_query($query_Recordset6, $SICMEC) or die(mysql_error());
$row_Recordset6 = mysql_fetch_assoc($Recordset6);
$totalRows_Recordset6 = mysql_num_rows($Recordset6);

/*SE ASIGNAN VALORES INICIALES A LAS VARIABLES ENVIADAS EN EL SUBMIT*/
$colname_Recordset3 = "";
if (isset($_POST['NumInv'])) {
  $colname_Recordset3 = (get_magic_quotes_gpc()) ? $_POST['NumInv'] : addslashes($_POST['NumInv']);
}
$colname1_Recordset3 = "";
if (isset($_POST['CveCatalogo'])) {
  $colname1_Recordset3 = (get_magic_quotes_gpc()) ? $_POST['CveCatalogo'] : addslashes($_POST['CveCatalogo']);
}
$colname2_Recordset3 = "";
if (isset($_POST['AnnoAlta'])) {
  $colname2_Recordset3 = (get_magic_quotes_gpc()) ? $_POST['AnnoAlta'] : addslashes($_POST['AnnoAlta']);
}

// ESTA VARIABLE DE SESSION MANDA LA QUERY, A GENERAR EL REPORTE EN CASO DE SER SOLICITADO
$colname4_Recordset3 = $_SESSION['NomUsu'];

$colname5_Recordset3 = "";
if (isset($_POST['FecInicial'])) {
  $colname5_Recordset3 = (get_magic_quotes_gpc()) ? $_POST['FecInicial'] : addslashes($_POST['FecInicial']);
}
$colname6_Recordset3 = "";
if (isset($_POST['FecHist'])) {
  $colname6_Recordset3 = (get_magic_quotes_gpc()) ? $_POST['FecHist'] : addslashes($_POST['FecHist']);
}
$colname7_Recordset3 = "";
if (isset($_POST['CveStatus'])) {
  $colname7_Recordset3 = (get_magic_quotes_gpc()) ? $_POST['CveStatus'] : addslashes($_POST['CveStatus']);
}
$colname8_Recordset3 = "";
if (isset($_POST['CveUbic'])) {
  $colname8_Recordset3 = (get_magic_quotes_gpc()) ? $_POST['CveUbic'] : addslashes($_POST['CveUbic']);
}
/*QUERY QUE BUSCA EL ACTIVO DE ACUERDO A LOS FILTROS*/
$query_Recordset3 = sprintf("SELECT DISTINCT af.CaractAcf, af.AnnoAlta, af.CveCatalogo, a.Descripcion, cb.DescCatalogo,hs.NumInv, hs.FecHist, hs.Diagnostico, s.descripcion, u.DescripUbic, p.Nombre, hs.CveHist FROM adscripcion a JOIN actfijo af ON a.CveAdscrip = af.CveAdscrip JOIN catbien cb ON af.CveCatalogo = cb.CveCatalogo JOIN historialstatus hs ON hs.CveCatalogo = cb.CveCatalogo JOIN personal p ON hs.TecnicoINEA = p.NomUsu JOIN status s ON s.CveStatus = hs.CveStatus JOIN ubicacion  u ON u.CveUbic = hs.CveUbic WHERE hs.CveCatalogo LIKE '%s%%' AND hs.NumInv  LIKE '%s%%' AND hs.AnnoAlta  LIKE '%s%%' AND hs.FecHist >= '%s' AND hs.FecHist <= '%s' AND (hs.NumInv = af.NumInv AND hs.CveCatalogo = af.Cvecatalogo AND hs.AnnoAlta = af.AnnoAlta) AND hs.CveStatus LIKE '%s%%' AND hs.CveUbic LIKE '%s%%' ORDER BY  af.CveCatalogo DESC, af.NumInv DESC, af.AnnoAlta DESC, hs.FecHist DESC",$colname1_Recordset3,$colname_Recordset3,$colname2_Recordset3, $colname5_Recordset3,$colname6_Recordset3,$colname7_Recordset3,$colname8_Recordset3 );
$Recordset3 = mysql_query($query_Recordset3, $SICMEC) or die(mysql_error());
$totalRows_Recordset3 = mysql_num_rows($Recordset3);
// ESTA VARIABLE DE SESSION MANDA LA QUERY, A GENERAR EL REPORTE EN CASO DE SER SOLICITADO
$_SESSION["query_Recordset4"] = $query_Recordset3;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="sp">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<link rel="StyleSheet" type="text/css" media="screen,projection" href="css/present.css"  />
<link rel="StyleSheet" type="text/css" media="screen,projection" href="css/text.css"  />
<link rel="StyleSheet" type="text/css" media="screen,projection" href="css/formularios.css"  />
<title>Estatus del Equipo</title>
<!-- SE REALIZA UNA FUNCION PARA ASIGNAR A UNA CAJA DE TEXTO EL VALOR DE LA FECHA ACTUAL -->
<script Language="JavaScript">
function gettheDate() {
Todays = new Date();
if (Todays.getYear() < 2000)
TheDate = "" + (Todays.getYear()+ 1900) +"-"+ (Todays.getMonth()+ 1) + "-" + Todays.getDate()
else
TheDate = "" + Todays.getYear() +"-"+ (Todays.getMonth()+ 1) + "-" + Todays.getDate()
document.form1.FecHist.value = TheDate;
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
	stopclock();
	gettheDate()
	showtime();
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
			<li>Estatus del Equipo</li>
			<li><a href="#">Historial del Equipo</a></li>
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
		<h1 class="pagetitle">Historial de Status de los Equipos</h1>
		<div class="column1-unit">
 			<form class="formulario" id="form1" name="form1" method="post" action="">
    			<p>
    			<label for="CveCatalogo" class="left">Cve. Cat&aacute;logo:</label>
		        <select class="combo" name="CveCatalogo" id="CveCatalogo" title="<?php echo $_POST['CveCatalogo']; ?>">
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
          		<label for="NumInv">No. Inventario:</label>
          		<input class="field" style= "width:200px;" name="NumInv" type="text"  id="NumInv" value="<?php echo $_POST['NumInv']; ?>" size="5" maxlength="5" />
          		<label for="AnnoAlta">A&ntilde;o de Alta :</label>
          		<select class="combo" name="AnnoAlta" style="width:60px;" id="AnnoAlta" title="<?php echo $_POST['AnnoAlta']; ?>">
              			<option value=""></option>
              			<?php
				do {
					?>
              				<option value="<?php echo $row_Recordset2['AnnoAlta']?>"><?php echo $row_Recordset2['AnnoAlta']?></option>
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
          		<label for="FecInicial" class="left">Fecha del</label>
          		<input class="field" style="width:90px;" name="FecInicial" type="text" id="FecInicial" value="<?php echo $_POST['FecInicial']; ?>" size="10" maxlength="10" />
			<label for="FecHist">al:</label>
			<input class="field" name="FecHist" style="width:90px;" type="text" id="FecHist" value="<?php echo $_POST['FecHist']; ?>" size="10" maxlength="10"  />
			<label for="CveStatus">Status:</label>
          		<select class="combo" name="CveStatus" id="CveStatus" title="<?php echo $_POST['CveStatus']; ?>">
            		<option value="">TODOS</option>
            			<?php
				do {
				?>
            				<option value="<?php echo $row_Recordset5['CveStatus']?>"><?php echo $row_Recordset5['Descripcion']?></option>
            			<?php
				} while ($row_Recordset5 = mysql_fetch_assoc($Recordset5));
  				$rows = mysql_num_rows($Recordset5);
  				if($rows > 0) {
      					mysql_data_seek($Recordset5, 0);
	  					$row_Recordset5 = mysql_fetch_assoc($Recordset5);
  				}
				?>
          		</select>
          		<label for="CveUbic">Ubicaci&oacute;n:</label>
          		<select class="combo" name="CveUbic" id="CveUbic" title="<?php echo $_POST['CveUbic']; ?>">
            		<option value="">TODOS</option>
            			<?php
				do {
				?>
            				<option value="<?php echo $row_Recordset6['CveUbic']?>"><?php echo $row_Recordset6['DescripUbic']?></option>
            			<?php
				} while ($row_Recordset6 = mysql_fetch_assoc($Recordset6));
  					$rows = mysql_num_rows($Recordset6);
  				if($rows > 0) {
      					mysql_data_seek($Recordset6, 0);
	  				$row_Recordset6 = mysql_fetch_assoc($Recordset6);
  				}
				?>
          		</select>
         		</p>
          		<p>
          	<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0" width="100" height="20">
            		<param name="movie" value="button1.swf" />
            		<param name="quality" value="high" />
            		<param name="bgcolor" value="#FFFFCC" />
            		<embed src="button1.swf" quality="high" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="100" height="20" bgcolor="#FFFFCC"></embed>
          	</object>
          	</p>
          	<input class="button" type="submit" name="Submit" value="Enviar" />
  		</form>
  		<h2>Total de Equipos: <?php echo $totalRows_Recordset3?></h2>
  		<div class="tabla">
  			<table>
    			<thead>
    				<tr>
				<th>Modificar</th>
      				<th>Inventario</th>
	  			<th>Cat&aacute;logo</th>
	   			<th>Caracter&iacute;ticas</th>
      				<th>Fecha</th>
      				<th>Diagnostico</th>
      				<th>Status</th>
      				<th>Ubicaci&oacute;n</th>
      				<th>Tecnico INEA</th>
      				<th>Descripcion</th>
    				</tr>
    			</thead>
    			<tboby>
    			<?php while ($row_Recordset3 = mysql_fetch_assoc($Recordset3)) { ?>
      			<tr <?php if($par == 2){$par = 1; echo "class='alt'";}else $par = 2; ?>>
				<td>
					<form id="form3" name="form3" method="post" action="ModificaHistorial.php">
		  				<input name="CveHist" type="hidden"  id="CveHist" value="<?php echo $row_Recordset3['CveHist']; ?>" size="10" maxlength="5" />			  
						<input type="submit" name="Submit3" value="Cambiar"/>
		  			</form>
		  		</td>
        			<td><?php echo $row_Recordset3['CveCatalogo'] . "-" . $row_Recordset3['NumInv'] . "-" . $row_Recordset3['AnnoAlta']; ?></td>
				<td><?php echo $row_Recordset3['DescCatalogo']; ?></td>
				<td><?php echo $row_Recordset3['CaractAcf']; ?></td>
        			<td nowrap="nowrap"><?php echo $row_Recordset3['FecHist']; ?></td>
        			<td><?php echo $row_Recordset3['Diagnostico']; ?></td>
        			<td><?php echo $row_Recordset3['descripcion']; ?></td>
        			<td><?php echo $row_Recordset3['DescripUbic']; ?></td>
        			<td><?php echo $row_Recordset3['Nombre']; ?></td>
		 		<td><?php echo $row_Recordset3['Descripcion']; ?></td>
      			</tr>
      			<?php } ?>
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
mysql_free_result($Recordset5);
mysql_free_result($Recordset6);
mysql_free_result($Recordset3);
?>
