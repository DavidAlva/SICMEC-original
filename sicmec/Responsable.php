<?php
session_start();
//Validacion de Usuario
if($_SESSION['Validar'] != "OK" or $_SESSION["CveGrupo"] == 1){
		header("Location: index.php");
		exit();
	}
require_once('Connections/SICMEC.php');
mysql_select_db($database_SICMEC, $SICMEC);
/*QUERY QUE MUESTRA LOS VALORES DEL MENU DE ADSCRIPCION */
$query_Recordset1 = "SELECT CveAdscrip, Descripcion FROM adscripcion ORDER BY Descripcion ASC";
$Recordset1 = mysql_query($query_Recordset1, $SICMEC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

/*SE ASIGNAN VALORES INICIALES A LAS VARIABLES ENVIADAS EN EL SUBMIT*/
$colname_Recordset2 = "";
if (isset($_POST['NomUsu'])) {
  $colname_Recordset2 = (get_magic_quotes_gpc()) ? $_POST['NomUsu'] : addslashes($_POST['NomUsu']);
}
$colname1_Recordset2 = "";
if (isset($_POST['CveAdscrip'])) {
  $colname1_Recordset2 = (get_magic_quotes_gpc()) ? $_POST['CveAdscrip'] : addslashes($_POST['CveAdscrip']);
}
//QUERY QUE MUESTRA LOS SATOS DE LA PLAZA Y QUIEN ESTA A CARGO DE ELLA
$query_Recordset2 = sprintf("SELECT p.NomUsu, p.Nombre, ps.descripcion, a.CveAdscrip, a.Descripcion, a.Poblacion FROM personal p JOIN responsable r  ON p.NomUsu = r.NomUsu JOIN adscripcion a ON a.CveAdscrip = r.CveAdscrip JOIN puesto ps ON ps.CvePuesto = p.CvePuesto WHERE (p.Nombre LIKE '%%%s%%' OR r.NomUsu LIKE '%%%s%%') AND r.CveAdscrip LIKE '%s%%'", $colname_Recordset2, $colname_Recordset2,$colname1_Recordset2);
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
<title>Responsable</title>
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
			<li>Datos de Plazas</li>
			<li><a href="#">Responsable</a></li>
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
			<h1 class="pagetitle">Responsable de la Plaza</h1>
			<div class="column1-unit">

  			<form class="formulario" id="form1" name="form1" method="post" action="">
    			<p>
    				<label for="NomUsu" class="left">Usuario:</label>
            <input class="field" name="NomUsu" type="text" id="NomUsu" value="<?php echo $_POST['NomUsu']; ?>" size="15" maxlength="15" onchange="javascript: this.value=this.value.toUpperCase();"/>
        		<label for="CveAdscrip">Plaza:</label>
            <select class="combo" name="CveAdscrip" style="width:350px" id="CveAdscrip" title="<?php echo $_POST['CveAdscrip']; ?>">
              <option value="">TODAS</option>
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
            </p>
          	<input class="button" type="submit" name="Submit" value="Enviar" />
  				</form>
				<div class="tabla">
  				<table>
    				<thead>
    					<tr>
      					<th>Usuario</th>
      					<th>Nombre</th>
      					<th>Puesto</th>
      					<th>Cve. Adscripci&oacute;n</th>
      					<th>Adscripci&oacute;n</th>
	  						<th>Poblaci&oacute;n</th>
    					</tr>
    				</thead>
    				<tbody>
    <?php $par = 1; do { ?>
      				<tr <?php if($par == 2){$par = 1; echo "class='alt'";}else $par = 2; ?>>
        				<td><?php echo $row_Recordset2['NomUsu']; ?></td>
        				<td><?php echo $row_Recordset2['Nombre']; ?></td>
        				<td nowrap="nowrap"><?php echo $row_Recordset2['descripcion']; ?></td>
        				<td nowrap="nowrap"><?php echo $row_Recordset2['CveAdscrip']; ?></td>
        				<td><?php echo $row_Recordset2['Descripcion']; ?></td>
								<td><?php echo $row_Recordset2['Poblacion']; ?></td>
      				</tr>
      <?php } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2)); ?>
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
