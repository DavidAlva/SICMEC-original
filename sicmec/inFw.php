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
													//insertar en la tabla fw 
													$query = "insert into fw values(NULL,'" . $_SESSION['serieFw'] . "','" . $_SESSION['pzaid'] . "','" .$_SESSION['iplan1'] . "','" . $_SESSION['mask1'] . "','" . $_SESSION['gat1'] . "','" . $_SESSION['iplan2'] . "','" . $_SESSION['mask2'] . "','" . $_SESSION['gat2'] . "','" . $_SESSION['dirIp1'] . "','" . $_SESSION['dirIp2'] ."')";
													$res = mysql_query($query,$SICMEC) or die("Nose pudo insertar el firewall"); //resultado de  
													//Guardar variables de ips
															// list separa los valores que tiene el array REQUEST en key se guarda
															// el id del campo
															while(list($key,$value)=each($_REQUEST)){
																// Si existe una I al inicio significa que es un equipo de computo
																if($key[0] == "I"){
																	$_SESSION[$key]=$value;
																	$Inventario = explode("-",$key);
															//Insertar en la tabla Ips (CveFw,NumInv,CveCatalogo,AnnoAlta,Ip)
																	$query = "insert into ip values(NULL,'" . $_SESSION['serieFw'] . "'," . $Inventario[1] . ",'" .$Inventario[0] . "'," . $Inventario[2] . ",'" . $value . "')";
																	$res = mysql_query($query,$SICMEC) or die("Error al insertar Ip" . $query); //resultado de insercion 
																}
															}
															if($res)
															{
																$error = false; //insercion exitosa
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