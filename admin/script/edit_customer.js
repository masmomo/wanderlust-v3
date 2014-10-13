



function backupProvince(){
   var country = $('#province option:selected').val();
   $('#province-backup').val(country);
   
   var province = $('#province option:selected').val();
   var userID   = $('#hidden-user_id').val();
   
   var city = $.ajax({
	             type : "POST",
				 url  : "../customers/details/ajax.php",
				 data : { province:province, userID:userID},
				 error: function(jqXHR, textStatus, errorThrown) {
					    
						}
						
				 }).done(function(data) {
					//$('#id-city').slideDown("fast");
				    $('#city-select').html(data);
					//alert(data);
				 });

}

function backupProvinceText(){
   var country = $('#text-province').val();
   $('#province-backup').val(country);
}

function backupCity(){
   var city = $('#city option:selected').val();
   $('#city-backup').val(city);
}

function backupCityText(){
   var country = $('#text-city').val();
   $('#city-backup').val(country);
}


$('#btn-save').hide();
$('#btn-exit').hide();

function validateEditUser(i){
   var fname  = $('#user-first-name').val();
   var lname  = $('#user-last-name').val();
   var email  = $('#user-email').val();
   var atpos  = email.indexOf("@");
   var dotpos = email.lastIndexOf(".");
   var phone  = $('#user-phone').val();
   var nonum  = /^\d*[0-9](|.\d*[0-9]|,\d*[0-9])?$/
   
   var address       = $('#address-title').val();
   var addressDetail = $('#address-detail').val();
   
   //alert(addressDetail);
   
   if(fname == ""){
      alert("First name can't be empty");
   }else if(fname.length < 3){
      alert("First name minimum contains 3 character");
   }else if(nonum.test(fname)){
      alert("First name can only contain alphabet");
   }else if(lname == ""){
      alert("Last name can't be empty");
   }else if(lname.length < 3){
      alert("Last name minimum contains 3 character");
   }else if(nonum.test(lname)){
      alert("Last name can only contain alphabet");
   }else if(email == ""){
      alert("email can't be empty");
   }else if(atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= email.length){
      alert("Please input valid email address");
   }else if(phone == ""){
      alert("Phone can't be empty");
   //}else if(phone.length < 10){
      //alert("Phone minumun contain 10 digits");
   }else if(!nonum.test(phone)){
      alert("Phone can only contain numeric only");
   }else if(addressDetail = ""){
      alert ("Please input your address detail");
   }else{
      
	  if(i == "Save"){
         $('#btn-save').click();
	  }else if(i == "Exit"){
	     $('#btn-exit').click();
	  }
	  
   }
   
}





function getProvince(){
   var country  = $('#country option:selected').val();
   var value_province = $('#province').val();
   
   /*
   $('#wrap-province').html('<select class="form-control col-xs-9" id="province" name="user_province" onchange="backupProvince()"><option></option><?php foreach($getProvince as $province){echo "<option value=\"".$province['province_name']."\">".$province['province_name']."</option>";}?></select>');
   */
   
   if(country == "Indonesia"){
      /*$('#wrap-province').html('<select class="form-control col-xs-9" id="province" name="user_province" onchange="backupProvince()"><option></option><?php foreach($getProvince as $province){echo "<option value=\"".$province['province_name']."\">".$province['province_name']."</option>";}?></select>');
	  $('#wrap-city').html('<input type="text" class="form-control col-xs-9" name="user_city">');
	  */
	  $('#wrap-province-text').hide();
	  $('#wrap-province').slideDown("fast");
	  
	  $('#wrap-city-text').hide();
	  $('#wrap-city').slideDown("fast");
	  
   }else if(country != "Indonesia"){
	   /*
	  $('#wrap-province').html('<input type="text" class="form-control col-xs-9" name="user_province" onkeyup="backupProvinceText()" id="text-province">');
	  $('#wrap-city').html('<input type="text" class="form-control col-xs-9" name="user_city">');
	  */
	  $('#wrap-province-text').slideDown("fast");
	  $('#text-province').val('');
	  $('#wrap-province').hide();
	  
	  $('#wrap-city-text').slideDown("fast");
	  $('#text-city').val('');
	  $('#wrap-city').hide();
   }
   
}