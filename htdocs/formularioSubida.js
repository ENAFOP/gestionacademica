function goNextTab(currtab, nexttab, numeroActual,numeroSiguiente) 
{

    var curr = $('li.active');
    
    curr.removeClass('active');
    if (curr.is("li:last")) 
	{
        $("li:first-child").addClass('active');
    } 
	else 
	{
        curr.next().find("a").click();
        curr.next().addClass('active');
    }

	
			$("#nav-tab-"+numeroActual).removeClass("active");
			$("#nav-tab-"+numeroSiguiente).addClass("active");
			$('html, body').animate({scrollTop: 0}, 800);

    $('#' + currtab).attr('aria-expanded', 'false');
    $('#' + nexttab).attr('aria-expanded', 'true');

}


$('#attributes_17').change(function() 
{
    var val = $("#attributes_17 option:selected").text();
   // console.log("Seleccionado "+val);
	var divigente = document.getElementById("leyVigente");
	var divigente2 = document.getElementById("leyVigente2");
	var divderogada =  document.getElementById("leyDerogada");
	var divderogada2 =  document.getElementById("leyDerogada2");
	if(val.localeCompare("Ley vigente")==0)
	{
		//SI SELECCIONO LA LEY VIGENTE MUESTRO LOS DIV DE VIGENTE Y OCULTO LAS DEROGADAS
		divigente.style.display = "block";
		divigente2.style.display = "block";
		divderogada.style.display = "none";
		divderogada2.style.display = "none";
	}
	if(val.localeCompare("Ley derogada")==0)
	{
		divderogada.style.display = "block";
		divderogada2.style.display = "block";
		
		divigente.style.display = "none";
		divigente2.style.display = "none";
	}
	
		
	
});


$( document ).ready(function() 
{

	
    $('#btn-next-1').on('click', function () 
	{
		$("[name^=attributes]").each(function () 
		{
			$(this).rules("add", 
			{
				required: true,
				messages: 
				{
					required: "Debe completar este campo."
				}
				
			});
			
		});
			console.log("nos vamos para validar");
			//var validator = $("#form2").validate();
			var form=$( "#form2");
			form.validate();
			var resu=form.valid();
			if(resu==true)
			{
				console.log("NOMBRE CORRECTO");
				goNextTab('tab_1','tab_2',1,2);
		  } 
		
		
    });
});