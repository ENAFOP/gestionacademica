
// $("#attributes_4").chosen()
//Change the value and let Chosen know
// $("#attributes_4").val("").trigger("liszt:updated")
// $(function(){
    // $('#btn').click(function() 
	// {
        // //alert("Hello");
			// $(".chzn-select").chosen();	
				// $(".chzn-select").val('').trigger("liszt:updated");​
    // });
// });

// $(".attributes_4").chosen();
// $('btn').click(function()
// {
		// console.log("aqui");
    // $(".attributes_4").val('').trigger("chosen:updated");
// });


// jQuery(document).ready(function() {
    // //jQuery('#autoship_option').val('');

    // jQuery("#clearSel").on("click", function() 
	// {
		// console.log("hola");
		// $(".chzn-select").chosen();
        // jQuery('#attributes_4').val('');
    // });
// });

// $(".form-control chzn-select").chosen();
// $('clearSel').click(function()
// {
	// console.log("aqui");
        // $(".form-control chzn-select").val('').trigger("chosen:updated");
// });

$("select.mario").chosen({
  no_results_text: "Oops, nothing found!",
  width: "100%",
  search_contains: true
});

$('#form_reset2').click(function(e) {
  setTimeout(function() {
    clearChosen()
  }, 10);
});

function clearChosen() {
  $('select#attributes_4').trigger('chosen:updated');
    $('select#attributes_5').trigger('chosen:updated');
	$('#deberesDerogados').hide('fast');
	$('#deberesVigentes').hide('fast');
	////////////////
	$('select#attributes_8').trigger('chosen:updated');
	$('select#attributes_15').trigger('chosen:updated');
	$('select#attributes_16').trigger('chosen:updated');
	$('select#attributes_17').trigger('chosen:updated');
	$('#prohibicionesDerogadas').hide('fast');
	$('#prohibicionesVigentes').hide('fast');
	$('select#tipologias').trigger('chosen:updated');
}
