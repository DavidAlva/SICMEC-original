<?php
require_once('../Connections/conexion.class.php');
if(!empty($_REQUEST['pass'])){
	$Pass = trim($_REQUEST['pass']);
	$ArrPas = explode('|',$Pass);
	$con = new MySqlConnection('sicmec','root','');
	$con->Open();
	if($con->isOpenCon()){
		//Checar que el usuario sea correcto $ArrPas[0] tiene oldpass
		$Upass = strtoupper($ArrPas[0]);
		$Npass = strtoupper($ArrPas[1]);
		session_start();
		$query = "Select Nombre from personal where NomUsu = '". $_SESSION["NomUsu"]."' and Password = '". $Upass . "'";
		$res = mysql_query($query,$con->getIdConnection());
		if(mysql_num_rows($res)){
			//El password es correcto
			$query = "Update personal set Password = '".$Npass."' where NomUsu = '".$_SESSION["NomUsu"]."'";
			$res = mysql_query($query,$con->getIdConnection());
			if($res)
				echo "<p class='ok'>Su Password fue modificado</p>";
			else
				echo "<p class='error'>Ocurri&oacute; un error al intentar modificar su Password</p>";

		}
		else{
			//Password incorrecto
			echo "<p class='error'>Favor de introducir su Password correcto</p>";
		}
	}
}
else{
	echo "<p class='error'>Verifique sus Password</p>";
}
?>