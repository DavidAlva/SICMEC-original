<?php
include_once('TarjVid.php');
	if(!empty($_REQUEST['funcion']))
		$sFuncion = $_REQUEST['funcion'];

	$Video = new TVideo('','','');

	switch($sFuncion){
		case 'MostrarTV': $Cant = 0;
											$Video->mostrarTV($Cant);
											break;
		case 'CantTV':		if (isset($_REQUEST["cantd"]))
												$CantTV = $_REQUEST['cantd'];
											else
												$CantTV = 0;
											$Video->mostrarTV($CantTV);
											break;
		case 'Guardar':		$Video->setCveMarca($_REQUEST['cveMarca']);
											$Video->setDescripcion(trim($_REQUEST['descripcion']));
											$Video->guardarTV($_REQUEST['cveAct']);
											break;
		case 'Actualiza':	$Video->setCveMarca($_REQUEST['cveMarca']);
											$Video->setDescripcion(trim($_REQUEST['descripcion']));
											$Video->setCveTV($_REQUEST['cveTV']);
											//Se requiere la clase de equipoComputo debido a que los objetos se guardan en sesion
											require_once('equipoComputo.class.php');
											session_start();
											$cveAct = $_SESSION['Equipo']->getCveEquipo();
											$Video->ActualizaTV($cveAct,$_REQUEST['cveTVE']);
											break;
	}
?>