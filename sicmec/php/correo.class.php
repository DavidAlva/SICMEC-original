<?php
//Clase para el envio de correo

class correo {

   private $titulo_contacto="";
   private $nombre_contacto="";
   private $apellido_contacto="";
   private $ciudad_contacto="";
   private $pais_contacto="";
   private $telefono_contacto="";
   private $email_contacto="";
   private $para_contacto="";
   private $mensaje_contacto="";
   private $tipo="";

		function correo($tipocorreo){
			$this->tipo = $tipocorreo;
		}

   function correocontac($titulo, $nombre, $apellido, $ciudad, $pais, $telefono, $email, $para, $mensaje){
		$this->titulo_contacto = $titulo;
		$this->nombre_contacto = $nombre;
		$this->apellido_contacto = $apellido;
		$this->ciudad_contacto = $ciudad;
		$this->pais_contacto = $pais;
		$this->telefono_contacto = $telefono;
		$this->email_contacto = $email;
		$this->para_contacto = $para;
		$this->mensaje_contacto = $mensaje;
   }

   function correopass($nombre, $usuario, $pass){
		$this->nombre_contacto = $nombre;
		$this->apellido_contacto = $usuario;
		$this->ciudad_contacto = $pass;
   }

   function get_mensaje(){
   	switch($this->tipo){
   		case "../Contacto.php":
															$cuerpo = $this->titulo_contacto;
															$cuerpo .= " " . $this->nombre_contacto . " ";
															$cuerpo .= $this->apellido_contacto . "\n";
															$cuerpo .= "Ciudad: " . $this->ciudad_contacto . "\n";
															$cuerpo .= "Pa&iacute;s :" . $this->pais_contacto . "\n";
															$cuerpo .= "Tel&eacute;fono: " . $this->telefono_contacto . "\n";
															$cuerpo .= "Dice: \n" . $this->mensaje_contacto;
															break;
			case "../RecPass.php":
														$cuerpo = "<html><head>";
									$cuerpo .= "<title>Correo Enviado por INEA Guanajuato</title>";
			$cuerpo .= "<style> .firma {font-size:90%;font-weight:bold;color:rgb(80,80,80);} ";
			$cuerpo .= ".clear-contentunit {clear:both; width:auto; height:0.1em; border:none;";
			$cuerpo .= "background:rgb(210,210,210); color:rgb(210,210,210);}</style>";
			$cuerpo .= "</head>";
			$cuerpo .= "<body style='font-family:verdana,arial,sans-serif;'>";
			$cuerpo .= "<a href='http://guanajuato.inea.gob.mx/'><img src='http://guanajuato.inea.gob.mx/imagenes/inea.jpg' style='float:left'/></a>";
			$cuerpo .= "<h2 style='text-align:center'>INEA Guanajuato</h2>";
			$cuerpo .= "<p>&nbsp;</p><hr class='clear-contentunit' />";
			$cuerpo .= "<h3>Hola " . $this->nombre_contacto . "</h3>";
			$cuerpo .= "<p>Gracias por usar SICMEC INEA Guanajuato.</p>";
			$cuerpo .= "<p>Su password ha cambiado</p>";
			$cuerpo .= "<p>Su nombre de usuario es:<strong> " . $this->apellido_contacto . "</strong></p>";
			$cuerpo .= "<p>Password provisional: <strong>" . $this->ciudad_contacto . "</strong></p>";
			$cuerpo .= "<p>Recuerde una vez que entre a el sistema tendr&aacute; que cambiar su password. ";
			$cuerpo .= "Para realizar este cambio dirijase al menu en la secci&oacute;n de INICIO -> CAMBIAR PASSWORD.</p>";
			$cuerpo .= "<p>Si necesitas m&aacute;s ayuda, cont&aacute;ctanos a: </p>";
			$cuerpo .= "<bloquote>gto1@inea.gob.mx</bloquote>";
			$cuerpo .= "<p>Esperamos que disfrute usando su cuenta!</p>";
			$cuerpo .= "<p>Gracias</p>";
			$cuerpo .= "<p>El equipo de SICMEC INEA Guanajuato</p>";
			$cuerpo .= "<h4>http://guanajuato.inea.gob.mx</h4>";
			$cuerpo .= "<br/><hr class='clear-contentunit' />";
			$cuerpo .= "<p style='font-size:75%;font-weight:bold;'>Para cualquier aclaraci&oacute;n";
			$cuerpo .= " acerca de este tipo de correo";
			$cuerpo .= " favor de contactar con el departamento de inform&aacute;tica de la delegaci&oacute;n</p>";
			$cuerpo .= "<br /><br /><p class='firma'>INEA Delegaci&oacute;n Guanajuato</p>";
			$cuerpo .= "<p class='firma'>Blvd. Adolfo L&oacute;pez Mateos #913 poniente.</p>";
			$cuerpo .= "<p class='firma'>Celaya Guanajuato</p>";
			$cuerpo .= "<p class='firma'>Tel. 01-800-502-0121</p>";
			$cuerpo .= "</body></html>";
															break;
			case "NuevaCta":
															$cuerpo .= "Estimado " . $this->nombre_contacto . " ";
															$cuerpo .= "usted ahora tiene una cuenta en la pagina del INEA Guanajuato \n " ;
															$cuerpo .= "Su nombre de usuario es: " . $this->apellido_contacto . "\n";
															$cuerpo .= "Password provisional: " . $this->ciudad_contacto . "\n";
															$cuerpo .= "Recuerde una vez que entre a el sistema tendrá que cambiar su password.";
															break;
		}
		return $cuerpo;
   }

   function get_headers(){
   	if($this->tipo == "../Contacto.php"){
   		$headers ="From: $this->nombre_contacto <$this->email_contacto>\n";
   		$headers .= "Reply-To: $this->nombre_contacto <$this->email_contacto>\n";
  		$headers .= "Return-Path: $this->nombre_contacto <$this->email_contacto>\n";
  		$headers .= "Message-ID: <".time()."-". $this->email_contacto .">\n";
   		$headers .= "MIME-Version: 1.0\n";
			$headers .= "Content-Type: text/html; charset=iso-8859-1\n\n";
   	}
   	else{
  		$headers ="From: Inea Guanajuato <no-contestar@guanajuato.inea.gob.mx>\n";
   		$headers .= "Reply-To: <no-contestar@guanajuato.inea.gob.mx>\n";
  		$headers .= "Return-Path: <no-contestar@guanajuato.inea.gob.mx>\n";
  		$headers .= "Message-ID: <".time()."-no-contestar@guanajuato.inea.gob.mx>\n";
   		$headers .= "MIME-Version: 1.0\n";
			$headers .= "Content-Type: text/html; charset=iso-8859-1\n\n";
  	}
	return $headers;
   }
}
?>
