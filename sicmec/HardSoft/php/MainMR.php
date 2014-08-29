<?php
include_once('MemRam.php');
	if(!empty($_REQUEST['funcion']))
		$sFuncion = $_REQUEST['funcion'];

	$Memoria = new MemoriaRam('','','');

	switch($sFuncion){
		case 'MostrarMR': $Cant = 0;
											$Memoria->mostrarMem($Cant);
											break;
		case 'CantMR':		if (isset($_REQUEST["cantd"]))
												$CantMR = $_REQUEST['cantd'];
											else
												$CantMR = 0;
											$Memoria->mostrarMem($CantMR);
											break;
		case 'Guardar':		$Memoria->setCveMarca($_REQUEST['cveMarca']);
											$Memoria->setCapacidad(trim($_REQUEST['capacidad']));
											$Memoria->setVelocidad(trim($_REQUEST['velocidad']));
											//Recuperamos la cadena con las cves de activo
											$cveAct = $_REQUEST['cveAct'];
											$Memoria->guardaMemoria($cveAct,$_REQUEST['uniCap'],$_REQUEST['uniVel']);
											break;
		case 'Actualiza': $Memoria->setCveMarca($_REQUEST['cveMarca']);
											$Memoria->setCapacidad(trim($_REQUEST['capacidad']));
											$Memoria->setVelocidad(trim($_REQUEST['velocidad']));
											$Memoria->setCveMem($_REQUEST['cveMem']);
											//Se requiere la clase de equipoComputo debido a que los objetos se guardan en sesion
											require_once('equipoComputo.class.php');
											session_start();
											$cveAct = $_SESSION['Equipo']->getCveEquipo();
											$Memoria->ActualizaMR($cveAct,$_REQUEST['uniCap'],$_REQUEST['uniVel'],$_REQUEST['cveMemE']);
											break;
	}
?>