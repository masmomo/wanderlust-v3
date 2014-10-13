function validateLogin(){
   var alphanum = /^[A-Za-z0-9]+$/;
   var email    = $('#id_login_username').val();
   var atpos    = email.indexOf("@");
   var dotpos   = email.lastIndexOf(".");
   var password = $('#id_login_password').val();
   
   $('#lbl_login_username').removeClass("has-error");
   $('#lbl_login_password').removeClass("has-error");
   
   if(atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= email.length || email == ""){
	 $('#lbl_login_username').addClass("has-error");
   }else if(!alphanum.test(password) || password == ""){
	 $('#lbl_login_password').addClass("has-error");
   }else{
	 $('#btn_login').click();
   }
   
}


function vaildateForgotPassword(){
   var email    = $('#id_forgot_email').val();
   var atpos    = email.indexOf("@");
   var dotpos   = email.lastIndexOf(".");
   
   $('#lbl_forgot_email').addClass("has-error");
   
   if(atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= email.length || email == ""){
      $('#lbl_forgot_email').addClass("has-error");
   }else{
      $('#lbl_forgot_email').removeClass("has-error");
	  $('#btn_forgot').click();
   }
   
}


function ajaxForgotPassword(){
   var email = $('#id_forgot_email').val();
   
   var ajx   = $.ajax({
	              type: "POST",
				  url: "account/ajax/ajax_forgot_password.php",
				  data: {email:email},
				  error: function(jqXHR, textStatus, errorThrown) {
					   
					     }
			   }).done(function(data) {		
			      $('#ajax_forgot_password').html(data);
				  //alert(data);
			   });
			   
}


function validateRegister(){
   var alphanum = /^[A-Za-z0-9]+$/;
   var numeric  = /^[0-9]+$/;
   var fname    = $('#id_register_fname').val();
   var lname    = $('#id_register_lname').val();
   var email    = $('#id_register_email').val();
   var atpos    = email.indexOf("@");
   var dotpos   = email.lastIndexOf(".");
   var password = $('#id_register_password').val();
   var repass   = $('#id_register_repassword').val();
   
   $('#lbl_register_fname').removeClass("has-error");
   $('#lbl_register_lname').removeClass("has-error");
   $('#id_register_email').removeClass("has-error");
   $('#id_register_password').removeClass("has-error");
   $('#id_register_repassword').removeClass("has-error");
   
   if(fname == "" || numeric.test(fname)){
      $('#lbl_register_fname').addClass("has-error");
   }else if(lname == "" || numeric.test(lname)){
      $('#lbl_register_lname').addClass("has-error");
   }else if(atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= email.length || email == ""){
      $('#lbl_register_email').addClass("has-error");
	  alert(email);
   }else if(password == "" || !alphanum.test(password)){
      $('#lbl_register_password').addClass("has-error");
   }else if(repass == "" || !alphanum.test(repass) || password != repass){
      $('#lbl_register_repassword').addClass("has-error");
   }else{
      $('#lbl_register_fname').removeClass("has-error");
      $('#lbl_register_lname').removeClass("has-error");
      $('#id_register_email').removeClass("has-error");
      $('#id_register_password').removeClass("has-error");
      $('#id_register_repassword').removeClass("has-error");
	  
	  $('#btn_register').click();
   }
   
} 

function enterLogin(){
   $(document).keypress(function(e) {
      if(e.which == 13) {
         //alert('You pressed enter!');
		 $('#btn_login').click();
	  }
   });
}


function enterregister(){
   $(document).keypress(function(e) {
      if(e.which == 13) {
         //alert('You pressed enter!');
		 $('#btn_login').click();
	  }
   });
}