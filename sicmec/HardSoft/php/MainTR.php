<?php
include_once('TarjRed.php');
	if(!empty($_REQUEST['funcion']))
		$sFuncion = $_REQUEST['funcion'];

	$Tarjeta = new Red('','','','');

	switch($sFuncion){
		case 'MostrarTR': $Cant = 0;
											$Tarjeta->mostrarTR($Cant);
											break;
		case 'CantTR':		if (isset($_REQUEST["cantd"]))
												$CantTR = $_REQUEST['cantd'];
											else
												$CantTR = 0;
											$Tarjeta->mostrarTR($CantTR);
											break;
		case 'Guardar':		$Tarjeta->setCveMarca($_REQUEST['cveMarca']);
											$Tarjeta->setTipo(trim($_REQUEST['tipo']));
											$Tarjeta->setConexion(trim($_REQUEST['conexion']));
											$Tarjeta->setVelocidad(trim($_REQUEST['velocidad']));
											$Tarjeta->guardaTarRed($_REQUEST['cveAct'],$_REQUEST['uniVeloci']);
											break;
		case 'Actualiza': $Tarjeta->setCveMarca($_REQUEST['cveMarca']);
											$Tarjeta->setTipo(trim($_REQUEST['tipo']));
											$Tarjeta->setConexion(trim($_REQUEST['conexion']));
											$Tarjeta->setVelocidad(trim($_REQUEST['velocidad']));
											$Tarjeta->setCveTRed($_REQUEST['cveTR']);
											//Se requiere la clase de equipoComputo debido a que los objetos se guardan en sesion
											require_once('equipoComputo.class.php');
											session_start();
											$cveAct = $_SESSION['Equipo']->getCveEquipo();
											$Tarjeta->ActualizaTR($cveAct,$_REQUEST['uniVeloci'],$_REQUEST['cveTRE']);
											break;
	}
?>