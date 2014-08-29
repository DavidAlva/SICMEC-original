<?
	class usuarios
	{
		private $_db=NULL;
		private $_user="";
		private $_pass="";
		private $_tabla="";
		//constructor SE MANDA BASE DE DATOS, USUARIO, PASSWORD, TABLA Y CAMPO DE TABLA
		function __construct($db,$user,$pass,$tabl){
			$this->_db=$db;
			$this->_user=$user;
			$this->_pass=$pass;
			$this->_tabla=$tabl;
		}
		function valida_usuario(){
			$query = "SELECT NomUsu,CveGrupo FROM ". $this->_tabla ." WHERE NomUsu = '".$this->_user."'";
			$query .= " AND Password= '".$this->_pass."'";
			//echo $query;
			session_start();
			$rs = mysql_query($query,$this->_db);
			if(mysql_num_rows($rs)){
				$registro = mysql_fetch_row($rs);
				$_SESSION["NomUsu"] = $registro[0];
				$_SESSION["CveGrupo"] = $registro[1];
				$_SESSION["Validar"]="OK";
				return true;
			}
			else{
				$_SESSION["Validar"]="NO";
				return false;
			}
			//Si el usuario existe regresa true de lo contrario false
			//return (mysql_num_rows($rs))?true:false;
		}
	}
?>
