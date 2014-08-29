function objetoAjax(){
        var xmlhttp=false;
        try {
               xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
               try {
                  xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
               } catch (E) {
                       xmlhttp = false;
               }
        }

        if (!xmlhttp && typeof XMLHttpRequest!='undefined') {

               xmlhttp = new XMLHttpRequest();
        }
        return xmlhttp;
}

function MostrarTabs(pagCons,divRes,datos){
        ajax=objetoAjax();
        //nQuery = ConsulContent(datos,pagCons);
        ajax.onreadystatechange= function () {
					divResultado = document.getElementById(divRes);
					if (ajax.readyState==1){
     				divResultado.innerHTML = '<img src="imagenes/ajaxloader.gif" style="margin:80px 0 0 205px;"/><p align="center">Cargando</p>';
  				}
  				if (ajax.readyState==4 && ajax.status == 200){
      				divResultado.innerHTML = ajax.responseText;
    				}
				}
        ajax.open("GET",ConsulContent(datos,pagCons),true);
        ajax.send(null)
}

function ConsulContent(Query,pag){
				switch(Query){
						case 'MostrarSO':
						case 'MostrarLe':
						case 'MostrarTR':
						case 'MostrarTV':
						case 'MostrarHDD':
						case 'MostrarMR':
						case 'MostrarTM': jQuery = pag + '?funcion=' + Query;
												break;
						default: jQuery = queryCantd(pag,Query);
				}
			return jQuery;
}
//Funcion para generar la query con datos GET de cantidad Memoria Ram u otro formulario **********************
function queryCantd(webPag,formulario){
				var sCantd = document.getElementById('cantidad').value;
				var sQuery = webPag + '?cantd=' + sCantd + '&funcion=' + formulario;
				return sQuery;
}

//Generar la Query que se va a pasar por POST a TablasAct.php
function genQuery(){
				var catalogo = document.getElementById("Catalogo");
				var numinv = document.getElementById("NumInv");
				var anio = document.getElementById("Anio");
				return "cvecatalogo=" + catalogo.value + "&numinv=" + numinv.value + "&annio=" + anio.value;
}
//Funcion General para guardar datos
function guarda(pagina,divRe){
				ajax = objetoAjax();
				ajax.onreadystatechange = function () {
					divResultado = document.getElementById(divRe);
					if (ajax.readyState==1){
     				divResultado.innerHTML = '<img src="imagenes/ajaxloader.gif" style="margin:80px 0 0 205px;"/><p align="center">Cargando</p>';
  				}
  				if (ajax.readyState==4 && ajax.status == 200){
      				divResultado.innerHTML = ajax.responseText;
    				}
				}
				var queryPost;
				switch(pagina){
					case 'php/TablaAct.php': queryPost = genQuery();
														break;
					case 'php/TablaInfo.php': queryPost = genQuery();
																		queryPost += '&funcion=Tabla';
														break;
					case 'php/MainTM.php': queryPost = qGuardaTM(divRe);
														break;
					case 'php/MainMR.php': queryPost = qGuardaMR(divRe);
														break;
					case 'php/MainHDD.php': queryPost = qGuardaHDD(divRe);
														break;
					case 'php/MainLe.php': queryPost = qGuardaLe(divRe);
														break;
					case 'php/MainTR.php': queryPost = qGuardaTR(divRe);
														break;
					case 'php/MainTV.php': queryPost = qGuardaTV(divRe);
														break;
					case 'php/MainSO.php': queryPost = qGuardaSO(divRe);
														break;
				}
				alert(queryPost);
        ajax.open("POST",pagina,true);
        ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        ajax.setRequestHeader("Content-length", queryPost.length)
        ajax.setRequestHeader("Connection", "close");
				ajax.send(queryPost);
}
//Funcion para insertar tarjeta madre**********************************************************************
function qGuardaTM(opcion){
				var cveMarca = document.getElementById("marca");
				var descripcion = document.getElementById("descripcion");
				//Obtenemos la cveact del equipo al que se le va a dar de alta la tarjeta madre
				if(opcion == 'Formularios')
					var cveAct = getCheckBox('CveActivo');
				else
					var cveAct = "Actualiza";
				return "cveMarca=" + cveMarca.value + "&descrip=" + descripcion.value + "&cveAct=" + cveAct + "&funcion=Guardar";
}
//Funcion para guardar Memoria RAM**********************************************************************
function qGuardaMR(opcion){
				var cveMarca = document.getElementsByName("MarcaMR");
				var cveMstr = separaComas(cveMarca);
				var capaci = document.getElementsByName("Capacidad");
				var capacidad = separaComas(capaci);
				var veloci = document.getElementsByName("Velocidad");
				var velocidad = separaComas(veloci);
				var uniCap = document.getElementsByName("uniCap");
				var uniCapaci = separaComas(uniCap);
				var uniVel = document.getElementsByName("uniVel");
				var uniVeloci = separaComas(uniVel);
				var query;
				//Obtenemos la cveact del equipo al que se le va a dar de alta la tarjeta madre
				if(opcion == 'Formularios'){
					var cveAct = getCheckBox('CveActivo');
					query = "&cveAct=" + cveAct + "&funcion=Guardar";
				}
				else{
					var cveMemE = getCheckBox('Elimina');
					var cveMem = document.getElementsByName("Elimina");
					var cveMemRam = separaComas(cveMem);
					query = "&cveMem=" + cveMemRam + "&cveMemE=" + cveMemE + "&funcion=Actualiza";
				}
				return "cveMarca=" + cveMstr + "&capacidad=" + capacidad + "&uniCap=" + uniCapaci +"&velocidad=" + velocidad + "&uniVel=" + uniVeloci + query;
}
//Formar una cadena separada por comas **********************************************************
function separaComas(objArray){
	var cadena = "";
	for (i=0;i<objArray.length;i++){
		if(cadena != "" )
			cadena += "|";
		cadena += objArray[i].value;
	}
	return cadena;
}
//Funcion para guardar Disco Duro **********************************************************************
function qGuardaHDD(opcion){
				var cveMarca = document.getElementsByName("MarcaHDD");
				var cveMstr = separaComas(cveMarca);
				var capaci = document.getElementsByName("CapHDD");
				var capacidad = separaComas(capaci);
				var veloci = document.getElementsByName("VelHDD");
				var velocidad = separaComas(veloci);
				var conex = document.getElementsByName("conHDD");
				var conexion = separaComas(conex);
				var uniCap = document.getElementsByName("uniCap");
				var uniCapaci = separaComas(uniCap);
				var uniVel = document.getElementsByName("uniVel");
				var uniVeloci = separaComas(uniVel);
				var query;
				//Obtenemos la cveact del equipo al que se le va a dar de alta la tarjeta madre
				if(opcion == 'Formularios'){
					//Obtenemos la cveact del equipo al que se le va a dar de alta la tarjeta madre
					var cveAct = getCheckBox('CveActivo');
					query = "&cveAct=" + cveAct + "&funcion=Guardar";
				}
				else{
					var cveHE = getCheckBox('Elimina');
					var cveHdd = document.getElementsByName("Elimina");
					var cveH = separaComas(cveHdd);
					query = "&cveHDD=" + cveH + "&cveHDDE=" + cveHE + "&funcion=Actualiza";
				}

				return "cveMarca=" + cveMstr + "&capacidad=" + capacidad + "&uniCap=" + uniCapaci +"&velocidad=" + velocidad + "&uniVel=" + uniVeloci +"&conec=" + conexion + query;
}
//Funcion Guardar lectoras *******************************************************************************
function qGuardaLe(opcion){
				var cveMarca = document.getElementsByName("MarcaLe");
				var cveMstr = separaComas(cveMarca);
				var tipo = document.getElementsByName("tipoLe");
				var tipoLec = separaComas(tipo);
				var descri = document.getElementsByName("descLe");
				var descripcion = separaComas(descri);
				//Obtenemos la cveact del equipo al que se le va a dar de alta la tarjeta madre
				if(opcion == 'Formularios'){
					//Obtenemos la cveact del equipo al que se le va a dar de alta la tarjeta madre
					var cveAct = getCheckBox('CveActivo');
					query = "&cveAct=" + cveAct + "&funcion=Guardar";
				}
				else{
					var cveLE = getCheckBox('Elimina');
					var cveLec = document.getElementsByName("Elimina");
					var cveL = separaComas(cveLec);
					query = "&cveLe=" + cveL + "&cveLeE=" + cveLE + "&funcion=Actualiza";
				}
				alert(query);
				return "cveMarca=" + cveMstr + "&tipoLe=" + tipoLec + "&descripcion=" + descripcion + query;
}
//Funcion Guardar Tarjetas de Red*********************************************************************
function qGuardaTR(opcion){
				var cveMarca = document.getElementsByName("MarcaTR");
				var cveMstr = separaComas(cveMarca);
				var conex = document.getElementsByName("conTR");
				var conexion = separaComas(conex);
				var tipCon = document.getElementsByName("tipConTR");
				var tipo = separaComas(tipCon);
				var vel = document.getElementsByName("VelTR");
				var velocidad = separaComas(vel);
				var unVel = document.getElementsByName("uniVel");
				var uniVel = separaComas(unVel);
				//Obtenemos la cveact del equipo al que se le va a dar de alta la tarjeta madre
				if(opcion == 'Formularios'){
					//Obtenemos la cveact del equipo al que se le va a dar de alta la tarjeta madre
					var cveAct = getCheckBox('CveActivo');
					query = "&cveAct=" + cveAct + "&funcion=Guardar";
				}
				else{
					var cveTRE = getCheckBox('Elimina');
					var cveTr = document.getElementsByName("Elimina");
					var cveTred = separaComas(cveTr);
					query = "&cveTR=" + cveTred + "&cveTRE=" + cveTRE + "&funcion=Actualiza";
				}
				alert(query);
				return "cveMarca=" + cveMstr + "&conexion=" + conexion + "&tipo=" + tipo + "&velocidad=" + velocidad + "&uniVeloci=" + uniVel + query;
}
//Funcion Guardar Tarjetas de Video***********************************************************************
function qGuardaTV(opcion){
				var cveMarca = document.getElementsByName("MarcaTV");
				var cveMstr = separaComas(cveMarca);
				var desc = document.getElementsByName("descTV");
				var descripcion = separaComas(desc);
				//Obtenemos la cveact del equipo al que se le va a dar de alta la tarjeta madre
				if(opcion == 'Formularios'){
					//Obtenemos la cveact del equipo al que se le va a dar de alta la tarjeta madre
					var cveAct = getCheckBox('CveActivo');
					query = "&cveAct=" + cveAct + "&funcion=Guardar";
				}
				else{
					var cveTVE = getCheckBox('Elimina');
					var cveTv = document.getElementsByName("Elimina");
					var cveTvid = separaComas(cveTv);
					query = "&cveTV=" + cveTvid + "&cveTVE=" + cveTVE + "&funcion=Actualiza";
				}
				alert(query);
				return "cveMarca=" + cveMstr + "&descripcion=" + descripcion + query;
}
//Funcion para insertar tarjeta madre**********************************************************************
function qGuardaSO(opcion){
				var cveSo = document.getElementById("SO");
				var descripcion = document.getElementById("descSO");
				//Obtenemos la cveact del equipo al que se le va a dar de alta la tarjeta madre
				if(opcion == 'Formularios')
					var cveAct = getCheckBox('CveActivo');
				else
					var cveAct = "Actualiza";
				return "cveSO=" + cveSo.value + "&descrip=" + descripcion.value + "&cveAct=" + cveAct + "&funcion=Guardar";
}
//Funcion para modificar los componentes de un activo fijo
function modificar(cveAct,divRes){
				ajax=objetoAjax();
				alert(cveAct);
        //nQuery = ConsulContent(datos,pagCons);
        ajax.onreadystatechange= function () {
					divResultado = document.getElementById(divRes);
					if (ajax.readyState==1){
     				divResultado.innerHTML = '<img src="imagenes/ajaxloader.gif" style="margin:80px 0 0 205px;"/><p align="center">Cargando</p>';
  				}
  				if (ajax.readyState==4 && ajax.status == 200){
      				divResultado.innerHTML = ajax.responseText;
    				}
				}
        ajax.open("GET",cveAct,true);
        ajax.send(null);
}