<?php
include_once('../../../Conexion/conexion.class.php');
class TarjetaMadre
{
	private $cveTarjMad;
	private $cveMarca;
	private $descripcion;


	function __construct($CveTM,$CveMar,$Desc)
	{
		if(!empty($CveTM))
			$this->cveTarjMad = $CveTM;
		if(!empty($CveMar))
			$this->cveMarca = $CveMar;
		if(!empty($Desc))
			$this->descripcion = $Desc;
	}
	function setCveMarca($marca){
		$this->cveMarca = $marca;
	}
	function setDescripcion($des){
		$this->descripcion = $des;
	}

	function mostrarTabla(){
		echo "<div class=\"tarjeta madre\">
						<form method=\"post\" action=\"\" class=\"formulario\">
							<fieldset>
							<legend>Tarjeta Madre</legend>
							<p><label for=\"marca\" class=\"left\">Marca</label>
								<select id=\"marca\" name=\"marca\" class=\"combo\">";
								$con = new MySqlConnection('sicmec','root','$4bi4n');
								$con->Open();
								$query = "Select idMarca,nombre from Marca order by nombre ASC";
								$result = mysql_query($query,$con->getIdConnection());
								$con->closeCon();
								while($campo = mysql_fetch_row($result)){
									echo "<option value='$campo[0]'>$campo[1]</option>";
								}
		echo	"			</select>
							</p>
							<p>
								<label for=\"descripcion\" class=\"left\">Descripci&oacute;n</label>
								<textarea name=\"descripcion\" id=\"descripcion\" cols=\"45\" rows=\"10\"></textarea>
							</p>
							<p><input type=\"submit\" name=\"gTM\" id=\"gTM\" value=\"Guardar\" class=\"button\" onclick='guarda(\"php/MainTM.php\",\"Formularios\")' />
							</p>
							</fieldset>
						</form>
					</div>";
	}
	function guardaEquipo($cveEquipo){
	 if(empty($cveEquipo)){
	 	$this->Mensaje('error');
	 	exit();
	 }
	 else{
	 	$con = new MySqlConnection('sicmec','root','$4bi4n');
	 	$con->Open();
	 	if($con->isOpenCon()){
	 		//Preparar el array de $cveEquipo de la siguiente forma 1,2,3,4
	 		/*$query = "Select count(cveAct) from TarjMadre where cveAct IN ($cveEquipo)";
	 		$result = mysql_query($query,$con->getIdConnection());
	 		//Si es mayor a 0 hay que actualizar
	 		if($result>0){
	 			$query = "Update TarjMadre set idMarca = " . $this->cveMarca . ",Descripcion = '" . $this->descripcion . "'";
	 		}
	 		else{*/
	 		$cveAct = explode('|',$cveEquipo);
	 		foreach($cveAct as $equipo){
	 			$query = "Insert into TarjMadre (idTM,cveAct,idMarca,descripcion) values(null,$equipo,";
	 			$query .= $this->cveMarca . ",'" . $this->descripcion ."') on duplicate key update idMarca = ";
	 			$query .= $this->cveMarca . ", descripcion = '" . $this->descripcion . "'";
	 			$result = mysql_query($query,$con->getIdConnection());
	 			if($result)
	 				$this->Mensaje('ok');
	 			else
	 				$this->Mensaje('error');
	 		}
	 	$con->closeCon();
	 	}
	 }

	}
	private function Mensaje($tipo){
		if($tipo == 'ok'){
			echo "<div class=\"formulario\">
	 					<p class='ok'>Se actualizar&oacute;n correctamente los equipos</p>
	 				</div>";
		}
		else{
		echo "<div class=\"formulario\">
	 					<p class='error'>No se actualiz&oacute; alg&uacute;n equipo</p>
	 				</div>";
		}
	}
}
?>