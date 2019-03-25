/*
    SCRIPT QUE EJECUTA TODOS LOS FORMULARIOS GENERADOS EN LA PARTE DE GENERAR INDICE DE RESERVA PARA EL OFICIAL DEL IAIP
	(FICHERO) class.GenerarIndice.php
	Ese php genera una serie de n formulario, con name="valor numerico" e id="valor numerico", donde el habrá n como oficiales haya,
	y al hacer submit de cada formulario, se está generandoe el excel de consolidado de índice de reserva de ese oficial.
	
	@AUTHOR: JOSE MARIO LOPEZ LEIVA. 12/10/2017
	marioleiva2011@gmail.com

*/
function genera() 
{
	//alert("Ejecutando");
var numeroForms = $("#meter").val();
//alert(numeroForms);
/* //document.getElementById(pasada).submit();
console.log(numeroForms);
for(i=1; i<=numeroForms;i++)
{
	alert("en bucle");
	console.log("Ejecutando form ");
	console.log(i);
	document.getElementById(i).submit();
} */
/* document.forms["1"].submit();
alert("ya hice form 1");
document.forms["2"].submit();
alert("ya hice form 2"); */

$('form').each(function() {
    var that = $(this);
    $.post(that.attr('action'), that.serialize());
});
window.location.replace("/out/out.FinIndice.php");
}

window.onload = function() {
    var btn = document.getElementById("myButton");
    btn.onclick = genera;
}