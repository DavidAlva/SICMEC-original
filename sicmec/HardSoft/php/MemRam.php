<?php
include_once('../../../Conexion/conexion.class.php');
class MemoriaRam
{
private $cveMem;
private $cveMarca;
private $capacidad;
private $velocidad;

	function __construct($sCveMarca,$sCapacidad,$sVelocidad){
		if(!empty($sCveMarca))
			$this->cveMarca = $sCveMarca;
		if(!empty($sCapacidad))
			$this->capacidad = $sCapacidad;
		if(!empty($sVelocidad))
			$this->velocidad = $sVelocidad;
	}
	function setCveMem($sCveMem){
		$this->cveMem = $sCveMem;
	}
	function setCveMarca($sCveMarca){
		$this->cveMarca = $sCveMarca;
	}
	function setCapacidad($sCapacidad){
		$this->capacidad = trim($sCapacidad);
	}
	function setVelocidad($sVelocidad){
		$this->velocidad = trim($sVelocidad);
	}
	function mostrarMem($sCant){
		//carga el formulario de Cantidad de Memoria Ram
		echo "<div class='otra'>
			<form method='get' action='' class='formulario' name='cantMeR'>
				<fieldset>
				<legend>Memoria RAM</legend>
					<p><label for=\"cantidad\" class=\"left\">Cantidad</label>
						<input type=\"text\" maxlength=\"2\" size=\"5\" name=\"cantidad\" id='cantidad' />
						<input type=\"button\" name=\"cantdMR\" id=\"cantdMR\" value=\">>\"  class=\"button\" onclick=\"MostrarTabs('php/MainMR.php','Formularios','CantMR');\" />
					</p>
				</fieldset>
			</form>";
			if ($sCant > 0 and $sCant < 5) {
				echo "<form method=\"Post\" action='' class=\"formulario\">
							<fieldset>
							<legend>Memoria RAM</legend>";
				for($i = 0;$i<$sCant;$i++){
					echo "<p><label for=\"MarcaMR\" class=\"left\">Marca</label>
									<select name=\"MarcaMR\" id=\"MarcaMR\" class=\"combo\">";
									$con = new MySqlConnection('sicmec','root','$4bi4n');
									$con->Open();
									$query = "Select idMarca,nombre from Marca order by nombre ASC";
									$result = mysql_query($query,$con->getIdConnection());
									while($campo = mysql_fetch_row($result)){
										echo "<option value='$campo[0]'>$campo[1]</option>";
									}
					echo	"</select>
								</p>
								<p><label for=\"Capacidad\" class=\"left\">Capacidad</label>
								<input type=\"text\" name=\"Capacidad\" id=\"Capacidad\" maxlength=\"3\" size=\"13\" />
								<select name=\"uniCap\" id=\"uniCap\" class=\"combo\" style=\"width:52px;\">
									<option value='MB'>MB</option>
									<option value='KB'>KB</option>
									<option value='GB'>GB</option>
									<option value='TB'>TB</option>
								</select>
								</p>
								<p><label for=\"Velocidad\" class=\"left\">Velocidad</label>
								<input type=\"text\" name=\"Velocidad\" id=\"Velocidad\" maxlength=\"5\" size=\"13\" />
								<select name=\"uniVel\" id=\"uniVel\" class=\"combo\" style=\"width:52px;\">
									<option value='Mhz'>Mhz</option>
									<option value='Khz'>Khz</option>
									<option value='Ghz'>GHz</option>
								</select>
							</p>";
				}
				echo "<p><input type=\"button\" name=\"cantdMR\" id=\"cantdMR\" value=\"Guardar\" class=\"button\" onclick='guarda(\"php/MainMR.php\",\"Formularios\")' /></p>
							</fieldset>
							</form>";
			}
		echo "</div>";
	}
	function guardaMemoria($cveEquipo,$uCap,$uVel){
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
	 		foreach($cveAct as $equipo){
	 			//Para cada marca necesitamos insertar en la base de datos la memoria
	 			$x = 0;
	 			foreach($marca as $cveMarc){
	 				$query = "Insert into MemRam (idMRam,cveAct,idMarca,capacidad,velocidad) values(null,$equipo,";
	 				$query .= $cveMarc . ",'" . $capaci[$x] . " " . $uCapac[$x] . "','" . $veloci[$x];
	 				$query .= " " . $uVeloc[$x] . "') on duplicate key update ";
	 				$query .= "idMarca = " .$cveMarc . ", capacidad = '" . $capaci[$x] . " " . $uCapac[$x]. "'";
	 				$query .= ", velocidad = '" . $veloci[$x] . " " . $uVeloc[$x] . "'";
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
	function ActualizaMR($cveEquipo,$uCap,$uVel,$cveMemE){
		if(empty($cveEquipo)){
	 	$this->Mensaje('error');
	 	exit();
	 }
	 else{
	 	$con = new MySqlConnection('sicmec','root','$4bi4n');
	 	$con->Open();
	 	if($con->isOpenCon()){
	 		//Preparar el array de $cveMR de la siguiente forma 1,2,3,4
	 		$cveMemR = explode('|',$this->cveMem);
	 		//Preparar el array para cveMarca
	 		$marca = explode('|',$this->cveMarca);
	 		//Preparar el array para capacidad
	 		$capaci = explode('|',$this->capacidad);
	 		//Preparar el array para velocidad
	 		$veloci = explode('|',$this->velocidad);
	 		//Separamos las unidades de capacidad y velocidad
	 		$uCapac = explode('|',$uCap);
	 		$uVeloc = explode('|',$uVel);
	 		//Obtener las memorias a eliminar
	 		$cveMEli = explode('|',$cveMemE);
	 		$x = 0;
	 		foreach($cveMemR as $memoria){
	 			$query = "";
	 			//Elegir si actualizar o eliminar
	 			foreach($cveMEli as $memElimina){
	 				if($memoria == $memElimina)
	 					$query = "Delete from MemRam where cveAct = " . $cveEquipo . " and idMRam = " . $memoria;
	 			}
	 			if($query == ""){
	 				//Para cada marca necesitamos insertar en la base de datos la memoria
	 				$query = "Update MemRam Set idMarca = " . $marca[$x] . ", capacidad = '" . $capaci[$x] . " ";
	 				$query .= $uCapac[$x]. "', velocidad = '" . $veloci[$x] . " " . $uVeloc[$x] . "'";
	 				$query .= "where cveAct = " . $cveEquipo . " and idMRam = " . $memoria;
	 			}
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