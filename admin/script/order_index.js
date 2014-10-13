$(function() {
   $("#order_date_search").datepicker({
      altField:'#order_date_search',
	  altFormat: "yy/mm/dd",
	  onSelect: function () {
	     document.all ? $(this).get(0).fireEvent("onchange") : $(this).change();
         searchQueryOption('order_date');
      },
   });
});

function changeOption(){
   var action = $('#news-action option:selected').val();
   
   if(action == "delete" || action == ""){
      $('#news-option').addClass("hidden");
	  $('#lbl-news-option').addClass("hidden");
	  $('#news-option').attr('disabled', true);
   }else if(action == "change"){
	  $('#news-option').removeClass("hidden");
	  $('#lbl-news-option').removeClass("hidden");
	  $('#news-option').removeAttr('disabled');
   }
   
}