$( document ).ready(function() 
{
    console.log( "a modificar eventos!" );
	$.fn.editable.defaults.mode = 'inline';
	$('[id^="evento_"]').editable();
	////////////////////////////// CAMBIOS EN PESTAÑA 1
	$('[id^="btn-add-"]').click(function(){		
		var mid=$(this).attr('id');
		//alert("hizo click en "+mid);
		var res = mid.split("-");
		var fichero=res[2];
		//console.log("Fichero: "+fichero);
		 var txt;
		var person = prompt("Ingrese el nombre del nuevo tema:", "");
		if (person == null || person == "") 
		{
			alert("No ingresó ningun dato.");
			location.reload();
		}
		else
		{
			$.ajax({
				url:"/anadirTema.php?nombrefichero="+fichero+"&texto="+person,
				success:function(result)
				{
					   //var codificar=JSON.stringify(result);
					   alert("Añadido correctamente el tema "+person+" a la categoría seleccionada");	
					   location.reload();
				}
			}); //fin del ajax
		}
		
		
	
		
	});
	$('[id*="borrar-"]').click(function()
	{
		var mid=$(this).attr('id');
		var res = mid.split("-");
		//ejemplo: borrar-abierto-2 significa: Borra el elemento 2 de la lista de los temas del fichero "abierto"
		var fichero=res[1];
		var numElemento=res[2];
		//console.log("Quiere borrar el elemento "+numElemento+" del fichero "+fichero);
		//llamo a AJAX donde la función borrarTema de borrarTema.php 
		$.ajax({
				url:"/borrarTema.php?nombrefichero="+fichero+"&numElemento="+numElemento,
				success:function(result)
				{
					   //var codificar=JSON.stringify(result);
					   alert("Eliminado correctamente el tema de la categoría seleccionada");	
					   location.reload();
				}
			}); //fin del ajax
		
		
	});
	
		
	});