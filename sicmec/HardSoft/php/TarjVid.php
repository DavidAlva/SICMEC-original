<?php
include_once('../../../Conexion/conexion.class.php');
class TVideo
{
	private $cveTV;
	private $cveMarca;
	private $descripcion;

	function __construct($marca,$des){
		if(!empty($marca))
			$this->cveMarca = $marca;
		if(!empty($des))
			$this->descripcion = $des;
	}
	function setCveTV($sCveTV){
		$this->cveTV = $sCveTV;
	}
	function setCveMarca($marc){
		$this->cveMarca = $marc;
	}
	function setDescripcion($descp){
		$this->descripcion = $descp;
	}
	function mostrarTV($sCant){
		echo "<div class='TR'>
			<form method='get' action='' class='formulario' name='cantTV'>
				<fieldset>
				<legend>Tarjeta de Video</legend>
					<p><label for=\"cantidad\" class=\"left\">Cantidad</label>
						<input type=\"text\" maxlength=\"2\" size=\"5\" name=\"cantidad\" id='cantidad'/>
						<input type=\"button\" name=\"bcantdTR\" id=\"bcantdTR\" value=\">>\"  class=\"button\" onclick=\"MostrarTabs('php/MainTV.php','Formularios','CantTV');\" />
					</p>
				</fieldset>
			</form>";
			if ($sCant > 0 and $sCant < 3) {
				echo "<form method=\"get\" action='' class=\"formulario\">
							<fieldset>
							<legend>Tarjetas de Video</legend>";
				for($i = 0;$i<$sCant;$i++){
					echo "<p><label for=\"MarcaTV\" class=\"left\">Marca</label>
									<select name=\"MarcaTV\" id=\"MarcaTV\" class=\"combo\">";
										$con = new MySqlConnection('sicmec','root','$4bi4n');
										$con->Open();
										$query = "Select idMarca,nombre from Marca order by nombre ASC";
										$result = mysql_query($query,$con->getIdConnection());
										while($campo = mysql_fetch_row($result)){
											echo "<option value='$campo[0]'>$campo[1]</option>";
										}
					echo		"</select>
								</p>
								<p><label for=\"descTV\" class=\"left\">Descripci&oacute;n</label>
								<textarea name=\"descTV\" id=\"descTV\" class=\"textarea\" cols='45' rows='10' ></textarea>
								</p>";
				}
				echo "<p><input type=\"button\" name=\"regTV\" id=\"regTV\" value=\"Guardar\" class=\"button\" onclick='guarda(\"php/MainTV.php\",\"Formularios\")' /></p>
							</fieldset>
							</form>";
			}
		echo "</div>";

	}
	function guardarTV($cveEquipo){
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
	 		$descrip = explode('|',$this->descripcion);
	 		foreach($cveAct as $equipo){
	 			//Para cada marca necesitamos insertar en la base de datos la memoria
	 			$x = 0;
	 			foreach($marca as $cveMarc){
	 				$query = "Insert into TarjVideo (idTV,cveAct,idMarca,descripcion) values(null,$equipo,";
	 				$query .= $cveMarc . ",'" . $descrip[$x] . "') on duplicate key update ";
	 				$query .= "idMarca = " .$cveMarc . ", descripcion = '" . $descrip[$x] . "'";
	 				$result = mysql_query($query,$con->getIdConnection());
	 				$con->closeCon();
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
	function ActualizaTV($cveEquipo,$cveTVE){
		if(empty($cveEquipo)){
	 	$this->Mensaje('error');
	 	exit();
	 }
	 else{
	 	$con = new MySqlConnection('sicmec','root','$4bi4n');
	 	$con->Open();
	 	if($con->isOpenCon()){
	 		//Preparar el array de $cveEquipo de la siguiente forma 1,2,3,4
	 		$cveTVi = explode('|',$this->cveTV);
	 		//Preparar el array para cveMarca
	 		$marca = explode('|',$this->cveMarca);
	 		$descrip = explode('|',$this->descripcion);
	 		$cveTvEl = explode('|',$cveTVE);
	 		$x = 0;
	 		foreach($cveTVi as $video){
	 			//Para cada marca necesitamos insertar en la base de datos la memoria
	 			$query = "";
	 			foreach($cveTvEl as $vidEli){
	 				if($video == $vidEli)
	 					$query = "Delete from TarjVideo where cveAct = " . $cveEquipo . " and idTV = " . $video;
	 			}
	 			if($query == ""){
	 				$query = "Update TarjVideo set idMarca = " .$marca[$x] . ", descripcion = '" . $descrip[$x] . "' ";
	 				$query .= "where cveAct = " . $cveEquipo . " and idTV = " . $video;
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