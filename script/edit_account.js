function validateAccount(){
   
   var fname = $('#id_account_user_first_name').val();
   var lname = $('#id_account_user_last_name').val();
   var email = $('#id_account_user_email').val();
   var pass  = $('#id_account_user_password').val();
   var npass = $('#id_account_user_npassword').val();
   var cpass = $('#id_account_user_cpassword').val();
   
   var alphanum = /^[A-Za-z0-9 \s]+$/;
   var alpha    = /^[A-Za-z \s]+$/;
   var atpos    = email.indexOf("@");
   var dotpos   = email.lastIndexOf(".");
   
   $('#id_account_user_first_name').removeClass("has-error");
   $('#id_account_user_last_name').removeClass("has-error");
   $('#id_account_user_email').removeClass("has-error");
   $('#id_account_user_password').removeClass("has-error");
   $('#id_account_user_npassword').removeClass("has-error");
   $('#id_account_user_cpassword').removeClass("has-error");
   
   if(fname == "" || !alpha.test(fname)){
      $('#id_account_user_first_name').addClass("has-error");
   }else if(lname == "" || !alpha.test(lname)){
      $('#id_account_user_last_name').addClass("has-error");
   }else if(atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= email.length || email == ""){
      $('#id_account_user_first_name').addClass("has-error");
   }
   
   // PASSWORD LOGIC
   else if(pass == "" && npass != "" && cpass == "" && !alphanum.test(pass) || pass == "" && npass == "" && cpass != "" && !alphanum.test(pass)){
      $('#id_account_user_password').addClass("has-error");
   }else if(pass != "" && npass == "" && cpass == "" && !alphanum.test(npass) || pass != "" && npass == "" && cpass != "" && !alphanum.test(npass)){
      $('#id_account_user_npassword').addClass("has-error");
   }else if(cpass != npass){
      $('#id_account_user_cpassword').addClass("has-error");
   }else{
      $('#id_btn_edit_account').click();
   }
   
}

function dismissAlert(i,x){
   $('#'+i).hide("fast");
   $('#'+x).text('');
}