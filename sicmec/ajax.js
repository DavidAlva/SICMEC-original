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
 
function MostrarConsulta(datos){
        divResultado = document.getElementById('resultado');
        plaza = document.getElementById('nopza');
        ip = document.getElementById('ip1valida');
        ajax=objetoAjax();
        ajax.open("GET",datos+'?plazaid='+plaza.value+'&ip1val='+ip.value);
        ajax.onreadystatechange=function() {
               if (ajax.readyState==4) {
                       divResultado.innerHTML = ajax.responseText
               }
        }
        ajax.send(null)
}