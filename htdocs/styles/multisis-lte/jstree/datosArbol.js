function isNumeric(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

  $(document).ready(function() 
  {
	  //console.log("SIGJUTEG: Sistema de Gestión de Jurisprudencia del TEG. Desarrollado por José Mario López Leiva marioleiva2011@gmail.com");
      $("#jstree").jstree({
     "core" : {
       // so that create works
       "check_callback" : true,
	     "dblclick_toggle" : false,

       'data' : 
           {
            "url" : "/inicializarArbol.php"
            
          }

     },
    "plugins" : [ "types" ],

         
  });
});
$("#jstree").on('dblclick.jstree', function(e) 
{
    // gather ids of selected nodes
    var selected_ids = [];
    $("#jstree_id").jstree('get_selected').each(function () { 
        selected_ids.push(this.id); 
    }); 

    //dos lineas muy importantes: obtener el id del nodo seleccionado y una referencia a él para hacer las acceiones
     //en https://www.jstree.com/api/#/?q=(
   var idNodo=$("#jstree li").jstree("get_selected");
    console.log("abierto el nodo "+idNodo);
   var node = $('#jstree').jstree(true).get_node(idNodo, true);
   if($('#jstree').jstree(true).is_open(node))
   {
    //alert('Nodo ya abierto');
    return;
   }
   //var tiene= $.jstree.reference('#jstree').is_parent(node);
   //var interaccion=1;
   //alert("Tiene hijos "+tiene );
   // if(tiene==false)
   // {
   //      var nivel=2;
       if(isNumeric(idNodo))
       {
          nivel=$('#'+idNodo).attr('aria-level')
          nivelanterior=1;
       }
       else
       {
          var papa= $.jstree.reference('#jstree').get_parent(node);
          //alert('papa: '+papa);
          if(isNumeric(papa))
          {
            nivel=2;
          }
          else
          {
            nivel=3;
          }
       }

          if(nivel==3)
          {
            var url = node.children('a').attr('href');; 
            window.location.href = url;
            //alert("Estoy en nive 3 y la url  es_:"+url);
          }
         var parent = idNodo;
        console.log("ANTES DE AJAX. nivel e id: "+nivel+parent);
         //alert("Click en nivel "+nivel);
         $.ajax({
                        url:"/response.php?nivel="+nivel+"&id="+parent,
                        success:function(result)
                        {

                               //console.log(JSON.stringify(result));
                               var codificar=JSON.stringify(result);
                              var parsear = JSON.parse(codificar); 
                               var numeroProblemas=0;
                               for (i = 0; i < parsear.length; i++) 
                               {

                                 //var nodito=JSON.stringify(result);

                                 var nodito=parsear[i];
                                 //console.log("Nodito "+nodito);
                                    $('#jstree').jstree('create_node', parent, nodito, 'last');
									numeroProblemas++;
                                    
                                } 
								//$('#jstree').jstree(true)._open_to(idNodo)
								//$("#jstree").jstree("open_node", $(idNodo));
								//alert("Click en nivelito "+nivel);
								if(nivel==1)
								{
									//alert("Encontrados "+numeroProblemas+" problemas jurídicos.");
								   $("#jstree").jstree("open_node", $('#'+idNodo));

								}
								if(nivel==2)
								{
									 //alert("Encontrados "+numeroProblemas+" ratios decidiendi.");
								     $("#jstree").jstree("open_node", idNodo);
								}
																 
									
                        }
						,
							error: function(result) 
							{ 
							 console.log("Error: "+result.responseText);
							}
                    }); //fin del ajax 

   //}//fin de si NO TIENE hijos aun hacer el proceso.
 
  });
  
  // $('#jstree').bind("dblclick.jstree", function (event) 
  // {
       // event.preventDefault();
		// event.stopPropagation();
      // console.log("DOBLE CLICK");
	  
    // }); 
	// $('#jstree').bind("click.jstree", function (event) 
  // {
       
      // console.log("SOLITO CLICK");
    // }); 
/*
$('#jstree').bind('click.jstree', function (e, datap) 
{
    alert("Nodo expandido");

});*/
