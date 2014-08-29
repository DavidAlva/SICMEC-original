<?php
include_once('Lectoras.php');
	if(!empty($_REQUEST['funcion']))
		$sFuncion = $_REQUEST['funcion'];

	$Lector = new Lectoras('','','');

	switch($sFuncion){
		case 'MostrarLe': $Cant = 0;
											$Lector->mostrarLector($Cant);
											break;
		case 'CantLe':		if (isset($_REQUEST["cantd"]))
												$CantLe = $_REQUEST['cantd'];
											else
												$CantLe = 0;
											$Lector->mostrarLector($CantLe);
											break;
		case 'Guardar':		$Lector->setCveMarca($_REQUEST['cveMarca']);
											$Lector->setTipo(trim($_REQUEST['tipoLe']));
											$Lector->setDescripcion(trim($_REQUEST['descripcion']));
											$Lector->guardaLector($_REQUEST['cveAct']);
											break;
		case 'Actualiza':	$Lector->setCveMarca($_REQUEST['cveMarca']);
											$Lector->setTipo(trim($_REQUEST['tipoLe']));
											$Lector->setDescripcion(trim($_REQUEST['descripcion']));
											$Lector->setCveLec($_REQUEST['cveLe']);
											//Se requiere la clase de equipoComputo debido a que los objetos se guardan en sesion
											require_once('equipoComputo.class.php');
											session_start();
											$cveAct = $_SESSION['Equipo']->getCveEquipo();
											$Lector->ActualizaLe($cveAct,$_REQUEST['cveLeE']);
											break;
	}
?>