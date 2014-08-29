<? 
//Inicio la sesión 
session_start(); 
//COMPRUEBA QUE EL USUARIO ESTA AUTENTIFICADO 
if ($_SESSION["NomUsu"] == "") { 
    //si no existe, envio a la página de autentificacion 
	header("Location: Index.html"); 
    //salgo de este script 
    exit(); 
} 
?> 
