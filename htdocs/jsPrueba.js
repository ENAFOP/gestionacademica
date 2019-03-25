$("select.has_chosen").chosen({
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
  $('select#chosen2').trigger('chosen:updated');
}
