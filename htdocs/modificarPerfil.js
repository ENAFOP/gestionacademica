///////////////////////////////////////////////////////////////////////////////////// 
$( document ).ready(function() 
{
$.fn.datepicker.defaults.autoclose = true;
///////**********************************************************************  EDITABLES******************************************************************
$.fn.editable.defaults.mode = 'inline';
var currentTime = new Date();
var anoActual = currentTime.getFullYear();

	$('[id^="nombre"]').editable({
			params: function(params) {  //params already contain `name`, `value` and `pk`
			var data = {};
			data['pk'] = params.pk;
			data['name'] = params.name;
			data['value'] = params.value;
			return data;
		  }
        });
	$('[id^="descripcion"]').editable({
			params: function(params) {  //params already contain `name`, `value` and `pk`
			var data = {};
			data['pk'] = params.pk;
			data['name'] = params.name;
			data['value'] = params.value;
			return data;
		  }
        });
	$('[id^="empresa"]').editable({
			params: function(params) {  //params already contain `name`, `value` and `pk`
			var data = {};
			data['pk'] = params.pk;
			data['name'] = params.name;
			data['value'] = params.value;
			return data;
		  }
        });

	$('[id^="costo"]').editable({
			params: function(params) {  //params already contain `name`, `value` and `pk`
			var data = {};
			data['pk'] = params.pk;
			data['name'] = params.name;
			data['value'] = params.value;
			return data;
		  }
        });

	$('[id^="costo_compra"]').editable({
			params: function(params) {  //params already contain `name`, `value` and `pk`
			var data = {};
			data['pk'] = params.pk;
			data['name'] = params.name;
			data['value'] = params.value;
			return data;
		  }
        });

	$('[id^="origen_fondos"]').editable({
			params: function(params) {  //params already contain `name`, `value` and `pk`
			var data = {};
			data['pk'] = params.pk;
			data['name'] = params.name;
			data['value'] = params.value;
			return data;
		  }
        });

	$('[id^="comentarios"]').editable({
			params: function(params) {  //params already contain `name`, `value` and `pk`
			var data = {};
			data['pk'] = params.pk;
			data['name'] = params.name;
			data['value'] = params.value;
			return data;
		  }
        });
	///////////////EDITAR PROYECTO

$('[id^="origen_fondos"]').editable({
			params: function(params) {  //params already contain `name`, `value` and `pk`
			var data = {};
			data['pk'] = params.pk;
			data['name'] = params.name;
			data['value'] = params.value;
			return data;
		  }
        });
$('[id^="codigo_setefe"]').editable({
			params: function(params) {  //params already contain `name`, `value` and `pk`
			var data = {};
			data['pk'] = params.pk;
			data['name'] = params.name;
			data['value'] = params.value;
			return data;
		  }
        });
$('[id^="monto_total"]').editable({
			params: function(params) {  //params already contain `name`, `value` and `pk`
			var data = {};
			data['pk'] = params.pk;
			data['name'] = params.name;
			data['value'] = params.value;
			return data;
		  }
        });
$('[id^="monto_bienes"]').editable({
			params: function(params) {  //params already contain `name`, `value` and `pk`
			var data = {};
			data['pk'] = params.pk;
			data['name'] = params.name;
			data['value'] = params.value;
			return data;
		  }
        });
$('[id^="monto_materiales"]').editable({
			params: function(params) {  //params already contain `name`, `value` and `pk`
			var data = {};
			data['pk'] = params.pk;
			data['name'] = params.name;
			data['value'] = params.value;
			return data;
		  }
        });
	$('[id^="fecha_finalizacion"]').editable({
        format: 'YYYY-MM-DD',
		viewformat: 'DD.MM.YYYY',
		  combodate: {
			minYear: 2019,
			maxYear: 2030,
			}
        });


	///////////////// FIN EDITAR PROYECTO

// 	$('[id^="funciones"]').editable({
// 			params: function(params) {  //params already contain `name`, `value` and `pk`
// 			var data = {};
// 			data['pk'] = params.pk;
// 			data['name'] = params.name;
// 			data['value'] = params.value;
// 			data['idpostulacion'] = idpostulacion;
// 			data['estadopostulacion'] = estadopostulacion;
// 			return data;
// 		  }
//         });
// 	//$('[id^="institucion"]').editable();
// 	 $('[id^="anoinicio"]').editable({
//         format: 'YYYY-MM-DD',
// 		  viewformat: 'DD.MM.YYYY',
// 		  combodate: {
// 			minYear: 1940,
// 			maxYear: anoActual,
// 			}
//         });
// 	$('[id^="anofin"]').editable({
//         format: 'YYYY-MM-DD',
// 		viewformat: 'DD.MM.YYYY',
// 		  combodate: {
// 			minYear: 1940,
// 			maxYear: anoActual,
// 			}
//         });
// 		$('[id^="fechainicio"]').editable({
//         format: 'YYYY-MM-DD',
// 		viewformat: 'DD.MM.YYYY',
// 		  combodate: {
// 			minYear: 1940,
// 			maxYear: anoActual,
// 			}
//         });
// 		$('[id^="fechafin"]').editable({
//         format: 'YYYY-MM-DD',
// 		viewformat: 'DD.MM.YYYY',
// 		  combodate: {
// 			minYear: 1940,
// 			maxYear: anoActual,
// 			}
//         });
		
// 		$('[id^="titulo"]').editable({
// 			params: function(params) {  //params already contain `name`, `value` and `pk`
// 			var data = {};
// 			data['pk'] = params.pk;
// 			data['name'] = params.name;
// 			data['value'] = params.value;
// 			data['idpostulacion'] = idpostulacion;
// 			data['estadopostulacion'] = estadopostulacion;
// 			return data;
// 		  }
//         });
// 		$('[id^="nombretitulo"]').editable({
// 			params: function(params) {  //params already contain `name`, `value` and `pk`
// 			var data = {};
// 			data['pk'] = params.pk;
// 			data['name'] = params.name;
// 			data['value'] = params.value;
// 			data['idpostulacion'] = idpostulacion;
// 			data['estadopostulacion'] = estadopostulacion;
// 			return data;
// 		  }
//         });
// 		$('[id^="ano"]').editable({
// 			params: function(params) {  //params already contain `name`, `value` and `pk`
// 			var data = {};
// 			data['pk'] = params.pk;
// 			data['name'] = params.name;
// 			data['value'] = params.value;
// 			data['idpostulacion'] = idpostulacion;
// 			data['estadopostulacion'] = estadopostulacion;
// 			return data;
// 		  }
//         });;
// 		$('[id^="institucion"]').editable({
// 			params: function(params) {  //params already contain `name`, `value` and `pk`
// 			var data = {};
// 			data['pk'] = params.pk;
// 			data['name'] = params.name;
// 			data['value'] = params.value;
// 			data['idpostulacion'] = idpostulacion;
// 			data['estadopostulacion'] = estadopostulacion;
// 			return data;
// 		  }
//         });
//         //para pestaña 4
//         $('[id^="conocimientos"]').editable({
// 			params: function(params) {  //params already contain `name`, `value` and `pk`
// 			var data = {};
// 			data['pk'] = params.pk;
// 			data['name'] = params.name;
// 			data['value'] = params.value;
// 			data['idpostulacion'] = idpostulacion;
// 			data['estadopostulacion'] = estadopostulacion;
// 			return data;
// 		  }
//         });
// 		//////editable para pestaña 5
// 		$('[id^="materia"]').editable({
// 			params: function(params) {  //params already contain `name`, `value` and `pk`
// 			var data = {};
// 			data['pk'] = params.pk;
// 			data['name'] = params.name;
// 			data['value'] = params.value;
// 			data['idpostulacion'] = idpostulacion;
// 			data['estadopostulacion'] = estadopostulacion;
// 			return data;
// 		  }
//         });
		
// 		$('[id^="modalidad"]').editable({
// 			params: function(params) {  //params already contain `name`, `value` and `pk`
// 			var data = {};
// 			data['pk'] = params.pk;
// 			data['name'] = params.name;
// 			data['value'] = params.value;
// 			data['idpostulacion'] = idpostulacion;
// 			data['estadopostulacion'] = estadopostulacion;			
// 			return data;
// 		  }
	
//         });
// 		//para pestaña 6
// 		$('[id^="taller"]').editable({
// 			params: function(params) {  //params already contain `name`, `value` and `pk`
// 			var data = {};
// 			data['pk'] = params.pk;
// 			data['name'] = params.name;
// 			data['value'] = params.value;
// 			data['idpostulacion'] = idpostulacion;
// 			data['estadopostulacion'] = estadopostulacion;
// 			return data;
// 		  }
//         });
// 		$('[id^="totalhoras"]').editable({
// 			params: function(params) {  //params already contain `name`, `value` and `pk`
// 			var data = {};
// 			data['pk'] = params.pk;
// 			data['name'] = params.name;
// 			data['value'] = params.value;
// 			data['idpostulacion'] = idpostulacion;
// 			data['estadopostulacion'] = estadopostulacion;
// 			return data;
// 		  }
//         });
// 		//pestaña 8
// 		$('[id^="relevante"]').editable({
// 			params: function(params) {  //params already contain `name`, `value` and `pk`
// 			var data = {};
// 			data['pk'] = params.pk;
// 			data['name'] = params.name;
// 			data['value'] = params.value;
// 			data['idpostulacion'] = idpostulacion;
// 			data['estadopostulacion'] = estadopostulacion;
// 			return data;
// 		  }
//         });
// 		$('[id^="prezi"]').editable({
// 			params: function(params) {  //params already contain `name`, `value` and `pk`
// 			var data = {};
// 			data['pk'] = params.pk;
// 			data['name'] = params.name;
// 			data['value'] = params.value;
// 			data['idpostulacion'] = idpostulacion;
// 			data['estadopostulacion'] = estadopostulacion;
// 			return data;
// 		  }
//         });
		
	
// 	///////////////////////
// 	$('#paisResidencia').change(function() 
// 	{
// 		var pais=$("#paisResidencia").val();
// 		   var x = document.getElementById("divDepartamentos");
// 			var y = document.getElementById("divMunicipios");	
// 			if(pais.localeCompare("El Salvador")==0)
// 			{
// 				if (x.style.display === "none") 
// 				{
// 					//pasos si el pais de residencia era extranjero antes y se muda a el salvador: 1) muestro departamentos 2) a departamento elegido meter municpios
// 					$(x).show('slow');						

// 				}				
// 			}
// 			else
// 				{
					
// 					$(x).hide('slow');
// 					$('#departamento').val('');
// 					$(y).hide('slow');
// 					$('#municipio').val('');
// 					console.log("despues mubi: "+$('#municipio').val());
// 				}
// 		});
	
// $('#departamento').change(function() 
// {
// 	console.log("cambio en departamento");
// 	var depar=$("#departamento").val();
// 	$.ajax({
//                         url:"/response.php?departamento="+depar,
//                         success:function(result)
//                         {
							
//                                 var codificar=JSON.stringify(result);
// 								var muni=$("#municipio").val();
// 							    var parsear = JSON.parse(codificar); 
// 								//var muniElegido='<option  selected value="'+muni+'">'+muni+'</option>';
// 								var selectBonito='<label for="municipio">Municipio</label>   <select class="form-control chzn-select" id="municipio" name="municipio">'
// 							    for(var i=0;i<parsear.length;i++)
// 							   {
// 								   console.log("Codificar i: "+parsear[i]);
// 									selectBonito=selectBonito+parsear[i];
// 							   }
// 							    selectBonito=selectBonito+'</select>';
//                                document.getElementById('municipio').outerHTML = selectBonito;                             
// 							   var munis = document.getElementById("divMunicipios");
// 							   $(munis).show('slow');
//                         }
//                     }); //fin del ajax
//     });
	
	

// 	////////////////////////////// CAMBIOS EN PESTAÑA 1
// 	var editePestana1=false;
// 	$("#editarPestana1").click(function()
// 	{
// 		document.getElementById('edad').disabled = false;
// 		document.getElementById('paisResidencia').disabled = false;
// 		document.getElementById('nit').disabled = false;
// 		document.getElementById('telefono').disabled = false;
// 		document.getElementById('correo').disabled = false;
// 		document.getElementById('numeroDocumento').disabled = false;
// 		document.getElementById('tipoDocumento').disabled = false;	
// 		document.getElementById('genero').disabled = false;
// 		document.getElementById('departamento').disabled = false;
// 		document.getElementById('municipio').disabled = false;
// 			var depar=$("#departamento").val();

// 			var muni=$("#municipio").val();
// 			//muni=muni.replace(/['"]+/g, '');
// 		if(depar.localeCompare("")!=0)
// 		{
// 			$.ajax({
// 							url:"/response.php?departamento="+depar,
// 							success:function(result)
// 							{
// 								   var codificar=JSON.stringify(result);
// 								    var parsear = JSON.parse(codificar); 
// 								var muniElegido='<option  selected value="'+muni+'">'+muni+'</option>';
// 								 var selectBonito='<label for="municipio">Municipio</label>   <select class="form-control chzn-select" id="municipio" name="municipio">'+muniElegido;
// 								   for(var i=0;i<parsear.length;i++)
// 								   {
// 									   console.log("Codificar i: "+parsear[i]);
// 									    selectBonito=selectBonito+parsear[i];
// 								   }
// 								   //alert('codificar '+codificar);
// 								  selectBonito=selectBonito+'</select>';
								 
// 								  console.log("Mun elegido: "+muniElegido);
// 								   //var selectBonito='<label for="municipio">Municipio</label>   <select class="form-control chzn-select" id="municipio" name="municipio">'+muniElegido+codificar+'</select>';
// 								   console.log("select bonito: "+selectBonito);
// 								   document.getElementById('divMunicipios').innerHTML = selectBonito;                             
// 								  $(".chzn-select").trigger("liszt:updated");
// 							}
// 						}); //fin del ajax
// 		}
// 		editePestana1=true;
// 	});
	
// 	//
	
// 	$("#aplicarPestana1").click(function(){
// 		if(editePestana1==true)
// 		{
// 				$.validator.addMethod("regx", function(value, element, regexpr) {          
//     return regexpr.test(value);
// }, "Ingrese un formato de NIT válido: 0101-010101-101-1");
//     $('#formularioModificacion').validate({
//          ignore: '',
// 		rules: {

// 			nit:
// 			{
// 				regx: /^[0-9]{4}[-][0-9]{6}[-][0-9]{3}[-][0-9]{1}$/
// 			}
//         },
// 		messages: 
// 		{
			
// 		},
//         submitHandler: function (form) { // for demo
//             alert('Pestaña 1 datos correctos.');
// 			 form.submit();
//         }
//     });
// 			var idpostulante=document.getElementById('idpostulante').value;
// 			var idpostulacion=document.getElementById('idpostulacion').value;
// 			var estadoPostulacion=document.getElementById('estadopostulacion').value;
// 			var numeroDocumento=document.getElementById('numeroDocumento').value;
// 			var paisResidencia=document.getElementById('paisResidencia').value;
// 			var nit=document.getElementById('nit').value;
// 			var telefono=document.getElementById('telefono').value;
// 			var correo=document.getElementById('correo').value;
// 			var tipoDocumento=document.getElementById('tipoDocumento').value;
// 			var numeroDocumento=document.getElementById('numeroDocumento').value;
// 			var genero=document.getElementById('genero').value;
// 			var edad=document.getElementById('edad').value;
// 			var departamento=document.getElementById('departamento').value;
// 			var municipio=document.getElementById('municipio').value;
// 			console.log("Aplicar cambios: Municipio "+municipio);
// 			if(edad<18)
// 			{
// 				alert("Edad introducida menor a 18. Cambios no realizados");
// 				return false;
// 			}
			
// 			$.ajax({
// 				url:"/actualizarBD.php?idpostulante="+idpostulante+"&pestana="+1+"&paisResidencia="+paisResidencia+"&nit="+nit+"&telefono="+telefono+"&correo="+correo+"&tipoDocumento="+tipoDocumento+"&numeroDocumento="+numeroDocumento+"&estadoPostulacion="+estadoPostulacion+"&idpostulacion="+idpostulacion+"&genero="+genero+"&edad="+edad+"&departamento="+departamento+"&municipio="+municipio,
// 				success:function(result)
// 				{
// 					   //var codificar=JSON.stringify(result);
// 					   console.log("Cambios guardados correctamente en la base de datos para pestaña 1s");	
// 				}
// 			}); //fin del ajax
			
// 		}
		
// 	});
	
// 	////////////////////////// PESTAÑA 2		
// 	$("#aplicarPestana2").click(function()
// 	{
// 		console.log("Añadiendo a pestaña 2");
// 		var nuevosCargos=document.getElementsByName("cargo[]");
// 		var nuevasFunciones=document.getElementsByName("funciones[]");
// 		var nuevasInstituciones=document.getElementsByName("institucion[]");
// 		var nuevosIniciales=document.getElementsByName("periodoInicial[]");
// 		var nuevosFinales=document.getElementsByName("periodoFinal[]");
// 		 $("[name^=cargo]").each(function () {
//             $(this).rules("add", {
//                 required: true,           
//                 messages: 
// 				{
//                      required:"Debe precisar el nombre o breve descripción del cargo"
//                 }
//             });
//         });
// 		$("[name^=funciones]").each(function () {
//             $(this).rules("add", {
//                 required: true,           
//                 messages: 
// 				{
//                      required:"Debe indicar brevemente las funciones desempeñadas en ese cargo"
//                 }
//             });
//         });
// 		$("[name^=institucion]").each(function () {
//             $(this).rules("add", {
//                 required: true,           
//                 messages: 
// 				{
//                      required:"Debe indicar la institución donde desempeñó el cargo"
//                 }
//             });
//         });
// 		$("[name^=periodoInicial]").each(function () {
//             $(this).rules("add", {
//                 required: true,           
//                 messages: 
// 				{
//                      required:"Seleccione una fecha de inicio del cargo"
//                 }
//             });
//         });
// 		$("[name^=periodoFinal]").each(function () {
//             $(this).rules("add", {
//                 required: true,           
//                 messages: 
// 				{
//                      required:"Seleccione fecha final del cargo."
//                 }
//             });
//         });
// 		var validator = $("#formularioModificacion").validate();
// 		var longi=nuevosCargos.length;
// 		for(var i=0;i<longi;i++)
// 		{						
// 		   var valCargos=validator.element(nuevosCargos[i]);
// 		   var valFunciones=validator.element(nuevasFunciones[i]);
// 		   var valInstituciones=validator.element(nuevasInstituciones[i]);
// 		   var valIni=validator.element(nuevosIniciales[i]);
// 		   var valFini=validator.element(nuevosFinales[i]);
		   
// 		} 
// 		if(valCargos==true && valFunciones==true && valInstituciones==true  && valIni==true && valFini==true)
// 		{
// 			//console.log("Todo correcto nuevos cargos");
// 			for(var i=0;i<nuevosCargos.length;i++)
// 			{
// 					var cargo=nuevosCargos[i].value;
// 					var funciones=nuevasFunciones[i].value;
// 					var institucion=nuevasInstituciones[i].value;
// 					var inicio=nuevosIniciales[i].value;
// 					var fin=nuevosFinales[i].value;
// 					$.ajax({
// 							url:"/anadirCargos.php?cargo="+cargo+"&funciones="+funciones+"&institucion="+institucion+"&anoInicio="+inicio+"&anoFin="+fin,
// 							success:function(result)
// 							{
								
// 							}
// 						}); //fin del ajax
				
// 		}
// 		//console.log("Añadidos correctamente");
// 		alert("Datos añadidos correctamente a la Base de Datos. La página se actualizará ahora.");
// 		location.reload();
// 		}
		
		
// 	});	
	
// 	////////////////////// FIN PESTAÑA 2
	
// 	////////////////////// INICIO PESTAÑA 3
	
// 	$("#aplicarPestana31").click(function()
// 	{
		
// 		var nuevosTitulosGrado=document.getElementsByName("tituloGrado[]");
// 		var nuevosNombresTitulosGrado=document.getElementsByName("nombreTituloGrado[]");
// 		var nuevosAnosGrado=document.getElementsByName("anoGrado[]");
// 		var nuevosInstiGrado=document.getElementsByName("institucionGrado[]");
// 		var nuevosAtestaGrado=document.getElementsByName("atestadoGrado[]");
// 		 $("[name^=tituloGrado]").each(function () {
//             $(this).rules("add", {
//                 required: true,           
//                 messages: 
// 				{
//                      required:"Debe precisar tipo de título"
//                 }
//             });
//         });
// 		$("[name^=nombreTituloGrado]").each(function () {
//             $(this).rules("add", {
//                 required: true,           
//                 messages: 
// 				{
//                      required:"Debe indicar nombre del título"
//                 }
//             });
//         });
// 		$("[name^=anoGrado]").each(function () {
//             $(this).rules("add", {
//                 required: true,           
//                 messages: 
// 				{
//                      required:"Debe indicar el año de obtención del título"
//                 }
//             });
//         });
// 		$("[name^=institucionGrado]").each(function () {
//             $(this).rules("add", {
//                 required: true,           
//                 messages: 
// 				{
//                      required:"Ingrese nombre de la institución"
//                 }
//             });
//         });
// 		$("[name^=atestadoGrado]").each(function () {
//             $(this).rules("add", {
//                 required: true,           
//                 messages: 
// 				{
//                      required:"Seleccione atestado."
//                 }
//             });
//         });
// 		var validator = $("#formPestana3").validate();
// 		var longi=nuevosTitulosGrado.length;
// 		//console.log("Longi: "+longi);
// 		for(var i=0;i<longi;i++)
// 		{						
// 		   var a=validator.element(nuevosTitulosGrado[i]);
// 		   var b=validator.element(nuevosNombresTitulosGrado[i]);
// 		   var c=validator.element(nuevosInstiGrado[i]);
// 		   var d=validator.element(nuevosAtestaGrado[i]);
// 		   var e=validator.element(nuevosAnosGrado[i]);
		   
// 		} 
// 		//console.log("a,b,c,d,e: "+a+b+c+d+e);
// 		if(a==true && b==true && c==true && d==true && e==true)
// 		{
// 			alert("Ahora se añadirán los nuevos elementos a su formación de grado.");
// 			document.getElementById("formPestana3").submit();
// 		}			
// 	});	
// 	//////////////////////////////////////////////////////////////////////////////
// 	$("#aplicarPestana32").click(function()
// 	{
// 		var validator = $("#formPestana3").validate();
// 		var titulo=document.getElementsByName("tituloPosgrado[]");
// 		var nombre=document.getElementsByName("nombreTituloPosGrado[]");
// 		var ano=document.getElementsByName("anoPosgrado[]");
// 		var institucion=document.getElementsByName("institucionPosgrado[]");
// 		var atestado=document.getElementsByName("atestadoPosgrado[]");
// 		 $("[name^=tituloPosgrado]").each(function () {
//             $(this).rules("add", {
//                 required: true,           
//                 messages: 
// 				{
//                      required:"Debe precisar tipo de título"
//                 }
//             });
//         });
// 		$("[name^=nombreTituloPosGrado]").each(function () {
//             $(this).rules("add", {
//                 required: true,           
//                 messages: 
// 				{
//                      required:"Debe indicar nombre del título"
//                 }
//             });
//         });
// 		$("[name^=anoPosgrado]").each(function () {
//             $(this).rules("add", {
//                 required: true,           
//                 messages: 
// 				{
//                      required:"Debe indicar el año de obtención del título"
//                 }
//             });
//         });
// 		$("[name^=institucionPosgrado]").each(function () {
//             $(this).rules("add", {
//                 required: true,           
//                 messages: 
// 				{
//                      required:"Ingrese nombre de la institución"
//                 }
//             });
//         });
// 		$("[name^=atestadoPosgrado]").each(function () {
//             $(this).rules("add", {
//                 required: true,           
//                 messages: 
// 				{
//                      required:"Seleccione atestado."
//                 }
//             });
//         });
		
// 		var longi=titulo.length;
// 		for(var i=0;i<longi;i++)
// 		{						
// 		   var a=validator.element(titulo[i]);
// 		   var b=validator.element(nombre[i]);
// 		   var c=validator.element(ano[i]);
// 		   var d=validator.element(institucion[i]);
// 		   var e=validator.element(atestado[i]);
		   
// 		}
// 		if(a==true && b==true && c==true && d==true && e==true)
// 		{
// 			alert("Ahora se añadirán los nuevos elementos a su formación de posgrado.");
// 			document.getElementById("formPestana3").submit();
// 		} 		
// 	});
// 	//////////////////////////////////////////////////////////////////////////////
// 	$("#aplicarPestana33").click(function()
// 	{
// 		var validator = $("#formPestana3").validate();
// 		var titulo=document.getElementsByName("tituloOtros[]");
// 		var nombre=document.getElementsByName("nombreTituloOtros[]");
// 		var ano=document.getElementsByName("anoOtros[]");
// 		var institucion=document.getElementsByName("institucionOtros[]");
// 		var atestado=document.getElementsByName("atestadoOtros[]");
// 		 $("[name^=tituloOtros]").each(function () {
//             $(this).rules("add", {
//                 required: true,           
//                 messages: 
// 				{
//                      required:"Debe precisar tipo de título"
//                 }
//             });
//         });
// 		$("[name^=nombreTituloOtros]").each(function () {
//             $(this).rules("add", {
//                 required: true,           
//                 messages: 
// 				{
//                      required:"Debe indicar nombre del título"
//                 }
//             });
//         });
// 		$("[name^=anoOtros]").each(function () {
//             $(this).rules("add", {
//                 required: true,           
//                 messages: 
// 				{
//                      required:"Debe indicar el año de obtención del título"
//                 }
//             });
//         });
// 		$("[name^=institucionOtros]").each(function () {
//             $(this).rules("add", {
//                 required: true,           
//                 messages: 
// 				{
//                      required:"Ingrese nombre de la institución"
//                 }
//             });
//         });
// 		$("[name^=atestadoOtros]").each(function () {
//             $(this).rules("add", {
//                 required: true,           
//                 messages: 
// 				{
//                      required:"Seleccione atestado."
//                 }
//             });
//         });
		
// 		var longi=titulo.length;
// 		for(var i=0;i<longi;i++)
// 		{						
// 		   var a=validator.element(titulo[i]);
// 		   var b=validator.element(nombre[i]);
// 		   var c=validator.element(ano[i]);
// 		   var d=validator.element(institucion[i]);
// 		   var e=validator.element(atestado[i]);
		   
// 		}
// 		if(a==true && b==true && c==true && d==true && e==true)
// 		{
// 			alert("Ahora se añadirán los nuevos elementos a su formación de otros estudios.");
// 			document.getElementById("formPestana3").submit();
// 		} 		
// 	});	
// 	///////////////////////////////////////

//   $('#aplicarPestana4').on('click', function () 
// 	{
// 		//console.log("PASO DE 4 A 5");
// 		var puedoPasar=true;
// 	   //para pasar de la tab 4 a la 5, debo comprobar que cada radio cuyo valor sea sí, no esté vacia la lista de seleccionç
// 	   //1: gerencia pública:
// 	    var validator = $("#formPestana4").validate();
// 	     valor=($('input[name=gerenciaPublica]:checked').val());
// 			//console.log("valor de gerencia pública: "+valor);
// 			if(valor.localeCompare("si")==0)
// 			{
// 				//console.log("el valor es si EN EVENTO CLICK GERENCIA");
// 				$("[name^=temasGerencia]").each(function () {
// 				$(this).rules("add", {
// 					required: true,           
// 					messages: 
// 					{
// 						 required:"Debe seleccionar de la lista los temas de gerencia pública que asegura conocer"
// 					}
// 				});
// 			});
//             var ger=validator.element('[name^="temasGerencia"]'); //console.log("cargo: "+cargo);
// 			if(!ger)
// 			{
// 					puedoPasar=false;
// 			}
// 		}
// 		//2: planificacion para el desarrollo
// 	    var validator = $("#formPestana4").validate();
// 	     valor=($('input[name=planificacionDesarrollo]:checked').val());
// 			if(valor.localeCompare("si")==0)
// 			{
// 				$("[name^=temasPlanificacion]").each(function () {
// 				$(this).rules("add", {
// 					required: true,           
// 					messages: 
// 					{
// 						 required:"Debe seleccionar de la lista los temas de planificación para el desarollo que asegura conocer"
// 					}
// 				});
// 			});
//             var ger=validator.element('[name^="temasPlanificacion"]'); //console.log("cargo: "+cargo);
// 			if(!ger)
// 			{
// 					puedoPasar=false;
// 			}
// 		}
// 		//3: gestión del talento humano
// 	    var validator = $("#formPestana4").validate();
// 	     valor=($('input[name=gestionTalento]:checked').val());
// 			if(valor.localeCompare("si")==0)
// 			{
// 				$("[name^=temasTalento]").each(function () {
// 				$(this).rules("add", {
// 					required: true,           
// 					messages: 
// 					{
// 						 required:"Debe seleccionar de la lista los temas de gestión del talento humano que asegura conocer"
// 					}
// 				});
// 			});
//             var ger=validator.element('[name^="temasTalento"]'); //console.log("cargo: "+cargo);
// 			if(!ger)
// 			{
// 					puedoPasar=false;
// 			}
// 		}
// 		//4: Gobierno y territorio
// 	    var validator = $("#formPestana4").validate();
// 	     valor=($('input[name=gobiernoTerritorio]:checked').val());
// 			if(valor.localeCompare("si")==0)
// 			{
// 				$("[name^=temasGobierno]").each(function () {
// 				$(this).rules("add", {
// 					required: true,           
// 					messages: 
// 					{
// 						 required:"Debe seleccionar de la lista los temas de Gobierno y territorio que asegura conocer"
// 					}
// 				});
// 			});
//             var ger=validator.element('[name^="temasGobierno"]'); //console.log("cargo: "+cargo);
// 			if(!ger)
// 			{
// 					puedoPasar=false;
// 			}
// 		}
		
// 		//5: Ética y transparencia en la gestión pública
// 	    var validator = $("#formPestana4").validate();
// 	     valor=($('input[name=etica]:checked').val());
// 			if(valor.localeCompare("si")==0)
// 			{
// 				$("[name^=temasEtica]").each(function () {
// 				$(this).rules("add", {
// 					required: true,           
// 					messages: 
// 					{
// 						 required:"Debe seleccionar de la lista los temas de Ética y transparencia en la gestión pública que asegura conocer"
// 					}
// 				});
// 			});
//             var ger=validator.element('[name^="temasEtica"]'); //console.log("cargo: "+cargo);
// 			if(!ger)
// 			{
// 					puedoPasar=false;
// 			}
// 		}
		
// 		//6: Gobierno electrónico
// 	    var validator = $("#formPestana4").validate();
// 	     valor=($('input[name=gobiernoElectronico]:checked').val());
// 			if(valor.localeCompare("si")==0)
// 			{
// 				$("[name^=temasElectronico]").each(function () {
// 				$(this).rules("add", {
// 					required: true,           
// 					messages: 
// 					{
// 						 required:"Debe seleccionar de la lista los temas de Gobierno electrónico que asegura conocer"
// 					}
// 				});
// 			});
//             var ger=validator.element('[name^="temasElectronico"]'); //console.log("cargo: "+cargo);
// 			if(!ger)
// 			{
// 					puedoPasar=false;
// 			}
// 		}
// 		//7: Gobierno abierto y participación ciudadana
// 	    var validator = $("#formPestana4").validate();
// 	     valor=($('input[name=gobiernoAbierto]:checked').val());
// 			if(valor.localeCompare("si")==0)
// 			{
// 				$("[name^=temasAbierto]").each(function () {
// 				$(this).rules("add", {
// 					required: true,           
// 					messages: 
// 					{
// 						 required:"Debe seleccionar de la lista los temas de Gobierno abierto y participación ciudadana que asegura conocer"
// 					}
// 				});
// 			});
//             var ger=validator.element('[name^="temasAbierto"]'); //console.log("cargo: "+cargo);
// 			if(!ger)
// 			{
// 					puedoPasar=false;
// 			}
// 		}
// 		//8: Gestión de Calidad en el sector público
// 	    var validator = $("#formPestana4").validate();
// 	     valor=($('input[name=gestionCalidad]:checked').val());
// 			if(valor.localeCompare("si")==0)
// 			{
// 				$("[name^=temasCalidad]").each(function () {
// 				$(this).rules("add", {
// 					required: true,           
// 					messages: 
// 					{
// 						 required:"Debe seleccionar de la lista los temas de Gestión de Calidad en el sector público que asegura conocer"
// 					}
// 				});
// 			});
//             var ger=validator.element('[name^="temasCalidad"]'); //console.log("cargo: "+cargo);
// 			if(!ger)
// 			{
// 					puedoPasar=false;
// 			}
// 		}
// 		//9: Enfoque de derechos en la gestión pública
// 	    var validator = $("#formPestana4").validate();
// 	     valor=($('input[name=enfoque]:checked').val());
// 			if(valor.localeCompare("si")==0)
// 			{
// 				$("[name^=temasEnfoque]").each(function () {
// 				$(this).rules("add", {
// 					required: true,           
// 					messages: 
// 					{
// 						 required:"Debe seleccionar de la lista los temas de Enfoque de derechos en la gestión pública que asegura conocer"
// 					}
// 				});
// 			});
//             var ger=validator.element('[name^="temasEnfoque"]'); //console.log("cargo: "+cargo);
// 			if(!ger)
// 			{
// 					puedoPasar=false;
// 			}
// 		}
// 		//10:Relaciones laborales en el sector público
// 	    var validator = $("#formPestana4").validate();
// 	     valor=($('input[name=relaciones]:checked').val());
// 			if(valor.localeCompare("si")==0)
// 			{
// 				$("[name^=temasRelaciones]").each(function () {
// 				$(this).rules("add", {
// 					required: true,           
// 					messages: 
// 					{
// 						 required:"Debe seleccionar de la lista los temas de Relaciones laborales en el sector público que asegura conocer"
// 					}
// 				});
// 			});
//             var ger=validator.element('[name^="temasRelaciones"]'); //console.log("cargo: "+cargo);
// 			if(!ger)
// 			{
// 					puedoPasar=false;
// 			}
// 		}
// 		//11:R Gestión de capacitación en el sector público
// 	    var validator = $("#formPestana4").validate();
// 	     valor=($('input[name=capacitacion]:checked').val());
// 			if(valor.localeCompare("si")==0)
// 			{
// 				$("[name^=temasCapacitacion]").each(function () {
// 				$(this).rules("add", {
// 					required: true,           
// 					messages: 
// 					{
// 						 required:"Debe seleccionar de la lista los temas de Gestión de capacitación en el sector público que asegura conocer"
// 					}
// 				});
// 			});
//             var ger=validator.element('[name^="temasCapacitacion"]'); //console.log("cargo: "+cargo);
// 			if(!ger)
// 			{
// 					puedoPasar=false;
// 			}
// 		}		
// 		/////al final si puedo pasar hago el cambio de tabs
// 		if(puedoPasar)
// 		{
// 			alert("Se añadirán esos temas al registro");
// 			document.getElementById("formPestana4").submit();
// 		}
     
		
//     });	
// /////////////////para tab 4: AL PRESIONAR SOBRE UN TEMA EL BOTÓN "SI" MOSTRARME LA LISTA DE ESOS TEMAS ///////////////
// $('input[name=gerenciaPublica]').click(function() 
// {
// 	console.log("ACTIVADO EVENTO CLICK EN GERENCIA");
//     valor=($('input[name=gerenciaPublica]:checked').val());
// 	console.log("valor de gerencia pública: "+valor);
// 	var x = document.getElementById("mostrarGerencia");
// 	if(valor.localeCompare("si")==0)
// 	{
// 		console.log("el valor es si EN EVENTO CLICK GERENCIA");
		 
// 		if (x.style.display === "none") 
// 		{
// 			$(x).show('slow');
// 		} 		
// 	}	
// 	else
// 	{		
	
// 		$(x).hide('slow');				
// 	}
// });
// ///////////////////////////////////////
// $('input[name=planificacionDesarrollo]').click(function() 
// {
//     valor=($('input[name=planificacionDesarrollo]:checked').val());
// 	//console.log("valor de gerencia pública: "+valor);
// 	var x = document.getElementById("mostrarPlanificacion");
// 	if(valor.localeCompare("si")==0)
// 	{
// 		//console.log("el valor es si");
		 
// 		if (x.style.display === "none") 
// 		{
// 			$(x).show('slow');
// 		} 		
// 	}	
// 	else
// 	{		
// 		$(x).hide('slow');		
// 	}
// });
// ///////////////////////////////////////
// $('input[name=gestionTalento]').click(function() 
// {
//     valor=($('input[name=gestionTalento]:checked').val());
// 	//console.log("valor de gerencia pública: "+valor);
// 	var x = document.getElementById("mostrarTalento");
// 	if(valor.localeCompare("si")==0)
// 	{
// 		//console.log("el valor es si");
		 
// 		if (x.style.display === "none") 
// 		{
// 			$(x).show('slow');
// 		} 		
// 	}	
// 	else
// 	{		
// 		$(x).hide('slow');		
// 	}
// });
// ///////////////////////////////////////
// $('input[name=gobiernoTerritorio]').click(function() 
// {
//     valor=($('input[name=gobiernoTerritorio]:checked').val());
// 	//console.log("valor de gerencia pública: "+valor);
// 	var x = document.getElementById("mostrarGobierno");
// 	if(valor.localeCompare("si")==0)
// 	{
// 		//console.log("el valor es si");
		 
// 		if (x.style.display === "none") 
// 		{
// 			$(x).show('slow');
// 		} 		
// 	}	
// 	else
// 	{		
// 		$(x).hide('slow');		
// 	}
// });
// ///////////////////////////////////////
// $('input[name=etica]').click(function() 
// {
//     valor=($('input[name=etica]:checked').val());
// 	//console.log("valor de gerencia pública: "+valor);
// 	var x = document.getElementById("mostrarEtica");
// 	if(valor.localeCompare("si")==0)
// 	{
// 		//console.log("el valor es si");
		 
// 		if (x.style.display === "none") 
// 		{
// 			$(x).show('slow');
// 		} 		
// 	}	
// 	else
// 	{		
// 		$(x).hide('slow');		
// 	}
// });
// ///////////////////////////////////////
// $('input[name=gobiernoElectronico]').click(function() 
// {
//     valor=($('input[name=gobiernoElectronico]:checked').val());
// 	//console.log("valor de gerencia pública: "+valor);
// 	var x = document.getElementById("mostrarElectronico");
// 	if(valor.localeCompare("si")==0)
// 	{
// 		//console.log("el valor es si");
		 
// 		if (x.style.display === "none") 
// 		{
// 			$(x).show('slow');
// 		} 		
// 	}	
// 	else
// 	{		
// 		$(x).hide('slow');		
// 	}
// });
// ///////////////////////////////////////
// $('input[name=gobiernoAbierto]').click(function() 
// {
//     valor=($('input[name=gobiernoAbierto]:checked').val());
// 	//console.log("valor de gerencia pública: "+valor);
// 	var x = document.getElementById("mostrarAbierto");
// 	if(valor.localeCompare("si")==0)
// 	{
// 		//console.log("el valor es si");
		 
// 		if (x.style.display === "none") 
// 		{
// 			$(x).show('slow');
// 		} 		
// 	}	
// 	else
// 	{		
// 		$(x).hide('slow');		
// 	}
// });
// ///////////////////////////////////////
// $('input[name=gestionCalidad]').click(function() 
// {
//     valor=($('input[name=gestionCalidad]:checked').val());
// 	//console.log("valor de gerencia pública: "+valor);
// 	var x = document.getElementById("mostrarCalidad");
// 	if(valor.localeCompare("si")==0)
// 	{
// 		//console.log("el valor es si");
		 
// 		if (x.style.display === "none") 
// 		{
// 			$(x).show('slow');
// 		} 		
// 	}	
// 	else
// 	{		
// 		$(x).hide('slow');		
// 	}
// });
// ///////////////////////////////////////
// $('input[name=enfoque]').click(function() 
// {
//     valor=($('input[name=enfoque]:checked').val());
// 	//console.log("valor de gerencia pública: "+valor);
// 	var x = document.getElementById("mostrarEnfoque");
// 	if(valor.localeCompare("si")==0)
// 	{
// 		//console.log("el valor es si");
		 
// 		if (x.style.display === "none") 
// 		{
// 			$(x).show('slow');
// 		} 		
// 	}	
// 	else
// 	{		
// 		$(x).hide('slow');		
// 	}
// });
// ///////////////////////////////////////
// $('input[name=relaciones]').click(function() 
// {
//     valor=($('input[name=relaciones]:checked').val());
// 	//console.log("valor de gerencia pública: "+valor);
// 	var x = document.getElementById("mostrarRelaciones");
// 	if(valor.localeCompare("si")==0)
// 	{
// 		//console.log("el valor es si");
		 
// 		if (x.style.display === "none") 
// 		{
// 			$(x).show('slow');
// 		} 		
// 	}	
// 	else
// 	{		
// 		$(x).hide('slow');		
// 	}
// });
// ///////////////////////////////////////
// $('input[name=capacitacion]').click(function() 
// {
//     valor=($('input[name=capacitacion]:checked').val());
// 	//console.log("valor de gerencia pública: "+valor);
// 	var x = document.getElementById("mostrarCapacitacion");
// 	if(valor.localeCompare("si")==0)
// 	{
// 		//console.log("el valor es si");
		 
// 		if (x.style.display === "none") 
// 		{
// 			$(x).show('slow');
// 		} 		
// 	}	
// 	else
// 	{		
// 		$(x).hide('slow');		
// 	}
// });
// 	////////////////////////// PESTAÑA 5		
// 	$("#aplicarPestana5").click(function()
// 	{
// 		console.log("Añadiendo a pestaña 5");
// 		var nuevasMaterias=document.getElementsByName("materia[]");
// 		var nuevasInstituciones=document.getElementsByName("institucionImpartida[]");
// 		var nuevosPeriodosIni=document.getElementsByName("periodoMateriaInicial[]");
// 		var nuevosPeriodosFini=document.getElementsByName("periodoMateriaFinal[]");
// 		var nuevosModalidades=document.getElementsByName("modalidad[]");
// 		var nuevosAtestados=document.getElementsByName("atestadoMateria[]");
// 		 $("[name^=materia]").each(function () {
//             $(this).rules("add", {
//                 required: true,           
//                 messages: 
// 				{
//                      required:"Debe indicar nombre de la materia impartida"
//                 }
//             });
//         });
// 		$("[name^=institucionImpartida]").each(function () {
//             $(this).rules("add", {
//                 required: true,           
//                 messages: 
// 				{
//                      required:"Debe indicar dónde impartió la materia"
//                 }
//             });
//         });
// 		$("[name^=periodoMateriaInicial]").each(function () {
//             $(this).rules("add", {
//                 required: true,           
//                 messages: 
// 				{
//                      required:"Debe indicar fecha de comienzo"
//                 }
//             });
//         });
// 		$("[name^=periodoMateriaFinal]").each(function () {
//             $(this).rules("add", {
//                 required: true,           
//                 messages: 
// 				{
//                      required:"Seleccione la fecha de hoy si sigue en curso"
//                 }
//             });
//         });
// 		$("[name^=modalidad]").each(function () {
//             $(this).rules("add", {
//                 required: true,           
//                 messages: 
// 				{
//                      required:"Seleccione modalidad de la lista"
//                 }
//             });
//         });
// 		$("[name^=atestadoMateria]").each(function () {
//             $(this).rules("add", {
//                 required: true,           
//                 messages: 
// 				{
//                      required:"Seleccione fichero con el atestado"
//                 }
//             });
//         });
// 		var validator = $("#formPestana5").validate();
// 		var longi=nuevasMaterias.length;
// 		for(var i=0;i<longi;i++)
// 		{						
// 		   var a=validator.element(nuevasMaterias[i]);
// 		   var b=validator.element(nuevasInstituciones[i]);
// 		   var c=validator.element(nuevosPeriodosIni[i]);
// 		   var d=validator.element(nuevosPeriodosFini[i]);
// 		   var e=validator.element(nuevosModalidades[i]);
// 		   var f=validator.element(nuevosAtestados[i]);		   
// 		} 
// 		if(a==true && b==true && c==true  && d==true && e==true && f==true)
// 		{
// 		alert("Ahora se añadirán los nuevos elementos a su historial de práctica de la docencia.");
// 			document.getElementById("formPestana5").submit();
// 		}
		
		
// 	});	
	
// 	////////////////////// FIN PESTAÑA 5
	
// 	////////////////////////// PESTAÑA 6		
// 	$("#aplicarPestana6").click(function()
// 	{
// 		console.log("Añadiendo a pestaña 6");
// 	    var validator = $("#formPestana6").validate();
// 		var listaTalleres = document.getElementsByName("nombreTaller[]");
// 		var horasTalleres = document.getElementsByName("totalHoras[]");
// 		var pInicial = document.getElementsByName("periodoTallerInicial[]");
// 		var pFinal = document.getElementsByName("periodoTallerFinal[]");
// 		var institucion = document.getElementsByName("institucionTaller[]");
// 		var modalidad = document.getElementsByName("modalidadTaller[]");
// 		var atestado = document.getElementsByName("atestadoTaller[]");
// 		var longi=listaTalleres.length;
// 		 $("[name^=nombreTaller]").each(function () {
//             $(this).rules("add", {
//                 required: true,           
//                 messages: 
// 				{
//                      required:"Debe indicar el nombre del taller impartido"
//                 }
//             });
//         });
// 		$("[name^=totalHoras]").each(function () {
//             $(this).rules("add", {
//                 required: true,           
//                 messages: 
// 				{
//                      required:"Debe indicar en número, el total de horas del taller impartidas"
//                 }
//             });
//         });
// 		$("[name^=periodoTallerInicial]").each(function () {
//             $(this).rules("add", {
//                 required: true,           
//                 messages: 
// 				{
//                      required:"Seleccione fecha de  inicio de la impartición del  taller"
//                 }
//             });
//         });
// 		$("[name^=periodoTallerFinal]").each(function () {
//             $(this).rules("add", {
//                 required: true,           
//                 messages: 
// 				{
//                      required:"Seleccione fecha de  fin de la impartición del  taller"
//                 }
//             });
//         });
// 		$("[name^=institucionTaller]").each(function () {
//             $(this).rules("add", {
//                 required: true,           
//                 messages: 
// 				{
//                      required:"Seleccione la institución en la cual / para la cual impartió el taller"
//                 }
//             });
//         });
// 		$("[name^=modalidadTaller]").each(function () {
//             $(this).rules("add", {
//                 required: true,           
//                 messages: 
// 				{
//                      required:"Debe indicar la modalidad del taller"
//                 }
//             });
//         })
// 		$("[name^=atestadoTaller]").each(function () {
//             $(this).rules("add", {
//                 required: true,           
//                 messages: 
// 				{
//                      required:"Debe adjuntar el atestado o comprobante de impartición del taller"
//                 }
//             });
//         })
// 		var longi=listaTalleres.length;
// 		for(var i=0;i<longi;i++)
// 		{						
// 		   var valTalleres=validator.element(listaTalleres[i]);
// 		   var valHoras=validator.element(horasTalleres[i]);
// 		   var valIni=validator.element(pInicial[i]);
// 		   var valFini=validator.element(pFinal[i]);
// 		   var valInsti=validator.element(institucion[i]);
// 		   var valModalidad=validator.element(modalidad[i]);
// 		   var valAtesta=validator.element(atestado[i]);
		   
// 		} 
// 		if(valTalleres==true && valHoras==true && valIni==true  && valFini==true && valInsti==true && valModalidad==true && valAtesta==true)
// 		{
// 			alert("Ahora se añadirán los nuevos elementos a su historial de formación y capacitación.");
// 			document.getElementById("formPestana6").submit();
// 		}    			
// 	});

// 	///////////////////////// DE PESTAÑA 7
// 	// A CONTINUACION APARECE PARA LA TAB 7, AL PRESIONAR EN UN CHECKBUTTON QUE SE MUESTREN CAMPOS PARA EXPERIENCIAS
// //71
// $('#metodologiaDiseño').change(function() 
// {
// 	var x = document.getElementById("siete1");
//     if($(this).is(":checked")) 
// 	{			
// 		if (x.style.display === "none") 
// 		{
// 			$(x).show('slow');
// 		}
// 	}
// 	else
// 	{			
// 			$(x).hide('slow');
// 			 var a = document.getElementsByName("metodologiaProgramas[]");
// 			 var b = document.getElementsByName("metodologiaProgramasAtestado[]");
// 			 var longi=a.length;
// 		   //console.log("Longi: "+longi);
// 			   for(var i=0;i<longi;i++)
// 			   {
// 				   //console.log("el area: "+elarea);
// 				   a[i].value="";
// 				   b[i].value="";	
				   
// 				} 
// 	}			              
//     });
               
// //72
// $('#disenoCartas').change(function() 
// {
// 	var x = document.getElementById("siete2");
// 	if($(this).is(":checked")) 
// 	{			
// 		if (x.style.display === "none") 
// 		{
// 			$(x).show('slow');
// 		}
// 	}
// 	else
// 	{			
// 			$(x).hide('slow');
// 			 var a = document.getElementsByName("metodologiaDisenoCartas[]");
// 			 var b = document.getElementsByName("metodologiaDisenoCartasAtestado[]");
// 			 var longi=a.length;
// 		   //console.log("Longi: "+longi);
// 			   for(var i=0;i<longi;i++)
// 			   {
// 				   //console.log("el area: "+elarea);
// 				   a[i].value="";
// 				   b[i].value="";	
				   
// 				} 
		
// 	}  
               
//     });
	
// //73
// $('#evaluacionProcesos').change(function() 
// {
// 	var x = document.getElementById("siete3");
//         if($(this).is(":checked")) 
// 		{
            
			
// 			if (x.style.display === "none") 
// 			{
// 				$(x).show('slow');
// 			}
//         }
// 		else
// 		{			
// 				$(x).hide('slow');
// 				var a = document.getElementsByName("metodologiaEvaluacion[]");
// 			 var b = document.getElementsByName("metodologiaEvaluacionAtestado[]");
// 			 var longi=a.length;
// 		   //console.log("Longi: "+longi);
// 			   for(var i=0;i<longi;i++)
// 			   {
// 				   //console.log("el area: "+elarea);
// 				   a[i].value="";
// 				   b[i].value="";	
				   
// 				} 
			
// 		}
               
//     });
// //74
// $('#facilitacionTalleres').change(function() 
// {
// 	var x = document.getElementById("siete4");
// 	if($(this).is(":checked")) 
// 	{			
// 		if (x.style.display === "none") 
// 		{
// 			$(x).show('slow');
// 		}
// 	}
// 	else
// 	{			
// 			$(x).hide('slow');
// 			var a = document.getElementsByName("metodologiaFacilitacion[]");
// 			 var b = document.getElementsByName("metodologiaFacilitacionAtestado[]");
// 			 var longi=a.length;		  
// 			   for(var i=0;i<longi;i++)
// 			   {				 
// 				   a[i].value="";
// 				   b[i].value="";					   
// 				} 
		
// 	}               
//     });
// //75
// $('#metodologiasParticipativas').change(function() 
// {
// 	var x = document.getElementById("siete5");
// 	if($(this).is(":checked")) 
// 	{			
// 		if (x.style.display === "none") 
// 		{
// 			$(x).show('slow');
// 		}
// 	}
// 	else
// 	{			
// 			$(x).hide('slow');
// 			var a = document.getElementsByName("metodologiaParticipativa[]");
// 			 var b = document.getElementsByName("metodologiaParticipativaAtestado[]");
// 			 var longi=a.length;		  
// 			   for(var i=0;i<longi;i++)
// 			   {				 
// 				   a[i].value="";
// 				   b[i].value="";					   
// 				} 
		
// 	}               
//     });
// //76
// $('#elaboracionMaterial').change(function() 
// {
// 	var x = document.getElementById("siete6");
// 	if($(this).is(":checked")) 
// 	{			
// 		if (x.style.display === "none") 
// 		{
// 			$(x).show('slow');
// 		}
// 	}
// 	else
// 	{			
// 			$(x).hide('slow');
// 			var a = document.getElementsByName("metodologiaElaboracion[]");
// 			 var b = document.getElementsByName("metodologiaElaboracionAtestado[]");
// 			 var longi=a.length;		  
// 			   for(var i=0;i<longi;i++)
// 			   {				 
// 				   a[i].value="";
// 				   b[i].value="";					   
// 				} 
		
// 	}               
//     });
// //77
// $('#disenador').change(function() 
// {
// 	var x = document.getElementById("siete7");
// 	if($(this).is(":checked")) 
// 	{			
// 		if (x.style.display === "none") 
// 		{
// 			$(x).show('slow');
// 		}
// 	}
// 	else
// 	{			
// 			$(x).hide('slow');
// 			var a = document.getElementsByName("metodologiaLinea[]");
// 			 var b = document.getElementsByName("metodologiaLineaAtestado[]");
// 			 var longi=a.length;		  
// 			   for(var i=0;i<longi;i++)
// 			   {				 
// 				   a[i].value="";
// 				   b[i].value="";					   
// 				} 
		
// 	}               
//     });
// 	$('#aplicarPestana7').on('click', function () 
// 	{	
// 		//	en la tab 7, si no selecciono el checklist, ni habra existencia del element que contiene los datos, asi que solo si despliego los input, se pondrán.
// 		//asi q por eso en todos los casos, debo ver si no ha dejado vacio al meter el checkbox
// 		var validator = $("#formPestana7").validate();
// 		//
			
// 		var programas=document.getElementById('metodologiaDiseño').checked
// 		var okProgramas=true;
// 		if(programas==true)
// 			{
// 				//si no tiene experiencias laborales, se va de un solo a la otra pestaña
// 				console.log("ME METI A PROGRAMAS PORQUE ESTA CHEQUEADO EL CHECKBOIX");
// 				$("[name^=metodologiaProgramas]").each(function () {
// 				$(this).rules("add", {
// 					required: true,           
// 					messages: 
// 					{
// 						 required:"Debe indicar la experiencia en la metodología indicada"
// 					}
// 				});
// 			});
// 			$("[name^=metodologiaProgramasAtestado]").each(function () {
// 				$(this).rules("add", {
// 					required: true,           
// 					messages: 
// 					{
// 						 required:"Debe adjuntar el atestado que compruebe el manejo de esta metodología"
// 					}
// 				});
// 			});
			
// 			var metodoProgramas = document.getElementsByName("metodologiaProgramas[]");
// 			var ficheroProgramas = document.getElementsByName("metodologiaProgramasAtestado[]");
// 			for(var i=0;i<metodoProgramas.length;i++)
// 			{						
// 			   var valProgramas=validator.element(metodoProgramas[i]);
// 			   var valFicheroProgramas=validator.element(ficheroProgramas[i]);
			   
// 			}
// 			if(valProgramas==true && valFicheroProgramas==true)
// 			{
// 				okProgramas=true;
// 			}
// 			else 
// 			{
// 				okProgramas=false;
// 			}							
// 		} //fin de if programas
// 		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 		var disenocartas=document.getElementById('disenoCartas').checked
// 		var okdisenocartas=true;
// 		if(disenocartas==true)
// 			{
// 				//si no tiene experiencias laborales, se va de un solo a la otra pestaña
// 				//console.log("ME METIO A DISEÑO CARTA" +disenocartas.length);
// 				$("[name^=metodologiaDisenoCartas]").each(function () {
// 				$(this).rules("add", {
// 					required: true,           
// 					messages: 
// 					{
// 						 required:"Debe indicar la experiencia en la metodología indicada"
// 					}
// 				});
// 			});
// 			$("[name^=metodologiaDisenoCartasAtestado]").each(function () {
// 				$(this).rules("add", {
// 					required: true,           
// 					messages: 
// 					{
// 						 required:"Debe adjuntar el atestado que compruebe el manejo de esta metodología"
// 					}
// 				});
// 			});			
// 			var metodoCartas = document.getElementsByName("metodologiaDisenoCartas[]");
// 			var ficheroCartas = document.getElementsByName("metodologiaDisenoCartasAtestado[]");
// 			for(var i=0;i<metodoCartas.length;i++)
// 			{						
// 			   var valCartas=validator.element(metodoCartas[i]);
// 			   var valFicheroCartas=validator.element(ficheroCartas[i]);
			   
// 			}
// 			if(valCartas==true && valFicheroCartas==true)
// 			{
// 				okdisenocartas=true;
// 			}
// 			else 
// 			{
// 				okdisenocartas=false;
// 			}							
// 		} //fin de if programas
// 		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 			var evaluacion=document.getElementById('evaluacionProcesos').checked
// 		    var okevaluacion=true;
// 		if(evaluacion==true)
// 			{
// 				//si no tiene experiencias laborales, se va de un solo a la otra pestaña
				
// 				$("[name^=metodologiaEvaluacion]").each(function () {
// 				$(this).rules("add", {
// 					required: true,           
// 					messages: 
// 					{
// 						 required:"Debe indicar la experiencia en la metodología indicada"
// 					}
// 				});
// 			});
// 			$("[name^=metodologiaEvaluacionAtestado]").each(function () {
// 				$(this).rules("add", {
// 					required: true,           
// 					messages: 
// 					{
// 						 required:"Debe adjuntar el atestado que compruebe el manejo de esta metodología"
// 					}
// 				});
// 			});			
// 			var metodoEvaluacion = document.getElementsByName("metodologiaEvaluacion[]");
// 			var ficheroEvaluacion = document.getElementsByName("metodologiaEvaluacionAtestado[]");
// 			for(var i=0;i<metodoEvaluacion.length;i++)
// 			{						
// 			   var valEvaluacion=validator.element(metodoEvaluacion[i]);
// 			   var valFicheroEvaluacion=validator.element(ficheroEvaluacion[i]);
			   
// 			}
// 			if(valEvaluacion==true && valFicheroEvaluacion==true)
// 			{
// 				okevaluacion=true;
// 			}
// 			else 
// 			{
// 				okevaluacion=false;
// 			}							
// 		} //fin de if programas
// 		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 			var facilitacion=document.getElementById('facilitacionTalleres').checked;
// 		    var okfacilitacion=true;
// 		if(facilitacion==true)
// 			{
// 				//si no tiene experiencias laborales, se va de un solo a la otra pestaña
				
// 				$("[name^=metodologiaFacilitacion]").each(function () {
// 				$(this).rules("add", {
// 					required: true,           
// 					messages: 
// 					{
// 						 required:"Debe indicar la experiencia en la metodología indicada"
// 					}
// 				});
// 			});
// 			$("[name^=metodologiaFacilitacionAtestado]").each(function () {
// 				$(this).rules("add", {
// 					required: true,           
// 					messages: 
// 					{
// 						 required:"Debe adjuntar el atestado que compruebe el manejo de esta metodología"
// 					}
// 				});
// 			});			
// 			var metodoFacilitacion = document.getElementsByName("metodologiaFacilitacion[]");
// 			var ficheroFacilitacion = document.getElementsByName("metodologiaFacilitacionAtestado[]");
// 			for(var i=0;i<metodoFacilitacion.length;i++)
// 			{						
// 			   var valFacilitacion=validator.element(metodoFacilitacion[i]);
// 			   var valFicheroFacilitacion=validator.element(ficheroFacilitacion[i]);
			   
// 			}
// 			if(valFacilitacion==true && valFicheroFacilitacion==true)
// 			{
// 				okfacilitacion=true;
// 			}
// 			else 
// 			{
// 				okfacilitacion=false;
// 			}							
// 		} //fin de if programas
// 		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 			var participativa=document.getElementById('metodologiasParticipativas').checked;
// 		    var okparticipativa=true;
// 		if(participativa==true)
// 			{
// 				//si no tiene experiencias laborales, se va de un solo a la otra pestaña
				
// 				$("[name^=metodologiaParticipativa]").each(function () {
// 				$(this).rules("add", {
// 					required: true,           
// 					messages: 
// 					{
// 						 required:"Debe indicar la experiencia en la metodología indicada"
// 					}
// 				});
// 			});
// 			$("[name^=metodologiaParticipativaAtestado]").each(function () {
// 				$(this).rules("add", {
// 					required: true,           
// 					messages: 
// 					{
// 						 required:"Debe adjuntar el atestado que compruebe el manejo de esta metodología"
// 					}
// 				});
// 			});			
// 			var metodoParticipativa = document.getElementsByName("metodologiaParticipativa[]");
// 			var ficheroParticipativa = document.getElementsByName("metodologiaParticipativaAtestado[]");
// 			for(var i=0;i<metodoParticipativa.length;i++)
// 			{						
// 			   var valParticipativa=validator.element(metodoParticipativa[i]);
// 			   var valFicheroParticipativa=validator.element(ficheroParticipativa[i]);
			   
// 			}
// 			if(valParticipativa==true && valFicheroParticipativa==true)
// 			{
// 				okparticipativa=true;
// 			}
// 			else 
// 			{
// 				okparticipativa=false;
// 			}							
// 		} //fin de if participativa
// 			var elaboracion=document.getElementById('elaboracionMaterial').checked;
// 		    var okelaboracion=true;
// 		if(elaboracion==true)
// 			{
// 				//si no tiene experiencias laborales, se va de un solo a la otra pestaña
				
// 				$("[name^=metodologiaElaboracion]").each(function () {
// 				$(this).rules("add", {
// 					required: true,           
// 					messages: 
// 					{
// 						 required:"Debe indicar la experiencia en la metodología indicada"
// 					}
// 				});
// 			});
// 			$("[name^=metodologiaElaboracionAtestado]").each(function () {
// 				$(this).rules("add", {
// 					required: true,           
// 					messages: 
// 					{
// 						 required:"Debe adjuntar el atestado que compruebe el manejo de esta metodología"
// 					}
// 				});
// 			});			
// 			var metodoElaboracion = document.getElementsByName("metodologiaElaboracion[]");
// 			var ficheroElaboracion = document.getElementsByName("metodologiaElaboracionAtestado[]");
// 			for(var i=0;i<metodoElaboracion.length;i++)
// 			{						
// 			   var valElaboracion=validator.element(metodoElaboracion[i]);
// 			   var valFicheroElaboracion=validator.element(ficheroElaboracion[i]);
			   
// 			}
// 			if(valElaboracion==true && valFicheroElaboracion==true)
// 			{
// 				okelaboracion=true;
// 			}
// 			else 
// 			{
// 				okelaboracion=false;
// 			}							
// 		} //fin de if elaboracion
// 		var linea=document.getElementById('disenador').checked;
// 		    var oklinea=true;
// 		if(linea==true)
// 			{
// 				//si no tiene experiencias laborales, se va de un solo a la otra pestaña
				
// 				$("[name^=metodologiaLinea]").each(function () {
// 				$(this).rules("add", {
// 					required: true,           
// 					messages: 
// 					{
// 						 required:"Debe indicar la experiencia en la metodología indicada"
// 					}
// 				});
// 			});
// 			$("[name^=metodologiaLineaAtestado]").each(function () {
// 				$(this).rules("add", {
// 					required: true,           
// 					messages: 
// 					{
// 						 required:"Debe adjuntar el atestado que compruebe el manejo de esta metodología"
// 					}
// 				});
// 			});			
// 			var metodoLinea = document.getElementsByName("metodologiaLinea[]");
// 			var ficheroLinea = document.getElementsByName("metodologiaLineaAtestado[]");
// 			for(var i=0;i<metodoLinea.length;i++)
// 			{						
// 			   var valLinea=validator.element(metodoLinea[i]);
// 			   var valFicheroLinea=validator.element(ficheroLinea[i]);
			   
// 			}
// 			if(valLinea==true && valFicheroLinea==true)
// 			{
// 				oklinea=true;
// 			}
// 			else 
// 			{
// 				oklinea=false;
// 			}							
// 		} //fin de if elaboracion
// 		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 		/* console.log("A comprobar Programas: "+okProgramas);
// 		console.log("A comprobar disenocartas: "+okdisenocartas);
// 		console.log("A comprobar okevaluacion: "+okevaluacion);
// 		console.log("A comprobar okfacilitacion: "+okfacilitacion);
// 		console.log("A comprobar okparticipativa: "+okparticipativa);
// 		console.log("A comprobar okelaboracion: "+okelaboracion);
// 		console.log("A comprobar oklinea: "+oklinea); */
// 		if(okProgramas==true && okdisenocartas==true && okevaluacion==true && okfacilitacion==true && okparticipativa==true && okelaboracion==true && oklinea==true)
// 		{
// 			alert("Ahora se añadirán los elementos nuevos a la sección de metodologías manejadas del registro");
// 			document.getElementById("formPestana7").submit();
// 		}    		
//     });//fin de pasar a 7 a 8
	
// 	$('#aplicarPestana8').on('click', function () 
// 	{		
// 		//si ha puesto sabe idiomas, no debe dejar vacío
// 		var okIdiomas=false;
// 		var validator = $("#formPestana8").validate();
// 		valor=($('input[name=manejoIngles]:checked').val());
// 			if(valor.localeCompare("si")==0)
// 			{
// 				$("[name^=idiomas]").each(function () 
// 				{
// 					$(this).rules("add", 
// 					{
// 						required: true,           
// 						messages: 
// 						{
// 							 required:"Debe indicar el nombre del idioma que conoce"
// 						}
// 					});
// 				});
				
// 				var idiomas = document.getElementsByName("idiomas[]");
// 				for(var i=0;i<idiomas.length;i++)
// 				{						
// 				   var valIdiomas=validator.element(idiomas[i]);
// 				   //var valFicheroEvaluacion=validator.element(ficheroEvaluacion[i]);
				   
// 				}
// 				if(valIdiomas==true)
// 				{
// 					okIdiomas=true;
// 				}
				
// 				if(okIdiomas==true)
// 				{
// 					alert("Ahora se añadirán los nuevos elementos a su repertorio de idiomas dominados.");
// 					document.getElementById("formPestana8").submit();
// 				}
// 			}
	
					
//     });
	

	
}); //FIN DE DOCUMENT READY
