/*
function popShow(){
   $('#pop-up').fadeIn("fast");
   $('#username-admin').focus();
   $('#flag-pop-up').val('show');
   $('#alert-msg-pass').hide();
   //$('#alert-msg-login').hide();
   
   var flag = $('#flag-pop-up').val();
   
   if(flag == "show"){
      if(event.keyCode == 13){
	     $('#forgot-password').click();
	  }
   }else{
	  $('#alert-msg-pass').fadeIn("fast");
	  $('#alert-msg-login').fadeIn("fast");
   }
   
   $('#username-admin').keypress(function(evt){
      var charCode = evt.charCode || evt.keyCode;
	  
	  if (charCode  == 13) {
	     $('#forgot-password').click();
	  }
   });
}

function popClose(){
   $('#flag-pop-up').val('closed');
   $('#pop-up').fadeOut("fast");
   $('#alert-msg-pass').hide();
   //$('#alert-msg-login').hide();
}
*/
 
$(document).keypress(function(e) {
   
   if(e.which == 13) {
      $('#btn_login').click();
   }
   
});

function validateLogin(){
   var user = $('#id_username').val();
   var pass = $('#id_password').val();
   
   if(user == ""){
      $('#id_username').focus();
   }else if(pass == ""){
      $('#id_password').focus();
   }else{
      $('#btn-login').click();
   }
   
}
