<? 
//Inicio la sesi�n 
session_start(); 
//COMPRUEBA QUE EL USUARIO ESTA AUTENTIFICADO 
if ($_SESSION["NomUsu"] == "") { 
    //si no existe, envio a la p�gina de autentificacion 
	header("Location: Index.html"); 
    //salgo de este script 
    exit(); 
} 
?> 
