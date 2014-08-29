<?php
include_once('../../../Conexion/conexion.class.php');
class Software
{
	private $cveSof;
	private $cveSO;
	private $descripcion;

	function __construct($sDesc){
		if(!empty($sDesc))
			$this->descripcion = $sDesc;
	}
	function setCveSof($sCveSof){
		$this->cveSof = $sCveSof;
	}
	function setSisOpe($sCveSO){
		$this->cveSO = $sCveSO;
	}
	function setDescripcion($sDescri){
		$this->descripcion = $sDescri;
	}
	function mostrarSof(){
		echo "<div class='otra'>
			<form method='Post' action='' class='formulario' name='Software'>
				<fieldset>
				<legend>Software</legend>
				<p><label for=\"SO\" class=\"left\">Sis. Operativo</label>
									<select name=\"SO\" id=\"SO\" class=\"combo\">";
									$con = new MySqlConnection('sicmec','root','$4bi4n');
									$con->Open();
									$query = "Select idSo,nombre from SO order by nombre DESC";
									$result = mysql_query($query,$con->getIdConnection());
									$con->closeCon();
									while($campo = mysql_fetch_row($result)){
										echo "<option value='$campo[0]'>$campo[1]</option>";
									}
					echo	"</select>
								</p>
								<p><label for=\"descSO\" class=\"left\">Descripci&oacute;n</label>
								<textarea name=\"descSO\" id=\"descSO\" class=\"textarea\" cols='45' rows='10' ></textarea>
								</p>
								<p><input type=\"button\" name=\"guardSO\" value=\"Guardar\" class=\"button\" onclick='guarda(\"php/MainSO.php\",\"Formularios\")' /></p>
							</fieldset>
							</form>
						</div>";
	}
	function guardaSO($cveEquipo){
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
	 		foreach($cveAct as $equipo){
	 			$query = "Insert into Software (idSof,idSo,cveAct,descripcion) values(null,". $this->cveSO;
	 			$query .= ",$equipo,'" . $this->descripcion ."') on duplicate key update idSo = ";
	 			$query .= $this->cveSO . ", descripcion = '" . $this->descripcion . "'";
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