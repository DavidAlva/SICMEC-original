<?php
//Generador de password
class genpass{
	var $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz234567890";
	var $carac = "";
	var $cad = "";
	function __construct($nocaract){
		$this->carac= explode("\xff" , chunk_split( $this->str, 1, "\xff" ));
		srand (time());
		shuffle($this->carac);
		$this->cad="";
		for ($i=0;$i<$nocaract;$i++)
   		$this->cad.=$this->carac[$i];
	}

	function getpass(){
		return $this->cad;
	}
}
?>