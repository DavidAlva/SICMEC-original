<?php
require_once('../Connections/conexion.class.php');
if(!empty($_REQUEST['pass'])){
	$Oldpass = trim($_REQUEST['pass']);
	$con = new MySqlConnection('sicmec','root','');
	$con->Open();
	if($con->isOpenCon()){
		//Checar que el usuario sea correcto
		$Upass = strtoupper($Oldpass);
		session_start();
		$query = "Select Nombre from personal where NomUsu = '". $_SESSION["NomUsu"]."' and Password = '". $Upass . "'";
		$res = mysql_query($query,$con->getIdConnection());
		if(mysql_num_rows($res)){
			//El password es correcto
			echo "";
		}
		else{
			//Password incorrecto
			echo "<p class='error'>Password incorrecto</p>";
		}
	}
	$con->closeCon();
}
?>
