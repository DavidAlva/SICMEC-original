<?php
session_start();
//Validacion de Usuario
if ($_SESSION['Validar'] != "OK" or $_SESSION["CveGrupo"] == 1) {
    header("Location: index.php");
    exit();
}
require_once('Connections/SICMEC.php');
mysql_select_db($database_SICMEC, $SICMEC);
/* SE ASIGNA VALORES INICIALES A LA VARIABLE UTILIZADA EN LA QUERY */
$colname3_Recordset1 = "I180";
if (isset($_POST['CveCatalogo'])) {
    $colname3_Recordset1 = (get_magic_quotes_gpc()) ? $_POST['CveCatalogo'] : addslashes($_POST['CveCatalogo']);
}
$colname2_Recordset1 = "I-110";
if (isset($_POST['CveAdscrip'])) {
    $colname2_Recordset1 = (get_magic_quotes_gpc()) ? $_POST['CveAdscrip'] : addslashes($_POST['CveAdscrip']);
}
$colname1_Recordset1 = "99999";
if (isset($_POST['NumSerie'])) {
    $colname1_Recordset1 = (get_magic_quotes_gpc()) ? $_POST['NumSerie'] : addslashes($_POST['NumSerie']);
}
$colname_Recordset1 = "XXXXX";
if (isset($_POST['NumInv'])) {
    $colname_Recordset1 = (get_magic_quotes_gpc()) ? $_POST['NumInv'] : addslashes($_POST['NumInv']);
}
$colname4_Recordset1 = "XXXXX";
if (isset($_POST['AnnoAlta'])) {
    $colname4_Recordset1 = (get_magic_quotes_gpc()) ? $_POST['AnnoAlta'] : addslashes($_POST['AnnoAlta']);
}
/* QUERY QUE BUSCA EL ACTIVO DE ACUERDO A LOS FILTROS */
$query_Recordset1 = sprintf("SELECT DISTINCT af.AnnoAlta, af.CveCatalogo, af.NumInv, af.NumSerie, c.DescCatalogo, af.CaractAcf, a.Descripcion, a.Poblacion, s.descripcion, u.DescripUbic FROM adscripcion a JOIN actfijo af  ON a.CveAdscrip = af.CveAdscrip JOIN catbien c ON af.CveCatalogo = c.CveCatalogo JOIN activoclasif ac ON c.CveClasificacion = ac.CveClasificacion JOIN status s ON s.CveStatus = af.CveStatus JOIN ubicacion u ON u.CveUbic = af.CveUbic WHERE NumInv LIKE '%s%%' AND af.NumSerie LIKE '%s%%' AND (c.CveClasificacion = 4 OR (c.CveCatalogo = 'I150200060' OR c.CveCatalogo = 'I150200122')) AND a.CveAdscrip LIKE '%s%%' AND af.CveCatalogo LIKE '%s%%' AND af.AnnoAlta LIKE '%s%%' ORDER BY c.CveCatalogo ASC,af.NumInv ASC,af.AnnoAlta ASC,a.CveAdscrip ASC", $colname_Recordset1, $colname1_Recordset1, $colname2_Recordset1, $colname3_Recordset1, $colname4_Recordset1);
$Recordset1 = mysql_query($query_Recordset1, $SICMEC) or die(mysql_error());
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

/* QUERY QUE MUESTRA LOS VALORES DEL MENU DE ADSCRIPCION */
$query_Recordset2 = "SELECT CveAdscrip, Descripcion FROM adscripcion ORDER BY Descripcion ASC";
$Recordset2 = mysql_query($query_Recordset2, $SICMEC) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

/* QUERY QUE MUESTRA LOS VALORES DEL MENU DE CATALOGO */
$query_Recordset3 = "SELECT CveCatalogo FROM catbien WHERE (CveClasificacion = 4) OR (CveCatalogo = 'I150200060' OR CveCatalogo = 'I150200122') ORDER BY CveCatalogo ASC";
$Recordset3 = mysql_query($query_Recordset3, $SICMEC) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

/* QUERY QUE MUESTRA LOS VALORES DEL MENU DEL A� DE ALTA */
$query_Recordset4 = "SELECT DISTINCT AnnoAlta FROM actfijo ORDER BY AnnoAlta DESC";
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
                    <li>Datos de Equipos</li>
                    <li><a href="#">Datos Generales de Equipos</a></li>
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
                    <h1 class="pagetitle">Datos Generales de Equipos</h1>
                    <div class="column1-unit">

                        <form class="formulario" id="form1" name="form1" method="post" action="">
                            <p>
                                <label for="CveCatalogo" class="left">No. Catalogo: </label>
                                <select class="combo" name="CveCatalogo" id="CveCatalogo" title="<?php echo $_POST['CveCatalogo']; ?>">
                                    <option value=""></option>
                                    <?php
                                    do {
                                        ?>
                                        <option value="<?php echo $row_Recordset3['CveCatalogo'] ?>"><?php echo $row_Recordset3['CveCatalogo'] ?></option>
                                        <?php
                                    } while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));
                                    $rows = mysql_num_rows($Recordset3);
                                    if ($rows > 0) {
                                        mysql_data_seek($Recordset3, 0);
                                        $row_Recordset3 = mysql_fetch_assoc($Recordset3);
                                    }
                                    ?>
                                </select>
                                <label for="NumInv">No. Inventario: </label>
                                <input class="field" name="NumInv" type="text" id="NumInv" value="<?php echo $_POST['NumInv']; ?>" size="5" maxlength="5" />
                                <label for="AnnoAlta">A&ntilde;o:</label>
                                <select class="combo" style="width:60px;" name="AnnoAlta" id="AnnoAlta" title="<?php echo $_POST['AnnoAlta']; ?>">
                                    <option value=""></option>
                                    <?php
                                    do {
                                        ?>
                                        <option value="<?php echo $row_Recordset4['AnnoAlta'] ?>"><?php echo $row_Recordset4['AnnoAlta'] ?></option>
                                        <?php
                                    } while ($row_Recordset4 = mysql_fetch_assoc($Recordset4));
                                    $rows = mysql_num_rows($Recordset4);
                                    if ($rows > 0) {
                                        mysql_data_seek($Recordset4, 0);
                                        $row_Recordset4 = mysql_fetch_assoc($Recordset4);
                                    }
                                    ?>
                                </select>
                            </p>
                            <p>
                                <label for="NumSerie" class="left">Serie:</label>
                                <input class="field" name="NumSerie" type="text" id="NumSerie" value="<?php echo $_POST['NumSerie']; ?>" size="20" maxlength="20" onchange="javascript: this.value=this.value.toUpperCase();"/>
                                <label for="CveAdscrip">Plaza:</label>
                                <select class="combo" name="CveAdscrip" id="CveAdscrip" title="<?php echo $_POST['CveAdscrip']; ?>">
                                    <option value="" <?php
                                    if (!(strcmp("", $row_Recordset2['Descripcion']))) {
                                        echo "selected=\"selected\"";
                                    }
                                    ?>>TODAS</option>
                                            <?php
                                            do {
                                                ?>
                                        <option value="<?php echo $row_Recordset2['CveAdscrip'] ?>"<?php
                                            if (!(strcmp($row_Recordset2['CveAdscrip'], $row_Recordset2['Descripcion']))) {
                                                echo "selected=\"selected\"";
                                            }
                                                ?>><?php echo $row_Recordset2['Descripcion']  . " - " . $row_Recordset2['CveAdscrip']?></option>
                                                <?php
                                            } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
                                            $rows = mysql_num_rows($Recordset2);
                                            if ($rows > 0) {
                                                mysql_data_seek($Recordset2, 0);
                                                $row_Recordset2 = mysql_fetch_assoc($Recordset2);
                                            }
                                            ?>
                                </select>
                            </p>
                            <input class="button" name="Buscar" type="submit" id="Buscar" value="Buscar" /></td>
                        </form>
                        <h2>Total de Equipos:&nbsp;<?php echo $totalRows_Recordset1 ?></h2>
                        <div class="tabla">
                            <table>
                                <thead>
                                    <tr>
                                        <?php
                                        /* CONDICIONA DEPENDIENDO DEL TIPO DE USUARIOS QUE RESULTADOS SON LOS QUE VA A MOSTRAR */
                                        if ($_SESSION["CveGrupo"] == 2) {
                                            ?>
                                            <th></th>
<? } ?>
                                        <th>Inventario</th>
                                        <th>Serie</th>
                                        <th>Descripci&oacute;n</th>
                                        <th>Caracter&iacute;sticas</th>
                                        <th>Estatus</th>
                                        <th>Ubicaci&oacute;n</th>
                                        <th>Plaza</th>
                                        <th>Municipio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $par = 1;
                                    /* CONDICIONA DEPENDIENDO DEL TIPO DE USUARIOS QUE RESULTADOS SON LOS QUE VA A MOSTRAR */
                                    while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)) {
                                        ?>
                                        <tr <?
                                    if ($par == 2) {
                                        echo "class='alt'";
                                        $par = 1;
                                    } else
                                        $par = 2;
                                    ?> >
    <?php if ($row_Recordset1 > 0 AND $_SESSION["CveGrupo"] == 2) { ?>
                                                <td>
                                                    <form id="form3" name="form3" method="post" action="ActualizaHistorial.php">
                                                        <input name="CveCatalogo" type="hidden"  id="CveCatalogo" value="<?php echo $row_Recordset1['CveCatalogo']; ?>" size="10" maxlength="5" />
                                                        <input name="NumInv" type="hidden"  id="NumInv" value="<?php echo $row_Recordset1['NumInv']; ?>" size="5" maxlength="5" />
                                                        <input name="AnnoAlta" type="hidden"  id="AnnoAlta" value="<?php echo $row_Recordset1['AnnoAlta']; ?>" size="5" maxlength="5" />
                                                        <input name="NumSerie" type="hidden"  id="NumSerie" value="<?php echo $row_Recordset1['NumSerie']; ?>" size="10" maxlength="5" />
                                                        <input type="submit" name="Submit3" value="Ir"/>
                                                    </form>
    <? } ?>
                                            </td>
                                            <td><?php echo $row_Recordset1['CveCatalogo'] . "-" . $row_Recordset1['NumInv'] . "-" . $row_Recordset1['AnnoAlta']; ?>
                                            </td>
                                            <td><?php echo $row_Recordset1['NumSerie']; ?></td>
                                            <td><?php echo $row_Recordset1['DescCatalogo']; ?></td>
                                            <td><?php echo $row_Recordset1['CaractAcf']; ?></td>
                                            <td><?php echo $row_Recordset1['descripcion']; ?></td>
                                            <td><?php echo $row_Recordset1['DescripUbic']; ?></td>
                                            <td><?php echo $row_Recordset1['Descripcion']; ?></td>
                                            <td><?php echo $row_Recordset1['Poblacion']; ?></td>
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
mysql_free_result($Recordset3);
mysql_free_result($Recordset4);
?>
