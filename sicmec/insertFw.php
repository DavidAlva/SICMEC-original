<?php 
 require_once('Connections/SICMEC.php'); 
 session_start();
mysql_select_db($database_SICMEC, $SICMEC);
	if ($SICMEC) { //Hay conexion?
		if(trim($_REQUEST["pzaid"]) != ""){
				if(trim($_REQUEST["serieFw"]) !=""){
					if(trim($_REQUEST["iplan1"]) !=""){
						if(trim($_REQUEST["mask1"]) !=""){
							if(trim($_REQUEST["gat1"]) !=""){
								if(trim($_REQUEST["iplan2"]) !=""){
									if(trim($_REQUEST["mask2"]) !=""){
										if(trim($_REQUEST["gat2"]) !=""){
											if(trim($_REQUEST["dirIp1"]) !=""){
												if(trim($_REQUEST["dirIp2"]) !=""){
													$_SESSION["pzaid"] = $_REQUEST["pzaid"];
													$_SESSION["nompza"] = trim($_REQUEST["nompza"]);
													$_SESSION["serieFw"] = trim($_REQUEST["serieFw"]);
													$_SESSION["iplan1"] = trim($_REQUEST["iplan1"]);
													$_SESSION["mask1"] = trim($_REQUEST["mask1"]);
													$_SESSION["gat1"] = trim($_REQUEST["gat1"]);
													$_SESSION["iplan2"] = trim($_REQUEST["iplan2"]);
													$_SESSION["mask2"] = trim($_REQUEST["mask2"]);
													$_SESSION["gat2"] = trim($_REQUEST["gat2"]);
													$_SESSION["dirIp1"] = trim($_REQUEST["dirIp1"]);
													$_SESSION["dirIp2"] = trim($_REQUEST["dirIp2"]);
													//insert values 
													$query = "insert into fw values(NULL,'" . $_SESSION['serieFw'] . "','" . $_SESSION['pzaid'] . "','" .$_SESSION['iplan1'] . "','" . $_SESSION['mask1'] . "','" . $_SESSION['gat1'] . "','" . $_SESSION['iplan2'] . "','" . $_SESSION['mask2'] . "','" . $_SESSION['gat2'] . "','" . $_SESSION['dirIp1'] . "','" . $_SESSION['dirIp2'] ."')";
/*	INSERT INTO `fw`.`fw` (
`Id` ,
`CveFw` ,
`CveAds` ,
`IpLan1` ,
`MaskLan1` ,
`GwLan1` ,
`IpLan2` ,
`MaskLan2` ,
`GwLan2` ,
`IpIni` ,
`IpFin`
)
VALUES (
NULL , '98n67e45670', 'I-1100202 ', '172.14.1.1', '172.14.1.1', '172.14.1.1', '172.14.1.1', '172.14.1.1', '172.14.1.1', '172.14.1.1', '172.14.1.1'
);*/

													$res = mysql_query($query,$SICMEC); //resultado de  
													if($res)
													{
														$error= false; //La insecion es correcta
													}
													else
													{
														$error = "No se pudo registrar " . $query; //resultado de    						     
													}  						     
						  					}
						  					else
						  						$error="Debe llenar el campo de &uacute;ltima direcci&oacute;n Ip";
						  				}
						  				else
						  						$error="Debe llenar el campo de direcci&oacute;n Ip";
						  			}
						  			else
						  						$error="Debe llenar el campo de gateway Lan2";
						  		}
						  		else
						  						$error="Debe llenar el campo de mascara Lan2";
						  	}
						  	else
						  						$error="Debe llenar el campo de direcci&oacute;n ip Lan 2";
						  }
						  else
						  						$error="Debe llenar el campo de gateway Lan1";
						 }
						 else
						  						$error="Debe llenar el campo de mascara Lan1";
						}
						else
						  						$error="Debe llenar el campo de direcci&oacute;n ip Lan 1";
					}
					else
						  						$error="Debe llenar el campo de n&uacute;mero de serie del Firewall";
				}
				else
					$error="Debe de seleccionar una Plaza";
    }
    else
					$error="Error al conectar a la Base de Datos";
	if(!$error)
		header("Location: RepFw.php");
	else
		header("Location: RegFw.php?error=$error");
?>