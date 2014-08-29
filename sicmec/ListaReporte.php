<?php
session_start();
//Validacion de Usuario
if($_SESSION['Validar'] != "OK" or $_SESSION["CveGrupo"] == 1){
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

$colname1_Recordset1 = "";
if (isset($_POST['CveAdscrip'])) {
  $colname1_Recordset1 = (get_magic_quotes_gpc()) ? $_POST['CveAdscrip'] : addslashes($_POST['CveAdscrip']);
}
$colname_Recordset1 = "";
if (isset($_POST['Status'])) {
  $colname_Recordset1 = (get_magic_quotes_gpc()) ? $_POST['Status'] : addslashes($_POST['Status']);
}
$colname2_Recordset1 = "";
if (isset($_POST['FecInicial'])) {
  $colname2_Recordset1 = (get_magic_quotes_gpc()) ? $_POST['FecInicial'] : addslashes($_POST['FecInicial']);
}
$colname3_Recordset1 = "";
if (isset($_POST['FecRep'])) {
  $colname3_Recordset1 = (get_magic_quotes_gpc()) ? $_POST['FecRep'] : addslashes($_POST['FecRep']);
}
//QUERY QUE MUESTRA LOS REPORTES SOLICITADOS POR LOS FILTROS
$query_Recordset1 = sprintf("SELECT r.CveRep, r.FecRep, r.Titulo,r.Reporta, a.Descripcion, r.Reporte, r.Status FROM reporte r JOIN adscripcion a ON r.CveAdscrip = a.CveAdscrip WHERE (r.FecRep >= '%s' AND r.FecRep <= '%s') AND r.Status = '%s' AND a.CveAdscrip LIKE '%s%%' AND r.CveAdscrip = a.CveAdscrip ORDER BY r.CveRep DESC", $colname2_Recordset1,$colname3_Recordset1,$colname_Recordset1,$colname1_Recordset1);
// VARIABLE DE SESION QUE GUARDA LA QUERY PARA CUANDO SE SOLICITE EXPORTAR EL REPORTE
$_SESSION["query_Recordset3"] = $query_Recordset1;
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
<title>Reportes</title>
<!-- SE REALIZA UNA FUNCION PARA ASIGNAR A UNA CAJA DE TEXTO EL VALOR DE LA FECHA ACTUAL -->
<script Language="JavaScript">
function gettheDate() {
Todays = new Date();
if (Todays.getYear() < 2000)
TheDate = "" + (Todays.getYear()+ 1900) +"-"+ (Todays.getMonth()+ 1) + "-" + Todays.getDate()
else
TheDate = "" + Todays.getYear() +"-"+ (Todays.getMonth()+ 1) + "-" + Todays.getDate()
document.form1.FecRep.value = TheDate;
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
			<li>Reporte de Falla</li>
			<li><a href="#">Fallas Reportadas</a></li>
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
			<h1 class="pagetitle">Reportes</h1>
			<div class="column1-unit">

	  		<form class="formulario" id="form1" name="form1" method="post" action="">
          <p>
          	<label for="FecInicial" class="left">Fecha del:</label>
            <input class="field" name="FecInicial" style="width:90px;" type="text" id="FecInicial" value="<?php echo $_POST['FecInicial']; ?>" size="10" maxlength="10">
            <label for="FecRep"> al: </label>
        		<input class="field" name="FecRep" type="text" id="FecRep" value="<?php echo $_POST['FecRep']; ?>" size="10" maxlength="10">
        		<label for="Status">Status:</label>
            <select class="combo" name="Status" id="Status" title="<?php echo $_POST['Status']; ?>">
                <option value="PENDIENTE">PENDIENTE</option>
                <option value="ATENDIDO">ATENDIDO</option>
          	</select>
        </p>
        <p>
        	<label for="CveAdscrip" class="left">Plaza:</label>
          <select class="combo" name="CveAdscrip" style="width:350px;" id="CveAdscrip" title="<?php echo $_POST['CveAdscrip']; ?>">
              <option value="I-110">TODOS</option>
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
          </p>
          <p>
          	<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0" width="100" height="20">
          		<param name="movie" value="button2.swf" />
          		<param name="quality" value="high" />
          		<param name="bgcolor" value="#FFFFCC" />
          		<embed src="button2.swf" quality="high" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="100" height="20" bgcolor="#FFFFCC"></embed>
        	</object>
        </p>
        <input class="button" name="Consultar" type="submit" id="Consultar" value="Consultar" />
       </form>
			<div class="tabla">
      	<table>
	  			<thead>
    				<tr>
	  				<th>Rep</th>
      				<th>Fecha</th>
      				<th>T&iacute;tulo</th>
      				<th>Report&oacute;</th>
      				<th>Plaza</th>
      				<th>Reporte</th>
      				<th>Estatus</th>
    				</tr>
    			</thead>
    			<tbody>
				<tr
				<?php 
				$par = 1; 
				if($par == 2){$par = 1; echo "class='alt'";}else $par = 2; ?>>
				    <? if ($_SESSION["CveGrupo"] == 2){?>	
				    <td>
					    <? if ($_POST['Status'] != 'ATENDIDO') {?>
						<form id="form3" name="form3" method="POST" action="ServicioPlaza.php">
						<input name="CveRep" type="hidden" id="CveRep" size="5" maxlength="5" value="0" />
            			<input name="Actualizar" type="submit" id="Actualizar" value="0" />
            			<input type="hidden" name="MM_update" value="form3" />
						 </form>
						 
					</td>
				    <td>SIN FECHA</td>
        			<td>SIN REPORTE</td>
        			<td><?php echo $_SESSION['NomUsu'];?></td>
        			<td>SIN PLAZA</td>
        			<td>SERVICIO REALIZADO SIN PREVIO REPORTE</td>
        			<td>PENDIENTE</td>
      			</tr>
			   <?} 
				} ?>
    	<?php 
		      while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)) 
			  { ?>
      			<tr <?php if($par == 2){$par = 1; echo "class='alt'";}else $par = 2; ?>>
	  				<? if ($row_Recordset1 > 0 AND $_SESSION["CveGrupo"] == 2){?>
	  					<td>
						<? if ($_POST['Status'] != 'ATENDIDO') {?>
	  					<form id="form2" name="form2" method="POST" action="ServicioPlaza.php">
          				    <input name="CveRep" type="hidden" id="CveRep" size="5" maxlength="5" value="<?php echo $row_Recordset1['CveRep']; ?>" />
            				<input name="Actualizar" type="submit" id="Actualizar" value="<?php echo $row_Recordset1['CveRep']; ?>" />
            				<input type="hidden" name="MM_update" value="form2" />
					    </form>
						<? } else {?>
						<form id="form2" name="form2" method="POST" action="ListaServicioPlaza.php">
          				    <input name="CveRep" type="hidden" id="CveRep" size="5" maxlength="5" value="<?php echo $row_Recordset1['CveRep']; ?>" />
            				<input name="Actualizar" type="submit" id="Actualizar" value="<?php echo $row_Recordset1['CveRep']; ?>" />
            				<input type="hidden" name="MM_update" value="form2" />
					    </form>
						<? }?>
            	       </td>
            	<? }
				        elseif ($row_Recordset1 > 0 AND $_SESSION["CveGrupo"] == 3){?>
						<td><?php echo $row_Recordset1['CveRep']; ?></td>
		<? }?>
        			<td><?php echo $row_Recordset1['FecRep']; ?></td>
        			<td><?php echo $row_Recordset1['Titulo']; ?></td>
        			<td><?php echo $row_Recordset1['Reporta']; ?></td>
        			<td><?php echo $row_Recordset1['Descripcion']; ?></td>
        			<td><?php echo $row_Recordset1['Reporte']; ?></td>
        			<td nowrap="NOWRAP"><?php echo $row_Recordset1['Status']; ?></td>
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
?>
