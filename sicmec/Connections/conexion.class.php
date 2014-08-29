<?php
class MySqlConnection
{
	private $isOpen;
	private $hostname;
	private $database;
	private $username;
	private $password;
	//var $timeout;
	private $connectionId;

	//function MySqlConnection($ConnectionString, $Timeout, $Host, $DB, $UID, $Pwd)

	function __construct($DB, $UID, $Pwd)
	{
		$this->isOpen = false;
		//$this->timeout = $Timeout;

	/*	if( $Host ) {
			$this->hostname = $Host;
		}// Funcion ereg para comprobar si una cadena contiene cierto tipo y numero de caracteres
		elseif( ereg("host=([^;]+);", $ConnectionString, $ret) )  {
			$this->hostname = $ret[1];
		}
		*/
		if( $DB ) {
			$this->database = $DB;
		}/*
		elseif( ereg("db=([^;]+);",   $ConnectionString, $ret) ) {
			$this->database = $ret[1];
		}*/

		if( $UID ) {
			$this->username = $UID;
		}/*
		elseif( ereg("uid=([^;]+);",  $ConnectionString, $ret) ) {
			$this->username = $ret[1];
		}
		*/
		if( $Pwd ) {
			$this->password = $Pwd;
		}/*
		elseif( ereg("pwd=([^;]+);",  $ConnectionString, $ret) ) {
			$this->password = $ret[1];
		}*/
	}

	function Open()
	{
		// if ($this->connectionId = mysql_connect($this->hostname, $this->username, $this->password) or die(mysql_error()))
	    if ($this->connectionId = mysql_connect($this->hostname, $this->username, $this->password))
		{
			$this->isOpen = ($this->database == "") ? true : mysql_select_db($this->database, $this->connectionId);
		}
		else
		{
           // Mandar mensaje de error

		   $error_message = mysql_error() ;

			 if ( $error_message == "" ){
				$error_message = "Imposible establecer la conexion a " . $this.hostname ;
			 }

            // echo("<ERRORS><ERROR><DESCRIPTION>" . $error_message . "</DESCRIPTION></ERROR></ERRORS>");

			 $this->isOpen = false;
		}


	}
	function getIdConnection()
	{
		return $this->connectionId;
	}
	function isOpenCon(){
		return $this->isOpen;
	}

	function closeCon(){
		if (is_resource($this->connectionId) && $this->isOpen)
		{
			if (mysql_close($this->connectionId))
			{
				$this->isOpen = false;
				unset($this->connectionId);
			}
		}
	}
}
?>