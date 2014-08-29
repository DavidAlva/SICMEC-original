<?php
require_once('Software.class.php');
	if(!empty($_REQUEST['funcion']))
		$sFuncion = $_REQUEST['funcion'];

	$Software = new Software('');

	switch($sFuncion){
		case 'MostrarSO': $Software->mostrarSof();
											break;
		case 'Guardar':		$Software->setSisOpe($_REQUEST['cveSO']);
											$Software->setDescripcion(trim($_REQUEST['descrip']));
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
											$Software->guardaSO($cveAct);
											break;
	}
?>