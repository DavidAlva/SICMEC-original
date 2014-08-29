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

function ConsulPass(pagCons,divRes,idNodo){
        ajax=objetoAjax();
        if(idNodo.indexOf('|') != -1)
        {
					//Encontro la cadena |
					var datos = idNodo;
        }
        else{
        	var dat = document.getElementById(idNodo);
        	var datos = dat.value;

        }
        ajax.onreadystatechange= function () {
					divResultado = document.getElementById(divRes);
						if (ajax.readyState==4 && ajax.status == 200){
      				divResultado.innerHTML = ajax.responseText;
    				}
				}
        ajax.open("GET",pagCons+'?pass='+datos,true);
        ajax.send(null)
}
function VerificaPass(idP,idCP,divRes){
	var pass1 = document.getElementById(idP);
	var pass2 = document.getElementById(idCP);
	divResultado = document.getElementById(divRes);
	if(pass1.value != pass2.value){
		divResultado.innerHTML = "<p class='error'>Los Password son diferentes</p>";
		return false;
	}
	else{
		divResultado.innerHTML = "";
		return true;
	}
}
//funcion para cambiar el password
//pag es la pagina php que va a cambiar el password con un Update, divRes es la capa que dira si se cambio el
//el password, divCP es para el anuncio si los password son iguales, idPas es el antiguo password
//idP es el nuevo password, idCP es la confirmacion de ese password
function CambiaPass(pag,divRes,divCP,idPas,idP,idCP){
//Se verifican que los password sean iguales
	if(VerificaPass(idP,idCP,divCP)){
		//Concatenar el antiguo password con el nuevo password
		var oldpass = document.getElementById(idPas);
		var newpass = document.getElementById(idP);
		var newCpass = document.getElementById(idCP);
		var Passw = oldpass.value + "|" + newpass.value;
		oldpass.value = "";
		newpass.value = "";
		newCpass.value = "";
		ConsulPass(pag,divRes,Passw);
	}
}