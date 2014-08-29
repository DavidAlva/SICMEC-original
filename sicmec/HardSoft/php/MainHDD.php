<?php
include_once('HDD.php');
	if(!empty($_REQUEST['funcion']))
		$sFuncion = $_REQUEST['funcion'];

	$Disco = new HDD('','','','');

	switch($sFuncion){
		case 'MostrarHDD': $Cant = 0;
											$Disco->mostrarHDD($Cant);
											break;
		case 'CantHDD':		if (isset($_REQUEST["cantd"]))
												$CantHDD = $_REQUEST['cantd'];
											else
												$CantHDD = 0;
											$Disco->mostrarHDD($CantHDD);
											break;
		case 'Guardar':		$Disco->setCveMarca($_REQUEST['cveMarca']);
											$Disco->setCapacidad(trim($_REQUEST['capacidad']));
											$Disco->setVelocidad(trim($_REQUEST['velocidad']));
											$Disco->setConexion(trim($_REQUEST['conec']));
											$Disco->guardaHDD($_REQUEST['cveAct'],$_REQUEST['uniCap'],$_REQUEST['uniVel']);
											break;
		case 'Actualiza': $Disco->setCveMarca($_REQUEST['cveMarca']);
											$Disco->setCapacidad(trim($_REQUEST['capacidad']));
											$Disco->setVelocidad(trim($_REQUEST['velocidad']));
											$Disco->setConexion(trim($_REQUEST['conec']));
											$Disco->setCveHdd($_REQUEST['cveHDD']);
											//Se requiere la clase de equipoComputo debido a que los objetos se guardan en sesion
											require_once('equipoComputo.class.php');
											session_start();
											$cveAct = $_SESSION['Equipo']->getCveEquipo();
											$Disco->ActualizaHDD($cveAct,$_REQUEST['uniCap'],$_REQUEST['uniVel'],$_REQUEST['cveHDDE']);
											break;
	}
?>