 $(function () {

		$.fn.dataTable.moment( 'YYYY-MM-DD' );
	    $.fn.dataTable.moment( 'DD/MM/YYYY' );
		$('#tablaEventos').DataTable( {
        "order": [[ 1, "desc" ]],
        "language": {
			"sProcessing":     "Procesando...",
			"sLengthMenu":     "Mostrar _MENU_ elementos",
			"sZeroRecords":    "No se encontraron resultados",
			"sEmptyTable":     "Ningún dato disponible en esta tabla",
			"sInfo":           "Mostrando elementos de la _START_ a la _END_ de un total de _TOTAL_",
			"sInfoEmpty":      "Mostrando elementos de la 0 a la 0 de un total de 0",
			"sInfoFiltered":   "(filtrado de un total de _MAX_ elementos)",
			"sInfoPostFix":    "",
			"sSearch":         "Búsqueda por nombre de elemento:",
			"sUrl":            "",
			"sInfoThousands":  ",",
			"sLoadingRecords": "Cargando...",
			"oPaginate": {
			    "sFirst":    "Primero",
			    "sLast":     "Último",
			    "sNext":     "Siguiente",
			    "sPrevious": "Anterior"
			},
			"oAria": {
			    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
			    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
			}
		}
    } );
  })