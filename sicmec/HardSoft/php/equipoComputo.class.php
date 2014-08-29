<?php
require_once('../../../Conexion/conexion.class.php');
class EquipoComputo{
	private $cveEquipo;
	private $cveCatalogo;
	private $numInventar;
	private $annio;
	private $result;

	function __construct($cvEqu,$cveCat,$numIn,$ann){
		if (!empty($cvEqu))
			$this->cveEquipo = $cvEqu;
		if (!empty($cveCat))
			$this->cveCatalogo = $cveCat;
		if (!empty($numIn))
			$this->numInventar = $numIn;
		if (!empty($ann))
			$this->annio = $ann;
	}
	function getCveEquipo(){
		return $this->cveEquipo;
	}
	//Polimorfismo de acuerdo a la cantidad de datos enviados a la consulta
	function consultaEquipo(){
		$con = new MySqlConnection('sicmec','root','$4bi4n');
		$con->Open();
		//if ($con->isOpenCon()){
		if ($this->cveCatalogo != "Todos")
			$where[] = " CveCatalogo = '" . $this->cveCatalogo . "' ";
		else
			$where[] = " CveCatalogo in ('I180000012','I180000064','I180000096','I180000116','I180000156','I180000220')";
		if (!empty($this->numInventar))
			$where[] = " NumInv = " . $this->numInventar . " ";
		if (!empty($this->annio))
			$where[] = " AnnoAlta = " . $this->annio . " ";

		/*foreach($where as $val){
		//Concatenamos 2 variables es mas rapido {} que .
			$strQ = "{$strQ}{$val}";
			//agregamos la palabra and en caso de que sea mas de una busqueda
			if(end($where) != $val)
				$strQ = $strQ ." and ";
		}*/
		if (empty($where))
			$strQ = "";
		else{
			//Mezclar el array where y agregar la palabra and entre cada uno
			$strQ = implode(' and ',$where);
			$aux = " where " . $strQ;
			$strQ = $aux;
		}
		$query = "Select CveAct,CveCatalogo,NumInv, CaractAcf from actfijo " . $strQ;
		$this->result = mysql_query($query,$con->getIdConnection()) or die(mysql_error());
		$con->closeCon();
		//}
		if (!$this->result)
			return false;
		else
		 	return $this->result;
	}
	function consTarjMadre(){
		$con = new MySqlConnection('sicmec','root','$4bi4n');
		$con->Open();
		//$strQ = implode(',',$cveAct);
		/*Select a.CveAct,a.CveCatalogo,a.NumInv, a.CaractAcf, m.nombre, h.capacidad, m.nombre, mr.capacidad,m.nombre, le.tipo from actfijo a join HDD h on a.CveAct = h.cveAct join MemRam mr on a.CveAct = mr.cveAct join Marca m on le.idMarca = m.idMarca  */
		$query = "Select idMarca, descripcion from TarjMadre where cveAct =" . $this->cveEquipo ;
		$this->result = mysql_query($query,$con->getIdConnection()) or die(mysql_error());
		$con->closeCon();
		//}
		if (!$this->result)
			return false;
		else
		 	return $this->result;
	}
	function consHDD(){
		$con = new MySqlConnection('sicmec','root','$4bi4n');
		$con->Open();
		$query = "Select idMarca, capacidad, velocidad, conexion, idHDD from HDD where cveAct =" . $this->cveEquipo;
		$this->result = mysql_query($query,$con->getIdConnection()) or die(mysql_error());
		$con->closeCon();
		if (!$this->result)
			return false;
		else
		 	return $this->result;
	}
	function consMemRam(){
		$con = new MySqlConnection('sicmec','root','$4bi4n');
		$con->Open();
		//$strQ = implode(',',$cveAct);
		$query = "Select idMarca, capacidad, velocidad, idMRam from MemRam where cveAct =" . $this->cveEquipo ;
		$this->result = mysql_query($query,$con->getIdConnection()) or die(mysql_error());
		$con->closeCon();
		if (!$this->result)
			return false;
		else
		 	return $this->result;
	}
	function consLectoras(){
		$con = new MySqlConnection('sicmec','root','$4bi4n');
		$con->Open();
		$query = "Select idMarca, tipo, descripcion, idLect from Lectoras where cveAct =" . $this->cveEquipo;
		$this->result = mysql_query($query,$con->getIdConnection()) or die(mysql_error());
		$con->closeCon();
		if (!$this->result)
			return false;
		else
		 	return $this->result;
	}
	function consTarRed(){
		$con = new MySqlConnection('sicmec','root','$4bi4n');
		$con->Open();
		$query = "Select idMarca, conexion, tipo, velocidad, idTR from TarjRed where cveAct = " . $this->cveEquipo;
		$this->result = mysql_query($query,$con->getIdConnection()) or die(mysql_error());
		$con->closeCon();
		if (!$this->result)
			return false;
		else
		 	return $this->result;
	}
	function consTarVid(){
		$con = new MySqlConnection('sicmec','root','$4bi4n');
		$con->Open();
		$query = "Select idMarca, descripcion, idTV from TarjVideo where cveAct =" . $this->cveEquipo;
		$this->result = mysql_query($query,$con->getIdConnection()) or die(mysql_error());
		$con->closeCon();
		if (!$this->result)
			return false;
		else
		 	return $this->result;
	}
	function consSoftware(){
		$con = new MySqlConnection('sicmec','root','$4bi4n');
		$con->Open();
		$query = "Select idSo, descripcion from Software where cveAct =" . $this->cveEquipo;
		$this->result = mysql_query($query,$con->getIdConnection()) or die(mysql_error());
		$con->closeCon();
		if (!$this->result)
			return false;
		else
		 	return $this->result;
	}
	function consulta($cveAct,$query){
		$con = new MySqlConnection('sicmec','root','$4bi4n');
		$con->Open();
		//En caso de ser array hacemos una consulta con IN de lo contrario con =
		if(is_array($cveAct)){
			$strQ = implode(',',$cveAct);
			$strQ .= ")";
		}
		else
			$strQ = $cveAct;
		$query .= $strQ;
		$this->result = mysql_query($query,$con->getIdConnection()) or die(mysql_error());
		$con->closeCon();
		//}
		if (!$this->result)
			return false;
		else
		 	return $this->result;
	}
}
?>