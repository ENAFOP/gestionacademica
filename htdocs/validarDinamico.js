/*  $(document).ready(function() {


      $('#submit').click(function(e)
      {
                
                  // submit if already checked

          if($(this).attr("data-checked")) 
          {
               //$("#form1").submit()
             return true;
          }
              


        var fechaInicio = $("#fechaInicio").val();
        //alert("SCRIPT: FECHA INICIO" +fechaInicio);
       //var fechaInicio =   document.getElementById("createstartdate").value
        

        var fechaFin = $("#fechaFin").val();
         // alert("SCRIPT: FECHA Fin" +fechaFin);
         
        $.ajax({

            type: "POST",
            //async: false,
            url: "/validarBusquedaAvanzada.php",

            dataType: "json",

            data: {fechaInicio:fechaInicio, fechaFin:fechaFin},
           
            success : function(data)
            {

                if (data.code == "200")
                {

                    alert("Success: " +data.msg);
                    
                    $("#form1").attr("data-checked","1");

                      // submit
                      $('#form1').unbind().submit();
                } 
                else 
                {

                    //$(".errores").html("<ul>"+data.msg+"</ul>");
                  alert("HAY ERRORES DESPUES DE VALIDAR: " +data.msg);
                    //$(".display-error").css("display","block");

                }

            }

        });
          e.preventDefault();
        
      });

  });
*/
// Wait for the DOM to be ready
$(function() 
{
  // Initialize form validation on the registration form.
  // It has the name attribute "registration"
  $("form[name='busquedaAvanzada']").validate({
    // Specify validation rules
    rules: {
      // The key name on the left side is the name attribute
      // of an input field. Validation rules are defined
      // on the right side
      fechaInicio: 
      {
        required: function(element)
          {
            return $("#fechaFin").val().length > 0;
           }
                  
      },
      fechaFin: 
      {
   
                   required: function(element)
                   {
            return $("#fechaInicio").val().length > 0;
                  }
        }
    },//fin de rules
    // Specify validation error messages
    messages: 
    {
      fechaInicio: "Aviso: debe ingresar una fecha final del rango",
      fechaFin: "Aviso: debe ingresar una fecha inicial del rango"
    },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
      form.submit();
    }
  });
});

$('#ley').change(function() 
{
	var ley=$("#ley").val();
	//console.log("Hola");
       var prohibicionesDerogadas = document.getElementById("prohibicionesDerogadas");
		var prohibicionesVigentes = document.getElementById("prohibicionesVigentes");
		var deberesDerogados = document.getElementById("deberesDerogados");	
		var deberesVigentes = document.getElementById("deberesVigentes");			
		if(ley.localeCompare("Ley vigente")==0)
		{
			if (prohibicionesVigentes.style.display === "none") 
			{
				$(prohibicionesVigentes).show('slow');
			}
			if (deberesVigentes.style.display === "none") 
			{
				$(deberesVigentes).show('slow');
			}			
		}
		else
			{
				
				$(prohibicionesVigentes).hide('fast');
				$('#prohibicionesVigentes').val('');
				$(deberesVigentes).hide('fast');
				$('#deberesVigentes').val('');
				//console.log("despues mubi: "+$('#municipio').val());
			}
				
		
		/////////////
		if(ley.localeCompare("Ley derogada")==0)
		{
			if (prohibicionesDerogadas.style.display === "none") 
			{
				$(prohibicionesDerogadas).show('slow');
			}
			if (deberesDerogados.style.display === "none") 
			{
				$(deberesDerogados).show('slow');
			}			
		}
		else
			{
				
				$(prohibicionesDerogadas).hide('fast');
				$('#prohibicionesDerogadas').val('');
				$(deberesDerogados).hide('fast');
				$('#deberesDerogados').val('');
				//console.log("despues mubi: "+$('#municipio').val());
			}
		
    });
