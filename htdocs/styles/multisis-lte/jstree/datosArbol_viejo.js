function isNumeric(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

  $(document).ready(function() 
  {
      $("#jstree").jstree({
     "core" : {
       // so that create works
       "check_callback" : true,
       'data' : 
           {
            "url" : "/inicializarArbol.php"
            
          }

     },
    "plugins" : [ "types" ],

         
  });
});
$("#jstree").on('select_node.jstree', function(e) 
{
    // gather ids of selected nodes
    var selected_ids = [];
    $("#jstree_id").jstree('get_selected').each(function () { 
        selected_ids.push(this.id); 
    }); 

    //dos lineas muy importantes: obtener el id del nodo seleccionado y una referencia a él para hacer las acceiones
     //en https://www.jstree.com/api/#/?q=(
   var idNodo=$("#jstree li").jstree("get_selected");
    //alert("abierto el nodo "+idNodo);
   var node = $('#jstree').jstree(true).get_node(idNodo, true);
    
   var tiene= $.jstree.reference('#jstree').is_parent(node);
  
   //alert("Tiene hijos "+tiene );
   if(tiene==false)
   {
        var nivel=2;
       if(isNumeric(idNodo))
       {
          nivel=$('#'+idNodo).attr('aria-level')
       }
          if(nivel==3)
          {
            var url = node.children('a').attr('href');; 
            window.location.href = url;
            //alert("Estoy en nive 3 y la url  es_:"+url);
          }
         var parent = idNodo;
        
         //alert("Click en nivel "+nivel);
         $.ajax({
                        url:"/response.php?nivel="+nivel+"&id="+parent,
                        success:function(result)
                        {

                               //alert(JSON.stringify(result));
                               var codificar=JSON.stringify(result);
                              var parsear = JSON.parse(codificar); 
                               var numeroProblemas=0;
                               for (i = 0; i < parsear.length; i++) 
                               {

                                 //var nodito=JSON.stringify(result);
                                 var nodito=parsear[i];
                                 //alert("Nodito "+nodito);
                                    $('#jstree').jstree('create_node', parent, nodito, 'last');
									numeroProblemas++;
                                    
                                } 
								//$('#jstree').jstree(true)._open_to(idNodo)
								//$("#jstree").jstree("open_node", $(idNodo));
								//alert("Click en nivelito "+nivel);
								if(nivel==1)
								{
									alert("Encontrados "+numeroProblemas+" problemas jurídicos.");
								   $("#jstree").jstree("open_node", $('#'+idNodo));
								}
								if(nivel==2)
								{
									 alert("Encontrados "+numeroProblemas+" fundamentos.");
								     $("#jstree").jstree("open_node", idNodo);
								}
								
									
								 
									
                        }
                    }); //fin del ajax 

   }//fin de si NO TIENE hijos aun hacer el proceso.
 
  });

/*
$('#jstree').bind('click.jstree', function (e, datap) 
{
    alert("Nodo expandido");

});*/

