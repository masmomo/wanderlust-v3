function validation(){
   var name    = $('#id_contact_name').val();
   var email   = $('#id_contact_email').val();
   var atpos   = email.indexOf("@");
   var dotpos  = email.lastIndexOf(".");
   var subject = $('#id_contact_subject').val();
   var msg     = $('#id_contact_msg').val();
   
   
   $('#id_contact_name').removeClass('has-error');
   $('#id_contact_email').removeClass('has-error');
   $('#id_contact_subject').removeClass('has-error');
   $('#id_contact_msg').removeClass('has-error');
   
   if(name == ""){
      $('#id_contact_name').addClass('has-error');
   }else if(atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= email.length || email == ""){
      $('#id_contact_email').addClass('has-error');
   }else if(subject == ""){
      $('#id_contact_subject').addClass('has-error');
   }else if(msg == ""){
      $('#id_contact_msg').addClass('has-error');
   }else{
	  $('#id_btn_contact').click();
   }
   
}

$('#btn_alias').click(function(){
   validation();
});