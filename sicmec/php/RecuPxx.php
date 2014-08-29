<?php
function MenEnviado($pag){
		?>
		<form name="enviado" action="<?php echo $pag; ?>" method="post">

		<!-- Los parametros enviados: Mensaje indica ke hay un mensaje ke mostrar,
		clase se refiere al tipo de color con CSS que se va a mostrar es OK significa color naranja -->

			<input type="hidden" name="message" value="true">
			<input type="hidden" name="clase" value="ok">
			<input type="hidden" name="texto" value="El mensaje se ha enviado correctamente" >
			<input type="submit" name="enviar" >
		</form>
		<script language="JavaScript">document.enviado.submit();</script>
<?php
	}

	function MenError($MesError,$pag){
		?>
		<form name="error" action="<?php echo $pag; ?>" method="post">
			<!-- Los parametros enviados: Mensaje indica ke hay un mensaje ke mostrar,
			clase se refiere al tipo de color con CSS que se va a mostrar es error significa color rojo -->

			<input type="hidden" name="message" value="true">
			<input type="hidden" name="clase" value="error">
			<input type="hidden" name="texto" value="<?php echo $MesError; ?>">
			<input type="submit" name="enviar" >
		</form>
		<script language="JavaScript">document.error.submit();</script>
		<?php
	}
require_once('genpass.class.php');
require_once('correo.class.php');
require_once('../Connections/conexion.class.php');
//Recuperar pagina de Regreso
$pagina = $_REQUEST['pagina'];
//Recuperar usuario
if(!empty($_REQUEST['User']))
	$Usuario = trim($_REQUEST['User']);
else{
	MenError("Error al enviar el mensaje, el usuario no es v&aacute;lido",$pagina);
	exit();
}
//Recuperar el usuario y su correo
$con = new MySqlConnection('sicmec','root','');
$con->Open();
if($con->isOpenCon()){
	//Checar que el usuario sea correcto
	$query = "Select Nombre, Email from personal where NomUsu = '" . $Usuario . "'";
	$res = mysql_query($query,$con->getIdConnection());
	if(mysql_num_rows($res)){
		//variables para modificar password
		$registro = mysql_fetch_row($res);
		$nombre = trim($registro[0]);
		$para = trim($registro[1]);
		$Newpass = new genpass(6);
		$correo = new correo($pagina);
		$correo->correopass($nombre, $Usuario, $Newpass->getpass());
		$query = "Update personal set Password = '".$Newpass->getpass()."' where NomUsu = '". $Usuario ."'";
		$result = mysql_query($query,$con->getIdConnection());
		if($result){
			//Envio del correo
			if(mail($para,"Su password ha cambiado",$correo->get_mensaje(),$correo->get_headers()))
				MenEnviado($pagina);
			else
				MenError("No se pudo enviar el Mensaje",$pagina);
		}
		else
			MenError("Ocurri&oacute; un error al generar un nuevo Password intente m&aacute;s tarde",$pagina);
	}
	else
		MenError("Usuario no v&aacute;lido",$pagina);
		$con->closeCon();
}
else
	MenError("No se pudo verificar el Usuario",$pagina);
?>