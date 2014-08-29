<?php
session_start();
require_once('../Connections/conexion.class.php');
require_once('usuarios.class.php');

	$usuario = $_REQUEST["NomUsu"];
	$pass = $_REQUEST["Password"];
	$tabl = 'personal'; //$_REQUEST["tabla"];
	//Pagina en caso de que si sea correcta la autentificacion
	$pag = "../intro.php";//$_REQUEST["paginair"];
	//$bd = $_REQUEST["bd"];
	$con = new MySqlConnection('localhost','root','1111');
	$con->Open();
	$user= new usuarios($con->getIdConnection(),$usuario,$pass,$tabl);
	if($user->valida_usuario()){
		$con->closeCon();
		   header("Location: $pag");

	}else
	{
		//Pagina en caso de que el usuario o password sean incorrectos
		$con->closeCon();
		$pag = $_REQUEST["paginaReg"];
		header("Location: $pag");
	}

?>
