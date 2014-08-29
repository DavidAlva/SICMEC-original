<?
	session_start();
	session_destroy();
	$pagir = $_REQUEST["paginair"];
	header("Location: $pagir");
?>
