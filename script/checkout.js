
function openOverlay() {
   $('#overlayhelp').removeClass('hidden');
}


function closeOverlay() {
   $('#overlayhelp').addClass('hidden');
}


function setCountry(){
   var country  = $('#id_checkout_user_country option:selected').val();
   var province = $('#id_checkout_user_province option:selected').val();
   var city     = $('#id_checkout_user_city option:selected').val();
   var rate     = $('#id_checkout_user_shipping option:selected').val();
   
   if(country == ""){
      $('#id_hidden_checkout_country').val("indonesia");
   }else{
      $('#id_hidden_checkout_country').val(country);
   }
   
   if(province == ""){
      $('#id_hidden_checkout_province').val("Jakarta");
	  $('#id_checkout_user_province option[value="Jakarta"]').attr('selected', 'selected');
   }else{
      $('#id_hidden_checkout_province').val(province);
	  $('#id_checkout_user_province option[value="'+country+'"]').attr('selected', 'selected');
   }
   
   if(city == ""){
      $('#id_hidden_checkout_city').val("Jakarta");
   }else{
      $('#id_hidden_checkout_city').val(city);
   }
   
   if(rate == ""){
      $('#id_hidden_checkout_courier').val("13");
   }else{
      $('#id_hidden_checkout_courier').val(rate);
   }
   
}


function ajaxProvince(x){
   var province = $('#id_checkout_user_province option:selected').val();
}


function ajaxCity(x){
   var province = $('#id_checkout_user_province').val();
   
   if(province == ""){
      province = "Jakarta";
   }else{
      province = province;
   }
   
   var ajx   = $.ajax({
	              type: "POST",
				  url: "order_/ajax/ajax_city.php",
				  data: {province:province},
				  error: function(jqXHR, textStatus, errorThrown) {
					   
					     }
			   }).done(function(data) {	
			      $('#ajax_data_city').html(data);
				  $('#id_checkout_user_city option[value="'+x+'"]').attr('selected', 'selected');
				  ajaxCourier();
			   });  
}

function ajaxCourier(){
   var city = $('#id_checkout_user_city').val();
   
   if(city == ""){
      city = "Jakarta";
   }else{
      city = city;
   }
   
   var ajx   = $.ajax({
	              type: "POST",
				  url: "order_/ajax/ajax_courier.php",
				  data: {city:city},
				  error: function(jqXHR, textStatus, errorThrown) {
					   
					     }
			   }).done(function(data) {	
			      $('#ajax_courier').html(data);
				  setCountry();
				  setRate();
			   });  
}


function setRate(){
   var cid    = $('#id_checkout_user_shipping option:selected').val();
   var amount = $('#id_summary_amount').val();
   var rate   = $('#id_checkout_user_shipping option:selected').attr('rate');
   var ship   = accounting.formatMoney(rate, "", 0, ".", ",");
   var sum    = Number(amount)+Number(rate);
   var total  = accounting.formatMoney(sum, "", 0, ".", ",");
   
   $('#id_hidden_checkout_courier').val(cid);
   $('#checkout_summary_shipping').text(ship);
   $('#id_summary_shipping').val(rate);
   $('#total_summary').text(total);
   
   $('#hidden_checkout_amount').val(amount);
   $('#hidden_checkout_total').val(sum);
}
	
	
function selectCountry(x){
   $('#id_checkout_user_country option[value="'+x+'"]').attr('selected', true);
}