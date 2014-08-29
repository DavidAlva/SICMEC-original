<?php
require_once('equipoComputo.class.php');

function MostrarMenu(){
	echo "<div class='column-unit-left'>
					<ul>
						<li><a href='javascript:modificar(\"php/TablaInfo.php?funcion=TM\",\"opciones\")'>Tarjeta Madre</a></li>
						<li><a href='javascript:modificar(\"php/TablaInfo.php?funcion=MR\",\"opciones\")'>Memoria Ram</a></li>
						<li><a href='javascript:modificar(\"php/TablaInfo.php?funcion=HDD\",\"opciones\")'>Disco Duro</a></li>
						<li><a href='javascript:modificar(\"php/TablaInfo.php?funcion=LE\",\"opciones\")'>Lectoras</a></li>
						<li><a href='javascript:modificar(\"php/TablaInfo.php?funcion=TR\",\"opciones\")'>Tarjeta de Red</a></li>
						 <li><a href='javascript:modificar(\"php/TablaInfo.php?funcion=TV\",\"opciones\")'>Tarjeta de Video</a></li>
						 <li><a href='javascript:modificar(\"php/TablaInfo.php?funcion=SO\",\"opciones\")'>Software</a></li>
						<li><a href='#'>" . $_SESSION['Equipo']->getCveEquipo() . "</a></li>
					</ul>
				</div>
				<div class='column-unit-right' id='opciones'>

		</div>";
}
function MostrarOpciones($sDispos){
	switch($sDispos){
		case 'TM':	$result = $_SESSION['Equipo']->consTarjMadre();
								MostrarTM($result);
								break;
		case 'MR':	$result = $_SESSION['Equipo']->consMemRam();
								MostrarMR($result);
								break;
		case 'HDD': $result = $_SESSION['Equipo']->consHDD();
								MostrarHDD($result);
								break;
		case 'LE': $result = $_SESSION['Equipo']->consLectoras();
								MostrarLe($result);
								break;
		case 'TR': $result = $_SESSION['Equipo']->consTarRed();
								MostrarTR($result);
								break;
		case 'TV': $result = $_SESSION['Equipo']->consTarVid();
								MostrarTV($result);
								break;
		case 'SO': $result = $_SESSION['Equipo']->consSoftware();
								MostrarSof($result);
								break;
	}
}
//Mostrar Tarjeta Madre
function MostrarTM($dataSet){
	$registro = mysql_fetch_row($dataSet);
	echo "<div class=\"tarjeta madre\">
						<form method=\"post\" action=\"\" class=\"formulario\">
							<fieldset>
							<legend>Tarjeta Madre</legend>
							<p><label for=\"marca\" class=\"left\">Marca</label>
								<select id=\"marca\" name=\"marca\" class=\"combo\">";
								$con = new MySqlConnection('sicmec','root','$4bi4n');
								$con->Open();
								$query = "Select idMarca,nombre from Marca order by nombre ASC";
								$result = mysql_query($query,$con->getIdConnection());
								while($campo = mysql_fetch_row($result)){
									echo "<option value='$campo[0]' ";
									if($campo[0] == $registro[0])
										echo "selected";
									echo	">$campo[1]</option>";
								}
		echo	"			</select>
							</p>
							<p>
								<label for=\"descripcion\" class=\"left\">Descripci&oacute;n</label>
								<textarea name=\"descripcion\" id=\"descripcion\" cols=\"45\" rows=\"10\">" . $registro[1] . "</textarea>
							</p>
							<p><input type=\"submit\" name=\"gTM\" id=\"gTM\" value=\"Actualizar\" class=\"button\" onclick='guarda(\"php/MainTM.php\",\"opciones\")' />
							</p>
							</fieldset>
						</form>
					</div>";
					$con->closeCon();
}
//Mostrar Memoria Ram
function MostrarMR($dataSet){
	echo "<div class='otra'>
					<form method=\"Post\" action='' class=\"formulario\">
							<fieldset>
							<legend>Memoria RAM</legend>";
				while($registro = mysql_fetch_row($dataSet)){
					echo "<p class='checkbox'><input type='checkbox' name='Elimina' value='$registro[3]' />Eliminar</p>
								<p><label for=\"MarcaMR\" class=\"left\">Marca</label>
									<select name=\"MarcaMR\" id=\"MarcaMR\" class=\"combo\">";
									$con = new MySqlConnection('sicmec','root','$4bi4n');
									$con->Open();
									$query = "Select idMarca,nombre from Marca order by nombre ASC";
									$result = mysql_query($query,$con->getIdConnection());
									while($campo = mysql_fetch_row($result)){
										echo "<option value='$campo[0]'";
										if($campo[0] == $registro[0])
											echo "selected";
										echo ">$campo[1]</option>";
									}
									$con->closeCon();
									$capacidad = explode(" ",$registro[1]);
									$velocidad = explode(" ",$registro[2]);
					echo	"</select>
								</p>
								<p><label for=\"Capacidad\" class=\"left\">Capacidad</label>
								<input type=\"text\" name=\"Capacidad\" id=\"Capacidad\" maxlength=\"3\" size=\"13\"
								value=\"$capacidad[0]\"/>
								<select name=\"uniCap\" id=\"uniCap\" class=\"combo\" style=\"width:52px;\">
									<option value='MB'";
									if($capacidad[1] == 'MB')
										echo "selected";
									echo ">MB</option>
									<option value='KB'";
									if($capacidad[1] == 'KB')
										echo "selected";
									echo ">KB</option>
									<option value='GB'";
									if($capacidad[1] == 'GB')
										echo "selected";
									echo	">GB</option>
									<option value='TB'";
									if($capacidad[1] == 'TB')
										echo "selected";
									echo ">TB</option>
								</select>
								</p>
								<p><label for=\"Velocidad\" class=\"left\">Velocidad</label>
								<input type=\"text\" name=\"Velocidad\" id=\"Velocidad\" maxlength=\"5\" size=\"13\"
								value=\"$velocidad[0]\" />
								<select name=\"uniVel\" id=\"uniVel\" class=\"combo\" style=\"width:52px;\">
									<option value='Mhz'";
									if($velocidad[1] == 'Mhz')
										echo "selected";
									echo ">Mhz</option>
									<option value='Khz'";
									if($velocidad[1] == 'Khz')
										echo "selected";
									echo ">Khz</option>
									<option value='Ghz'";
									if($velocidad[1] == 'Ghz')
										echo "selected";
									echo ">GHz</option>
								</select>
							</p>";
				}
				echo "<p><input type=\"button\" name=\"cantdMR\" id=\"cantdMR\" value=\"Guardar\" class=\"button\" onclick='guarda(\"php/MainMR.php\",\"opciones\")' /></p>
							</fieldset>
							</form>
							</div>";
}
function MostrarHDD($dataSet){
	echo "<div class='HDD'>
					<form method=\"get\" action='' class=\"formulario\">
							<fieldset>
							<legend>Disco Duro</legend>";
				while($registro = mysql_fetch_row($dataSet)){
					echo "<p class='checkbox'><input type='checkbox' name='Elimina' value='$registro[4]' />Eliminar</p>
								<p><label for=\"MarcaHDD\" class=\"left\">Marca</label>
									<select name=\"MarcaHDD\" id=\"MarcaHDD\" class=\"combo\">";
									$con = new MySqlConnection('sicmec','root','$4bi4n');
									$con->Open();
									$query = "Select idMarca,nombre from Marca order by nombre ASC";
									$result = mysql_query($query,$con->getIdConnection());
									while($campo = mysql_fetch_row($result)){
										echo "<option value='$campo[0]'";
										if($campo[0] == $registro[0])
											echo "selected";
										echo ">$campo[1]</option>";
									}
									$con->closeCon();
									$capacidad = explode(" ",$registro[1]);
									$velocidad = explode(" ",$registro[2]);
					echo	 "</select>
								</p>
								<p><label for=\"CapHDD\" class=\"left\">Capacidad</label>
								<input type=\"text\" name=\"CapHDD\" id=\"CapHDD\" maxlength=\"3\" size=\"13\" value=\"$capacidad[0]\" />
								<select name=\"uniCap\" id=\"uniCap\" class=\"combo\" style=\"width:52px;\">
									<option value='MB'";
									if($capacidad[1] == 'MB')
										echo "selected";
									echo ">MB</option>
									<option value='KB'";
									if($capacidad[1] == 'KB')
										echo "selected";
									echo ">KB</option>
									<option value='GB'";
									if($capacidad[1] == 'GB')
										echo "selected";
									echo	">GB</option>
									<option value='TB'";
									if($capacidad[1] == 'TB')
										echo "selected";
									echo ">TB</option>
								</select>
								</p>
								<p><label for=\"VelHDD\" class=\"left\">Velocidad</label>
								<input type=\"text\" name=\"VelHDD\" id=\"VelHDD\" maxlength=\"5\" size=\"13\" value=\"$velocidad[0]\" />
								<select name=\"uniVel\" id=\"uniVel\" class=\"combo\" style=\"width:52px;\">
									<option>RPM</option>
								</select>
							</p>
								<p><label for=\"conHDD\" class=\"left\">Conexi&oacute;n</label>
								<select name=\"conHDD\" id=\"conHDD\" class=\"combo\" >
								<option value='IDE'";
									if($registro[3] == 'IDE')
										echo "selected";
									echo ">IDE</option>
									<option value='SATA'";
									if($registro[3] == 'SATA')
										echo "selected";
									echo ">SATA</option>
									<option value='SCSI'";
									if($registro[3] == 'SCSI')
										echo "selected";
									echo ">SCSI</option>
								</select>
								</p>";
				}
				echo "<p><input type=\"submit\" class=\"button\" value='Guardar' onclick='guarda(\"php/MainHDD.php\",\"opciones\")'/></p>
							</fieldset>
							</form>
						</div>";
}
function MostrarLe($dataSet){
	echo "<div class='TR'>
					<form method=\"get\" action='' class=\"formulario\">
							<fieldset>
							<legend>Lectoras</legend>";
				while($registro = mysql_fetch_row($dataSet)){
					echo "<p class='checkbox'><input type='checkbox' name='Elimina' value='$registro[3]' />Eliminar</p>
								<p><label for=\"tipoLe\" class=\"left\">Tipo Lector</label>
								<select name=\"tipoLe\" id=\"tipoLe\" class=\"combo\" >
									<option value='DVD Combo'";
									if($registro[1] == "DVD Combo")
										echo "selected";
									echo ">DVD Combo</option>
									<option value='DVD'";
									if($registro[1] == "DVD")
										echo "selected";
									echo ">DVD</option>
									<option value='DVD-RW Combo'";
									if($registro[1] == "DVD-RW Combo")
										echo "selected";
									echo ">DVD-RW Combo</option>
									<option value='CD'";
									if($registro[1] == "CD")
										echo "selected";
									echo ">CD</option>
									<option value='CD-RW'";
									if($registro[1] == "CD-RW")
										echo "selected";
									echo ">CD-RW</option>
								</select>
								</p>
								<p><label for=\"MarcaLe\" class=\"left\">Marca</label>
									<select name=\"MarcaLe\" id=\"MarcaLe\" class=\"combo\">";
										$con = new MySqlConnection('sicmec','root','$4bi4n');
										$con->Open();
										$query = "Select idMarca,nombre from Marca order by nombre ASC";
										$result = mysql_query($query,$con->getIdConnection());
										while($campo = mysql_fetch_row($result)){
											echo "<option value='$campo[0]'";
											if($campo[0] == $registro[0])
												echo "selected";
											echo ">$campo[1]</option>";
										}
									$con->closeCon();
					echo		"</select>
								</p>
								<p><label for=\"descLe\" class=\"left\">Descripci&oacute;n</label>
								<textarea name=\"descLe\" id=\"descLe\" class=\"textarea\" cols='45' rows='10' >$registro[2]</textarea>
								</p>";
				}
				echo "<p><input type=\"button\" name=\"regTR\" value=\"Guardar\" class=\"button\" onclick='guarda(\"php/MainLe.php\",\"opciones\")' /></p>
							</fieldset>
							</form>
					</div>";
}
function MostrarTR($dataSet){
	echo "<div class='TR'>
					<form method=\"get\" action='' class=\"formulario\">
							<fieldset>
							<legend>Tarjeta de Red</legend>";
				while($registro = mysql_fetch_row($dataSet)){
					echo "<p class='checkbox'><input type='checkbox' name='Elimina' value='$registro[4]' />Eliminar</p>
								<p><label for=\"MarcaTR\" class=\"left\">Marca</label>
									<select name=\"MarcaTR\" id=\"MarcaTR\" class=\"combo\">";
										$conexion = explode(" ",$registro[3]);
										$con = new MySqlConnection('sicmec','root','$4bi4n');
										$con->Open();
										$query = "Select idMarca,nombre from Marca order by nombre ASC";
										$result = mysql_query($query,$con->getIdConnection());
										$con->closeCon();
										while($campo = mysql_fetch_row($result)){
											echo "<option value='$campo[0]'";
											if($campo[0] == $registro[0])
												echo "selected";
											echo ">$campo[1]</option>";
										}
					echo		"</select>
								</p>
								<p><label for=\"conTR\" class=\"left\">Conexi&oacute;n</label>
								<select name=\"conTR\" id=\"conTR\" class=\"combo\" >
									<option value='inalambrica'";
									if($registro[1] == 'inalambrica')
										echo "selected";
									echo ">Inal&aacute;mbrica</option>
									<option value='alambrica'";
									if($registro[1] == 'alambrica')
										echo "selected";
									echo ">Al&aacute;mbrica</option>
								</select>
								</p>
								<p><label for=\"tipConTR\" class=\"left\">Tipo Conexi&oacute;n</label>
								<select name=\"tipConTR\" id=\"tipConTR\" class=\"combo\" style=\"width:100px;\">
									<option value='b/g'";
									if($registro[2] == 'b/g')
										echo "selected";
									echo ">b/g</option>
									<option value='a'";
									if($registro[2] == 'a')
										echo "selected";
									echo ">a</option>
									<option value='b'";
									if($registro[2] == 'b')
										echo "selected";
									echo ">b</option>
									<option value='g'";
									if($registro[2] == 'g')
										echo "selected";
									echo ">g</option>
									<option value='a/b/g'";
									if($registro[2] == 'a/b/g')
										echo "selected";
									echo ">a/b/g</option>
									<option value='ethernet'";
									if($registro[2] == 'ethernet')
										echo "selected";
									echo ">Ethernet</option>
								</select>
								</p>
								<p><label for=\"VelTR\" class=\"left\">Velocidad</label>
								<input type=\"text\" name=\"VelTR\" id=\"VelTR\" maxlength=\"5\" size=\"13\" value=\"$conexion[0]\" />
								<select name=\"uniVel\" id=\"uniVel\" class=\"combo\" style=\"width:52px;\">
									<option value='Mbps'";
									if($conexion[1] == 'Mbps')
										echo "selected";
									echo ">Mbps</option>
									<option value='Kbps'";
									if($conexion[1] == 'Kbps')
										echo "selected";
									echo ">Kbps</option>
									<option value='Gbps'";
									if($conexion[1] == 'Gbps')
										echo "selected";
									echo ">Gbps</option>
								</select>
							</p>";
				}
				echo "<p><input type=\"submit\" name=\"regTR\" value=\"Guardar\" class=\"button\" onclick='guarda(\"php/MainTR.php\",\"opciones\")' /></p>
							</fieldset>
							</form>
					</div>";
}
function MostrarTV($dataSet){
	echo "<div class='TV'>
					<form method=\"get\" action='' class=\"formulario\">
							<fieldset>
							<legend>Tarjetas de Video</legend>";
				while($registro = mysql_fetch_row($dataSet)){
					echo "<p class='checkbox'><input type='checkbox' name='Elimina' value='$registro[2]' />Eliminar</p>
								<p><label for=\"MarcaTV\" class=\"left\">Marca</label>
									<select name=\"MarcaTV\" id=\"MarcaTV\" class=\"combo\">";
										$con = new MySqlConnection('sicmec','root','$4bi4n');
										$con->Open();
										$query = "Select idMarca,nombre from Marca order by nombre ASC";
										$result = mysql_query($query,$con->getIdConnection());
										$con->closeCon();
										while($campo = mysql_fetch_row($result)){
											echo "<option value='$campo[0]'";
											if($campo[0] == $registro[0])
												echo "selected";
											echo ">$campo[1]</option>";
										}
					echo		"</select>
								</p>
								<p><label for=\"descTV\" class=\"left\">Descripci&oacute;n</label>
								<textarea name=\"descTV\" id=\"descTV\" class=\"textarea\" cols='45' rows='10' >$registro[1]</textarea>
								</p>";
				}
				echo "<p><input type=\"button\" name=\"regTV\" id=\"regTV\" value=\"Guardar\" class=\"button\" onclick='guarda(\"php/MainTV.php\",\"opciones\")' /></p>
							</fieldset>
							</form>
						</div>";
}
function MostrarSof($dataSet){
	$registro = mysql_fetch_row($dataSet);
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
										echo "<option value='$campo[0]'";
										if($campo[0] == $registro[0])
											echo "selected";
										echo ">$campo[1]</option>";
									}
					echo	"</select>
								</p>
								<p><label for=\"descSO\" class=\"left\">Descripci&oacute;n</label>
								<textarea name=\"descSO\" id=\"descSO\" class=\"textarea\" cols='45' rows='10' >$registro[1]</textarea>
								</p>
								<p><input type=\"button\" name=\"guardSO\" value=\"Guardar\" class=\"button\" onclick='guarda(\"php/MainSO.php\",\"opciones\")' /></p>
							</fieldset>
							</form>
						</div>";
}
function MostrarTabla(){
	$sCvecat = trim($_REQUEST['cvecatalogo']);
	$sNuminv = trim($_REQUEST['numinv']);
	$sAnio = trim($_REQUEST['annio']);

//Constructor de EquipoComputo(cveEquipo,CveCatalogo,NumInventario,Annio)
	$equipo = new EquipoComputo('',$sCvecat,$sNuminv,$sAnio);
	$datSet = $equipo->consultaEquipo();
/*
while($campo = mysql_fetch_row($datSet))
$cves[] = $campo[0];
for($i=0;$i<count($cves);$i++)
	echo "$cves[$i] <br/>";*/

/*
while($campo = mysql_fetch_row($res))
echo "$campo[0] $campo[1] $campo[2]<br/>";
*/
//Array con las querys que se van a ejecutar para obtener la informacion
	$qry[] = "Select m.nombre, dd.capacidad from HDD dd join Marca m on m.idMarca = dd.idMarca where dd.cveAct =";
	$qry[] = "Select m.nombre, mr.capacidad from MemRam mr join Marca m on m.idMarca = mr.idMarca where mr.cveAct =";
	$qry[] = "Select m.nombre, tm.descripcion from TarjMadre tm join Marca m on m.idMarca = tm.idMarca where tm.cveAct =";
	$qry[] = "Select m.nombre, le.tipo from Lectoras le join Marca m on m.idMarca = le.idMarca where le.cveAct =";
	$qry[] = "Select m.nombre, tr.conexion from TarjRed tr join Marca m on m.idMarca = tr.idMarca where tr.cveAct =";
	$qry[] = "Select m.nombre, tv.descripcion from TarjVideo tv join Marca m on m.idMarca = tv.idMarca where tv.cveAct =";
	$qry[] = "Select so.nombre, s.descripcion from Software s join SO so on so.idSo = s.idSo where s.cveAct =";

	echo "<table id='activo' name='activo' cellpadding='0' cellspacing='0' border='0' class='rowstyle-alt colstyle-alt no-arrow sortable-onload-1'>
		<thead>
      <tr>
        <th></th>
        <th>Cat&aacute;logo</th>
        <th>Num Inventario</th>
        <th>Descripci&oacute;n</th>
        <th>Disco Duro</th>
        <th>Memoria Ram</th>
        <th>Tarjeta Madre</th>
        <th>Lector</th>
        <th>Tarjeta de Red</th>
        <th>Tarjeta de Video</th>
        <th>Software</th>
      </tr>
    </thead><tbody>";
    $NumI = 0;
    while($equ = mysql_fetch_row($datSet)){
    	if ($par == 2){
    		echo "<tr class='alt'>";
    		$par = 1;
    	}
    	else{
    		echo "<tr>";
    		$par = 2;
    	}
    	echo "<td><input type='hidden' name='CveAct' value=\"$equ[0]\" />". ++$NumI . "</td>
    				<td><a href='javascript:modificar(\"php/TablaInfo.php?funcion=Menu&cveAct=$equ[0]\",\"Tabla\")'>" . $equ[1] . "</a></td>
        		<td>" . $equ[2] . "</td>
        		<td>" . $equ[3] . "</td>";
        		//&&&&&&&&&&&&&&&&&&&&&&&&&  CONSULTAS  &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
        		foreach($qry as $query){
        			$res = $equipo->consulta($equ[0],$query);
        			echo "<td>";
        			while($tab = mysql_fetch_row($res))
        				echo "$tab[0] $tab[1] <br/>";
       				echo "</td>";
       			}

      echo	"</tr>";
    }
    echo "</tbody></table>";
}

if (isset($_REQUEST['funcion']))
	$sFuncion = $_REQUEST['funcion'];
else
	$sFuncion = "";

switch($sFuncion){
	case 'Menu': 	if(session_start())
									session_destroy();
								session_start();
								$_SESSION['Equipo'] = new EquipoComputo($_REQUEST['cveAct'],'','','');
								MostrarMenu();
								break;
	case 'Tabla': MostrarTabla();
								break;
	default : 		session_start();
								MostrarOpciones($sFuncion);
								break;
}
?>
