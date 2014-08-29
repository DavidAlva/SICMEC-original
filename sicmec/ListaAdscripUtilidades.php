<?php
session_start();
//Validacion de Usuario
if($_SESSION['Validar'] != "OK"){
		header("Location: index.php");
		exit();
	}
require_once('Connections/SICMEC.php');
mysql_select_db($database_SICMEC, $SICMEC);
//SE INICIALIZAN LAS VARIABLES DE SESION  Y SE VALIDA LA AUTENTIFICACION DEL USUARIO-->
$colname2_Recordset1 = $_SESSION['NomUsu'];
$colname_Recordset1 = "I-110";
if (isset($_POST['CveAdscrip'])) {
  $colname_Recordset1 = (get_magic_quotes_gpc()) ? $_POST['CveAdscrip'] : addslashes($_POST['CveAdscrip']);
}
$colname1_Recordset1 = "";
if (isset($_POST['Descripcion'])) {
  $colname1_Recordset1 = (get_magic_quotes_gpc()) ? $_POST['Descripcion'] : addslashes($_POST['Descripcion']);
}
mysql_select_db($database_SICMEC, $SICMEC);
/*CONDICIONA LA INFORMACION QUE MUESTRA SEGUN CORRESPONDA AL TIPO DE USUARIO*/
if ($_SESSION["CveGrupo"] == 1)
   $query_Recordset1 = sprintf("SELECT *  FROM adscripcion a JOIN responsable r ON a.CveAdscrip = r.CveAdscrip WHERE r.NomUsu = '%s' ORDER BY a.Descripcion ASC",$colname2_Recordset1);
else
   $query_Recordset1 = sprintf("SELECT *  FROM adscripcion WHERE CveAdscrip LIKE '%s%%'AND (Descripcion LIKE '%%%s%%' OR Poblacion LIKE '%%%s%%') ORDER BY Descripcion ASC",   $colname_Recordset1,$colname1_Recordset1,$colname1_Recordset1);
$Recordset1 = mysql_query($query_Recordset1, $SICMEC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);//esta se agrego al ponr comentarios

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="sp">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<link rel="StyleSheet" type="text/css" media="screen,projection" href="css/present.css"  />
<link rel="StyleSheet" type="text/css" media="screen,projection" href="css/text.css"  />
<link rel="StyleSheet" type="text/css" media="screen,projection" href="css/formularios.css"  />
<title>Datos T&eacute;cnicos de Plazas</title>
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
			<li><a href="#">Datos T&eacute;cnicos de Plazas</a></li>
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
			<h1 class="pagetitle">Datos T&eacute;cnicos de Plazas Comunitarias y Coordinaciones de Zona</h1>
			<div class="column1-unit">
<?php
/*CONDICIONA LA INFORMACION A MOSTRAR DE ACUERDO AL TIPO DE USUARIO */
  if ($_SESSION['CveGrupo'] ==2 OR $_SESSION['CveGrupo'] ==3)
{
?>
  			<form class="formulario" id="form1" name="form1" method="post" action="">
        	<p>
        		<label for="CveAdscrip" class="left">Numero:</label>
        		<input class="field" name="CveAdscrip" type="text" id="CveAdscrip" value="<?php echo $_POST['CveAdscrip']; ?>" size="11" maxlength="11" onChange="javascript: this.value=this.value.toUpperCase();" />
        		<label for="Descripcion">Nombre:</label>
        		<input class="field" name="Descripcion" type="text" id="Descripcion" value="<?php echo $_POST['Descripcion']; ?>" size="70" onchange="javascript: this.value=this.value.toUpperCase();"/>
        	</p>
        	<input class="button" name="Buscar" type="submit" id="Buscar" value="Buscar" />
  			</form>
<?php
 }
?>
	<div class="tabla">
  <table>
  	<thead>
    	<tr>
      	<th>Clave</th>
      	<th>Descripcion</th>
      	<th>Poblacion</th>
      	<th>Email</th>
      	<th>Horario</th>
	  		<th>Direcci&oacute;n IP</th>
	  		<th>Mask</th>
	  		<th>Red</th>
    	</tr>
    </thead>
    <tbody>
    <?php $par= 1; do { ?>
      <tr <?php if($par == 2){$par = 1; echo "class='alt'";}else $par = 2; ?> >
        <td><?php echo $row_Recordset1['CveAdscrip']; ?></td>
        <td><?php echo $row_Recordset1['Descripcion']; ?></td>
        <td><?php echo $row_Recordset1['Poblacion']; ?></td>
        <td><?php echo $row_Recordset1['Email']; ?></td>
        <td><?php echo $row_Recordset1['Horario']; ?></td>
				<td><?php echo $row_Recordset1['IP']; ?></td>
				<td><?php echo $row_Recordset1['Mask']; ?></td>
				<td><?php echo $row_Recordset1['Red']; ?></td>
      </tr>
      <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
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
?>
