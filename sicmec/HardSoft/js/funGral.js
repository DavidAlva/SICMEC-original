//Funciones Generales
//David Saldana Ramirez
//Funcion para formar un string separado por comas de todos los valores de los checkbox seleccionados
	function getCheckBox(nombre){
		var getstr = "";
		var CvesActv = document.getElementsByName(nombre);
		for (i=0;i<CvesActv.length;i++){
		// si es un checkbox, verifica que esté seleccionado
			if (CvesActv[i].type == "checkbox"){
				if (CvesActv[i].checked == true){
					if(getstr != "" )
						getstr += "|";
					getstr += CvesActv[i].value;
				}
			}
		}
				//enviar cadena para la consulta
		return getstr;
	}

//Funcion para seleccionar todos o ninguno de los checkbox
//REcibe el nombre del checkbox, True si se quiere activar o false en caso contrario
	function SelecAllNone(nombre,activa){
		var Cves = document.getElementsByName(nombre);
		for(i=0;i<Cves.length;i++)
			Cves[i].checked = activa;
	}