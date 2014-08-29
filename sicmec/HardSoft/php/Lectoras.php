<?php
include_once('../../../Conexion/conexion.class.php');
class Lectoras
{
	private $cveLec;
	private $tipo;
	private $cveMarca;
	private $descripcion;

	function __construct($tip,$marca,$desc){
		if(!empty($tip))
			$this->tipo =$tip;
		if(!empty($marca))
			$this->cveMarca = $marca;
		if(!empty($desc))
			$this->descripcion = $desc;
	}
	function setCveLec($sCveLe){
		$this->cveLec = $sCveLe;
	}
	function setTipo($tipoLe){
		$this->tipo = $tipoLe;
	}
	function setCveMarca($marc){
		$this->cveMarca = $marc;
	}
	function setDescripcion($descri){
		$this->descripcion = $descri;
	}

	function mostrarLector($sCant){
			echo "<div class='TR'>
			<form method='get' action='javascript:MostrarTabs('php/MainLe.php','Formularios','CantLe')' class='formulario' name='cantLe'>
				<fieldset>
				<legend>Lectoras</legend>
					<p><label for=\"cantidad\" class=\"left\">Cantidad</label>
						<input type=\"text\" maxlength=\"2\" size=\"5\" name=\"cantidad\" id='cantidad'/>
						<input type=\"button\" name=\"bcantdTR\" id=\"bcantdTR\" value=\">>\"  class=\"button\" onclick=\"MostrarTabs('php/MainLe.php','Formularios','CantLe')\" />
					</p>
				</fieldset>
			</form>";
			if ($sCant > 0 and $sCant < 4) {
				echo "<form method=\"get\" action='' class=\"formulario\">
							<fieldset>
							<legend>Lectoras</legend>";
				for($i = 0;$i<$sCant;$i++){
					echo "<p><label for=\"tipoLe\" class=\"left\">Tipo Lector</label>
								<select name=\"tipoLe\" id=\"tipoLe\" class=\"combo\" >
									<option value='DVD Combo'>DVD Combo</option>
									<option value='DVD'>DVD</option>
									<option value='DVD-RW Combo'>DVD-RW Combo</option>
									<option value='CD'>CD</option>
									<option value='CD-RW'>CD-RW</option>
								</select>
								</p>
								<p><label for=\"MarcaLe\" class=\"left\">Marca</label>
									<select name=\"MarcaLe\" id=\"MarcaLe\" class=\"combo\">";
										$con = new MySqlConnection('sicmec','root','$4bi4n');
										$con->Open();
										$query = "Select idMarca,nombre from Marca order by nombre ASC";
										$result = mysql_query($query,$con->getIdConnection());
										while($campo = mysql_fetch_row($result)){
											echo "<option value='$campo[0]'>$campo[1]</option>";
										}
					echo		"</select>
								</p>
								<p><label for=\"descLe\" class=\"left\">Descripci&oacute;n</label>
								<textarea name=\"descLe\" id=\"descLe\" class=\"textarea\" cols='45' rows='10' ></textarea>
								</p>";
				}
				echo "<p><input type=\"submit\" name=\"regTR\" id=\"regTR\" value=\"Guardar\" class=\"button\" onclick='guarda(\"php/MainLe.php\",\"Formularios\")' /></p>
							</fieldset>
							</form>";
			}
		echo "</div>";
	}
	function guardaLector($cveEquipo){
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
	 		$tipoLector = explode('|',$this->tipo);
	 		//Preparar el array para velocidad
	 		$descrip = explode('|',$this->descripcion);
	 		foreach($cveAct as $equipo){
	 			//Para cada marca necesitamos insertar en la base de datos la memoria
	 			$x = 0;
	 			foreach($marca as $cveMarc){
	 				$query = "Insert into Lectoras (idLect,cveAct,idMarca,tipo,descripcion) values(null,$equipo,";
	 				$query .= $cveMarc . ",'" . $tipoLector[$x] . "','" . $descrip[$x] . "'";
	 				$query .= ") on duplicate key update ";
	 				$query .= "idMarca = " .$cveMarc . ", tipo = '" . $tipoLector[$x] . "'";
	 				$query .= ", descripcion = '" . $descrip[$x] . "'";
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
	function ActualizaLe($cveEquipo,$cveLeE){
		if(empty($cveEquipo)){
	 		$this->Mensaje('error');
	 		exit();
		 }
	 	else{
	 		$con = new MySqlConnection('sicmec','root','$4bi4n');
	 		$con->Open();
	 		if($con->isOpenCon()){
	 		//Preparar el array de $cveEquipo de la siguiente forma 1,2,3,4
	 		$cveLe = explode('|',$this->cveLec);
	 		//Preparar el array para cveMarca
	 		$marca = explode('|',$this->cveMarca);
	 		//Preparar el array para capacidad
	 		$tipoLector = explode('|',$this->tipo);
	 		//Preparar el array para velocidad
	 		$descrip = explode('|',$this->descripcion);
	 		//Obtener las memorias a eliminar
	 		$cveLEli = explode('|',$cveLeE);
	 		$x = 0;
	 		foreach($cveLe as $lector){
	 				$query = "";
	 				//Elegir si actualizar o eliminar
	 				foreach($cveLEli as $lecElimina){
	 					if($lector == $lecElimina)
	 						$query = "Delete from Lectoras where cveAct = " . $cveEquipo . " and idLect = " . $lector;
	 				}
	 				if($query == ""){
	 					$query = "Update Lectoras set idMarca = " .$marca[$x] . ", tipo = '" . $tipoLector[$x] . "'";
	 					$query .= ", descripcion = '" . $descrip[$x] . "' where cveAct = " . $cveEquipo . " and ";
	 					$query .= "idLect = " . $lector;
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