<?php
include_once('../../../Conexion/conexion.class.php');
class Red
{
	private $cveTRed;
	private $cveMarca;
	private $tipo;
	private $conexion;
	private $velocidad;

	function __construct($marca,$tip,$conx,$vel){
		if(!empty($marca))
			$this->cveMarca = $marca;
		if(!empty($tip))
			$this->tipo = $tip;
		if(!empty($conx))
			$this->conexion = $conx;
		if(!empty($vel))
			$this->velocidad = $vel;
	}
	function setCveTRed($sCveTR){
		$this->cveTRed = $sCveTR;
	}
	function setCveMarca($marc){
		$this->cveMarca = $marc;
	}
	function setTipo($tipoTR){
		$this->tipo = $tipoTR;
	}
	function setVelocidad($veloc){
		$this->velocidad = $veloc;
	}
	function setConexion($conex){
		$this->conexion = $conex;
	}

	function mostrarTR($sCant){
		echo "<div class='TR'>
			<form method='get' action='' class='formulario' name='cantTR'>
				<fieldset>
				<legend>Tarjeta de Red</legend>
					<p><label for=\"cantidad\" class=\"left\">Cantidad</label>
						<input type=\"text\" maxlength=\"2\" size=\"5\" name=\"cantidad\" id='cantidad'/>
						<input type=\"button\" name=\"bcantdTR\" id=\"bcantdTR\" value=\">>\"  class=\"button\" onclick=\"MostrarTabs('php/MainTR.php','Formularios','CantTR');\" />
					</p>
				</fieldset>
			</form>";
			if ($sCant > 0 and $sCant < 3) {
				echo "<form method=\"get\" action='' class=\"formulario\">
							<fieldset>
							<legend>Tarjeta de Red</legend>";
				for($i = 0;$i<$sCant;$i++){
					echo "<p><label for=\"MarcaTR\" class=\"left\">Marca</label>
									<select name=\"MarcaTR\" id=\"MarcaTR\" class=\"combo\">";
										$con = new MySqlConnection('sicmec','root','$4bi4n');
										$con->Open();
										$query = "Select idMarca,nombre from Marca order by nombre ASC";
										$result = mysql_query($query,$con->getIdConnection());
										while($campo = mysql_fetch_row($result)){
											echo "<option value='$campo[0]'>$campo[1]</option>";
										}
					echo		"</select>
								</p>
								<p><label for=\"conTR\" class=\"left\">Conexi&oacute;n</label>
								<select name=\"conTR\" id=\"conTR\" class=\"combo\" >
									<option value='inalambrica'>Inal&aacute;mbrica</option>
									<option value='alambrica'>Al&aacute;mbrica</option>
								</select>
								</p>
								<p><label for=\"tipConTR\" class=\"left\">Tipo Conexi&oacute;n</label>
								<select name=\"tipConTR\" id=\"tipConTR\" class=\"combo\" style=\"width:100px;\">
									<option value='b/g'>b/g</option>
									<option value='a'>a</option>
									<option value='b'>b</option>
									<option value='g'>g</option>
									<option value='a/b/g'>a/b/g</option>
									<option value='ethernet'>Ethernet</option>
								</select>
								</p>
								<p><label for=\"VelTR\" class=\"left\">Velocidad</label>
								<input type=\"text\" name=\"VelTR\" id=\"VelTR\" maxlength=\"5\" size=\"13\" />
								<select name=\"uniVel\" id=\"uniVel\" class=\"combo\" style=\"width:52px;\">
									<option value='Mbps'>Mbps</option>
									<option value='Kbps'>Kbps</option>
									<option value='Gbps'>Gbps</option>
								</select>
							</p>";
				}
				echo "<p><input type=\"submit\" name=\"regTR\" id=\"regTR\" value=\"Guardar\" class=\"button\" onclick='guarda(\"php/MainTR.php\",\"Formularios\")' /></p>
							</fieldset>
							</form>";
			}
		echo "</div>";

	}
	function guardaTarRed($cveEquipo,$unVel){
		if(empty($cveEquipo)){
	 		$this->Mensaje('error');
	 		exit();
		 }
	 	else{
	 		$con = new MySqlConnection('sicmec','root','$4bi4n');
	 		$con->Open();
	 		if($con->isOpenCon()){
	 		//Preparar el array de $cveEquipo de la siguiente forma 1,2,3,4
	 		$cveAct = explode('|',$cveEquipo);
	 		//Preparar el array para cveMarca
	 		$marca = explode('|',$this->cveMarca);
	 		//Preparar el array para capacidad
	 		$tipoTR = explode('|',$this->tipo);
	 		//Preparar el array para velocidad
	 		$conexx = explode('|',$this->conexion);
	 		//Preparar el array para velocidad
	 		$veloci = explode('|',$this->velocidad);
	 		$uVel = explode('|',$unVel);
	 		foreach($cveAct as $equipo){
	 			//Para cada marca necesitamos insertar en la base de datos la memoria
	 			$x = 0;
	 			foreach($marca as $cveMarc){
	 				$query = "Insert into TarjRed (idTR,cveAct,idMarca,conexion,tipo,velocidad) values(null,$equipo,";
	 				$query .= $cveMarc . ",'" . $conexx[$x] . "','" . $tipoTR[$x] . "','" . $veloci[$x] . " ";
	 				$query .= $uVel[$x] . "') on duplicate key update ";
	 				$query .= "idMarca = " .$cveMarc . ", conexion = '" . $conexx[$x] . "'";
	 				$query .= ", tipo = '" . $tipoTR[$x] . "', velocidad = '" .$veloci[$x] . " " . $uVel[$x] . "'";
	 				$result = mysql_query($query,$con->getIdConnection());
	 				if($result)
	 					$this->Mensaje('ok');
	 				else
	 					$this->Mensaje('error');
	 				$x++;
	 			}
	 		}
	 	$con->closeCon();
	 	}
	 }
	}
	function ActualizaTR($cveEquipo,$unVel,$cveTrE){
		if(empty($cveEquipo)){
	 		$this->Mensaje('error');
	 		exit();
		 }
	 	else{
	 		$con = new MySqlConnection('sicmec','root','$4bi4n');
	 		$con->Open();
	 		if($con->isOpenCon()){
	 		//Preparar el array de $cveEquipo de la siguiente forma 1,2,3,4
	 		$cveTR = explode('|',$this->cveTRed);
	 		//Preparar el array para cveMarca
	 		$marca = explode('|',$this->cveMarca);
	 		//Preparar el array para capacidad
	 		$tipoTR = explode('|',$this->tipo);
	 		//Preparar el array para velocidad
	 		$conexx = explode('|',$this->conexion);
	 		//Preparar el array para velocidad
	 		$veloci = explode('|',$this->velocidad);
	 		$uVel = explode('|',$unVel);
	 		$cveTrEl = explode('|',$cveTrE);
	 		$x = 0;
	 		foreach($cveTR as $red){
	 			//Para cada marca necesitamos insertar en la base de datos la memoria
	 			$query = "";
	 			foreach($cveTrEl as $redElim){
	 				if($red == $redElim)
	 					$query = "Delete from TarjRed where cveAct = " . $cveEquipo . " and idTR = " . $red;
	 			}
	 			if($query == ""){
	 				$query = "Update TarjRed set idMarca = " . $marca[$x] . ",conexion = '" . $conexx[$x] . "'";
	 				$query .= ", tipo = '" . $tipoTR[$x] . "', velocidad = '" .$veloci[$x] . " " . $uVel[$x] . "' ";
	 				$query .= "where cveAct = " . $cveEquipo . " and idTR = " . $red;
	 			}
	 			echo $query;
	 				$result = mysql_query($query,$con->getIdConnection());
	 				if($result)
	 					$this->Mensaje('ok');
	 				else
	 					$this->Mensaje('error');
	 				$x++;
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