<script>
function selectCountry(i){
   $('#address_country option[value="'+i+'"]').attr('selected','selected');
   $('#hidden_user_country').val(i);
}

function selectProvince(i){
   $('#address_province option[value="'+i+'"]').attr('selected','selected');
   $('#hidden_user_province').val(i);
}

function selectCity(i){
   $('#address_city option[value="'+i+'"]').attr('selected','selected');
}

function validateShippingAddress(){
   var numeric  = /^[0-9]+$/;
   var fname    = $('#address_fname').val();
   var lname    = $('#address_lname').val();
   var phone    = $('#address_phone').val();
   var address  = $('#address_address').val();
   var country  = $('#address_country option :selected').val();
   var province = $('#address_province option :selected').val();
   var city     = $('#address_city option :selected').val();
   var postal   = $('#address_postal').val();

   $('#lbl_address_fname').removeClass("has-error");
   $('#lbl_address_lname').removeClass("has-error");
   $('#lbl_address_phone').removeClass("has-error");
   $('#lbl_address_postal').removeClass("has-error");
   $('#').removeClass("has-error");
   
   if(fname == "" || numeric.test(fname)){
      $('#lbl_address_fname').addClass("has-error");
   }else if(lname == "" || numeric.test(lname)){
      $('#lbl_address_lname').addClass("has-error");
   }else if(phone == "" || !numeric.test(phone) || phone.length < 8){
      $('#lbl_address_phone').addClass("has-error");
   }else if(address == "" || address.length < 10){
      $('#lbl_address_address').addClass("has-error");
   }else if(postal == "" || postal.length != 5 || !numeric.test(postal)){
      $('#lbl_address_postal').addClass("has-error");
   }else{
      $('#id_btn_edit_shipping_details').click();
   }
   
}

function ajaxProvince(){
   var country = $('#address_country :selected').val();
   
   if(typeof country === "undefined"){
      var set = "<?php if(empty($global_user['user_country'])){ echo "Indonesia";}else{ echo $global_user['user_country'];}?>";
   }else{
      var set = country;
   }
   
   var ajx   = $.ajax({
	              type: "POST",
				  url: "account_/ajax/ajax_province.php",
				  data: {country:country},
				  error: function(jqXHR, textStatus, errorThrown) {
					   
					     }
			   }).done(function(data) {		
			      $('#ajax_province').html(data);
				  selectProvince('<?php if(empty($global_user['user_province'])){ echo "Jakarta";}else{ echo $global_user['user_province'];}?>');
				  $('#hidden_user_country').val(country);
			   });
}

function ajaxCity(){
   var province = $('#address_province :selected').val();
   
   if(typeof province === "undefined"){
      var set = "<?php if(empty($global_user['user_province'])){ echo "Jakarta";}else{ echo $global_user['user_province'];}?>";
   }else{
      var set = province;
   }
   
   var ajx   = $.ajax({
	              type: "POST",
				  url: "account_/ajax/ajax_city.php",
				  data: {set:set},
				  error: function(jqXHR, textStatus, errorThrown) {
					   
					     }
			   }).done(function(data) {		
			      $('#ajax_city').removeClass("hidden").html(data);
				  selectCity('<?php echo $global_user['user_city'];?>');
				  $('#hidden_user_province').val(set);
				  $('#initial_city').remove();
			   });
}

function getCity(){
   var city = $('#address_city :selected').val();
   
   if(typeof city === "undefined"){
      var set = "<?php if(empty($global_user['user_city'])){ echo "Jakarta";}else{ echo $global_user['user_city'];}?>";
   }else{
      var set = city;
   }
   
   $('#hidden_user_city').val(set);
}

function validateAddress(){
   var alphanum = /^[A-Za-z0-9]+$/;
   var numeric  = /^[0-9#.-_]+$/;
   
   var fname    = $('#address_fname').val();
   
   if(!numeric.test("_")){
       alert("Without !");
   }else{
      
   }
    
}


$(document).ready(function() {
   selectCountry('<?php if(empty($global_user['user_country'])){ echo "Indonesia";}else{ echo $global_user['user_country'];}?>');
   selectProvince('<?php if(empty($global_user['user_province'])){ echo "Jakarta";}else{ echo $global_user['user_province'];}?>');
   selectCity('<?php echo $global_user['user_city'];?>');
   
   ajaxProvince();
   ajaxCity();
   getCity();
});
</script>