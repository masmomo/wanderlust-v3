
function ajaxGet(){
   var bank = $('#id_bank_method option:selected').val();
   
   var ajx  = $.ajax({
	             type : "POST",
				 url  : "settings/account/ajax.php",
				 data : {bank:bank},
				 error: function(jqXHR, textStatus, errorThrown) {
					   
				         }
						 
			   }).done(function(data) {	
			      $('#ajax_payment').html(data);
			   });
}


function validation(){
   var bank   = $('#id_bank_name').val();
   var number = $('#id_bank_number').val();
   var name   = $('#id_bank_account').val();
   
   $('#bank_name').removeClass('has-error');
   $('#id_bank_number').removeClass('has-error');
   $('#id_bank_account').removeClass('has-error');
   
   if(bank == ""){
      $('#bank_name').addClass('has-error');
   }else if(number == ""){
      $('#id_bank_number').addClass('has-error');
   }else if(name == ""){
      $('#id_bank_account').addClass('has-error');
   }else{
	  $('#id_btn_payment').click();
   }
   
}

$('#id_button').click(function(){
   validation();
});


$(document).ready(function(e) {
   ajaxGet();
});