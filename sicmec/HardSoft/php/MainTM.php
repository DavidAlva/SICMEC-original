<?php
require_once('TarjMad.php');
	if(!empty($_REQUEST['funcion']))
		$sFuncion = $_REQUEST['funcion'];

	$Tarjeta = new TarjetaMadre('','','');

	switch($sFuncion){
		case 'MostrarTM': $Tarjeta->mostrarTabla();
											break;
		case 'Guardar':		$Tarjeta->setCveMarca($_REQUEST['cveMarca']);
											$Tarjeta->setDescripcion(trim($_REQUEST['descrip']));
											//Si la clave del Activo = Actualiza se trata de un actualizacion de 1 equipoComputo
											//Por tanto hay que recuperar el valor del objeto equipo
											if($_REQUEST['cveAct'] == "Actualiza"){
												//Se requiere la clase de equipoComputo debido a que los objetos se guardan en sesion
												require_once('equipoComputo.class.php');
												session_start();
												$cveAct = $_SESSION['Equipo']->getCveEquipo();
											}
											else //De lo contrario recuperamos la cadena con las cves de activo
												$cveAct = $_REQUEST['cveAct'];
											$Tarjeta->guardaEquipo($cveAct);
											break;
	}
?>