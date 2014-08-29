<?php
include_once('../../../Conexion/conexion.class.php');
class HDD
{
	private $cveHDD;
	private $cveMarca;
	private $capacidad;
	private $velocidad;
	private $conexion;

	function __construct($marca,$cap,$vel,$conex){
		if(!empty($marca))
			$this->cveMarca = $marca;
		if(!empty($cap))
			$this->capacidad = $cap;
		if(!empty($vel))
			$this->velocidad = $vel;
		if(!empty($conex))
			$this->conexion = $conex;
	}
	function setCveHdd($sCveHdd){
		$this->cveHDD = $sCveHdd;
	}
	function setCveMarca($cvemarc){
		$this->cveMarca = $cvemarc;
	}

	function setCapacidad($capac){
		$this->capacidad = $capac;
	}

	function setVelocidad($veloc){
		$this->velocidad = $veloc;
	}

	function setConexion($conec){
		$this->conexion = $conec;
	}

	function mostrarHDD($sCant){
		echo "<div class='HDD'>
			<form method='get' action='' class='formulario' name='cantHDD'>
				<fieldset>
				<legend>Disco Duro</legend>
					<p><label for=\"cantidad\" class=\"left\">Cantidad</label>
						<input type=\"text\" maxlength=\"2\" size=\"5\" name=\"cantidad\" id='cantidad' />
						<input type=\"button\" name=\"bcantdHDD\" id=\"bcantdHDD\" value=\">>\"  class=\"button\" onclick=\"MostrarTabs('php/MainHDD.php','Formularios','CantHDD');\" />
					</p>
				</fieldset>
			</form>";
			if ($sCant > 0 and $sCant < 5) {
				echo "<form method=\"get\" action='' class=\"formulario\">
							<fieldset>
							<legend>Disco Duro</legend>";
				for($i = 0;$i<$sCant;$i++){
					echo "<p><label for=\"MarcaHDD\" class=\"left\">Marca</label>
									<select name=\"MarcaHDD\" id=\"MarcaHDD\" class=\"combo\">";
										$con = new MySqlConnection('sicmec','root','$4bi4n');
										$con->Open();
										$query = "Select idMarca,nombre from Marca order by nombre ASC";
										$result = mysql_query($query,$con->getIdConnection());
										while($campo = mysql_fetch_row($result)){
											echo "<option value='$campo[0]'>$campo[1]</option>";
										}
					echo	 "</select>
								</p>
								<p><label for=\"CapHDD\" class=\"left\">Capacidad</label>
								<input type=\"text\" name=\"CapHDD\" id=\"CapHDD\" maxlength=\"3\" size=\"13\" />
								<select name=\"uniCap\" id=\"uniCap\" class=\"combo\" style=\"width:52px;\">
									<option>GB</option>
									<option>TB</option>
									<option>KB</option>
									<option>MB</option>
								</select>
								</p>
								<p><label for=\"VelHDD\" class=\"left\">Velocidad</label>
								<input type=\"text\" name=\"VelHDD\" id=\"VelHDD\" maxlength=\"5\" size=\"13\" />
								<select name=\"uniVel\" id=\"uniVel\" class=\"combo\" style=\"width:52px;\">
									<option>RPM</option>
								</select>
							</p>
								<p><label for=\"conHDD\" class=\"left\">Conexi&oacute;n</label>
								<select name=\"conHDD\" id=\"conHDD\" class=\"combo\" >
									<option>IDE</option>
									<option>SATA</option>
									<option>SCSI</option>
								</select>
								</p>";
				}
				echo "<p><input type=\"submit\" class=\"button\" value='Guardar' onclick='guarda(\"php/MainHDD.php\",\"Formularios\")'/></p>
							</fieldset>
							</form>";
			}
		echo "</div>";
	}

	function guardaHDD($cveEquipo,$uCap,$uVel){
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
	 		$capaci = explode('|',$this->capacidad);
	 		//Preparar el array para velocidad
	 		$veloci = explode('|',$this->velocidad);
	 		//Separamos las unidades de capacidad y velocidad
	 		$uCapac = explode('|',$uCap);
	 		$uVeloc = explode('|',$uVel);
	 		$conexxion = explode('|',$this->conexion);
	 		foreach($cveAct as $equipo){
	 			//Para cada marca necesitamos insertar en la base de datos la memoria
	 			$x = 0;
	 			foreach($marca as $cveMarc){
	 				$query = "Insert into HDD (idHDD,cveAct,idMarca,capacidad,velocidad,conexion) values(null,";
	 				$query .= $equipo . "," . $cveMarc . ",'" . $capaci[$x] . " " . $uCapac[$x] . "','" . $veloci[$x];
	 				$query .= " " . $uVeloc[$x] . "','" . $conexxion[$x] ."') on duplicate key update ";
	 				$query .= "idMarca = " .$cveMarc . ", capacidad = '" . $capaci[$x] . " " . $uCapac[$x]. "'";
	 				$query .= ", velocidad = '" . $veloci[$x] . " " . $uVeloc[$x] . "', conexion= '" . $conexxion[$x] ."'";
	 				$result = mysql_query($query,$con->getIdConnection());
	 				if($result)
	 					$this->Mensaje('ok');
	 				else
	 					$this->Mensaje('error');
	 				$x++;
	 			}
	 		}
	 	}
	 }
	}
	function ActualizaHDD($cveEquipo,$uCap,$uVel,$cveHddE){
		if(empty($cveEquipo)){
	 	$this->Mensaje('error');
	 	exit();
	 }
	 else{
	 	$con = new MySqlConnection('sicmec','root','$4bi4n');
	 	$con->Open();
	 	if($con->isOpenCon()){
	 		//Preparar el array de $cveHDD de la siguiente forma 1,2,3,4
	 		$cveH = explode('|',$this->cveHDD);
	 		//Preparar el array para cveMarca
	 		$marca = explode('|',$this->cveMarca);
	 		//Preparar el array para capacidad
	 		$capaci = explode('|',$this->capacidad);
	 		//Preparar el array para velocidad
	 		$veloci = explode('|',$this->velocidad);
	 		//Separamos las unidades de capacidad y velocidad
	 		$uCapac = explode('|',$uCap);
	 		$uVeloc = explode('|',$uVel);
	 		$conexxion = explode('|',$this->conexion);
	 		//Obtener los HDD a eliminar
	 		$cveHEli = explode('|',$cveHddE);
	 		$x = 0;
	 		foreach($cveH as $disco){
	 			$query = "";
	 			//Elegir si actualizar o eliminar
	 			foreach($cveHEli as $discoEli){
	 				if($disco == $discoEli)
	 					$query = "Delete from HDD where cveAct = " . $cveEquipo . " and idHDD = " . $disco;
	 			}
	 			if($query == ""){
	 				//Para cada marca necesitamos insertar en la base de datos la memoria
	 				$query = "Update HDD Set idMarca = " . $marca[$x] . ", capacidad = '" . $capaci[$x] . " ";
	 				$query .= $uCapac[$x]. "', velocidad = '" . $veloci[$x] . " " . $uVeloc[$x] . "',";
	 				$query .= "conexion= '" . $conexxion[$x] ."' where cveAct = " . $cveEquipo . " and idHDD = " . $disco;
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