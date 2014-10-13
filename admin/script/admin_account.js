function validationAdminAccount(){
   var role   = $('#admin-role option:selected').val();
   var name   = $('#id_admin_username').val();
   var email  = $('#id_admin_email').val();
   var atpos  = email.indexOf("@");
   var dotpos = email.lastIndexOf(".");
   var pass   = $('#id_admin_old_password').val();
   var npass  = $('#id_admin_new_password').val();
   var cpass  = $('#id_admin_r_new_password').val();
   var alpha  = /^[a-zA-z]+$/;
   var alphan = /^[a-zA-z0-9]+$/;
   

   $('#admin-role').removeClass("empty");
   $('#id_admin_username').removeClass("empty");
   $('#id_admin_email').removeClass("empty");
   $('#id_admin_old_password').removeClass("empty");
   $('#id_admin_new_password').removeClass("empty");
   $('#id_admin_r_new_password').removeClass("empty");
   
   
   if(role == "null"){
	  $('#admin-role').addClass("empty");
   }else if(name == "" || name.length < 3){
      $('#id_admin_username').addClass("empty");
   }else if(atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= email.length){
      $('#id_admin_email').addClass("empty");
   }else if(pass == "" && npass != "" && cpass == "" || pass == "" && npass == "" && cpass != ""){
      $('#id_admin_old_password').addClass("empty");
   }else if(pass != "" && npass == "" && cpass == "" || pass != "" && npass == "" && cpass != ""){
      $('#id_admin_new_password').addClass("empty");
   }else if(pass != "" && npass != "" && cpass != npass){
      $('#id_admin_r_new_password').addClass("empty");
   }else {
      $('#id_btn_account').click();
   }
   
}