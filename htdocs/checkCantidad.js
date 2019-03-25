$(document).ready(function () 
{
	$('#nombreItem').change(function() {
		//console.log("cambio en usuario");
		var idItem=$("#nombreItem").val();
		var ultimoID=idItem[idItem.length-1];
		$.ajax({
			url:"/comprobarExistencias.php?id="+ultimoID,
			success:function(result)
			{

				   var codificar=JSON.stringify(result);

						//console.log("Usuario no existe en la bd y está libre");
						//document.getElementById("divNomUsuario").classList.remove("has-feedback");
						//document.getElementById("divNomUsuario").classList.add("has-success");
						$("#divMostrarNumero").addClass("has-success");
						//limpio de mensajes el div
						var x = document.getElementById("chequecito");
						//x.innerHTML = '';

						if (x.style.display === "none") 
						{
							$(x).show('fast');
						}
						var icono= 	document.createElement("i");
						icono.setAttribute("class", "fa fa-check-circle");
						var mensaje = document.createElement("p");
					var node = document.createTextNode("Quedan "+result+" disponibles");
					mensaje.appendChild(node);
					mensaje.appendChild(icono);
					x.appendChild(mensaje);
			}
		}); //fin del ajax
	});

	$('#cantidad').change(function() {
		//console.log("cambio en usuario");
		var idItem=$("#nombreItem").val(); //array de id items 
		var cantidad=$("#cantidad").val();
		var cont=0;
		for(cont=0; cont<idItem.length;cont++)
		{
			$.ajax({
			async: false,
			url:"/comprobarExistencias.php?id="+idItem[cont],
			success:function(result)
			{


				   var quantite=result[0]; 
				   var nombreArticulo=result[1]; 


						if(Number(cantidad)<=Number(quantite)) //voy a sacar tanto o menos como hay existencias
						{
								$("#divPermitirCantidad").addClass("has-success");
								//limpio de mensajes el div
								var x = document.getElementById("chequecito2");
								//x.innerHTML = '';

								if (x.style.display === "none") 
								{
									$(x).show('fast');
								}
								var icono= 	document.createElement("i");
								icono.setAttribute("class", "fa fa-check-circle");
								var mensaje = document.createElement("p");
								var node = document.createTextNode("Puede tomar el artículo " +nombreArticulo+" porque quedan suficientes.");
								mensaje.appendChild(node);
								mensaje.appendChild(icono);
								x.appendChild(mensaje);
						}
						else
						{
							$("#divPermitirCantidad").addClass("has-error");
								//limpio de mensajes el div
								var x = document.getElementById("chequecito2");
								//x.innerHTML = '';

								if (x.style.display === "none") 
								{
									$(x).show('fast');
								}
								var icono= 	document.createElement("i");
								icono.setAttribute("class", "fa fa-check-circle");
								var mensaje = document.createElement("p");
								var node = document.createTextNode("Usted desea tomar más "+nombreArticulo+" de los que hay");
								mensaje.appendChild(node);
								mensaje.appendChild(icono);
								x.appendChild(mensaje);

						}						

			}
		}); //fin del ajax
		} //fin del for
		
		
	});
	
	
});