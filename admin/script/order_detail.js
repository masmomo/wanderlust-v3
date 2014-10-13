function check_qty(x){
   var curr_qty = $('#id_qty_'+x).val();
   var qty      = $('#id_hidden_qty_'+x).val();
   
   if(curr_qty != 0){
      
	  if(curr_qty != qty){
	     $('#id_chk_qty_'+x).attr('checked', true);
	  }else{
	     $('#id_chk_qty_'+x).attr('checked', false);
	  }
	  
   }else{
   }
   
   total_weight();
   total_purchase();
   check_stock(x);
}


function ajax_qty(x){
   
   var qty = $('#id_qty_'+x).val();
   var id  = x;
   
   $.ajax({
      type : "POST",
	  url  : "order_/ajax/ajax_remove.php",
	  data : {key:key},
	  error: function(jqXHR, textStatus, errorThrown) {
	            
			 }
			 
   }).done(function(msg) {
      $('#item_'+x).slideUp("slow").remove();
   });
}


function same_height(){
   var left  = $('#box_row_left').height();
   var right = $('#box_row_right').height();
   
   if(left < right){
      $('#box_row_left').css('height',right+'px');
   }else if(right < left){
      $('#box_row_right').css('height',left+'px');
   }
}



function ajax_province(){
   
   var country = $('#id_order_shipping_country option:selected').val();
   
   $.ajax({
      type : "POST",
	  url  : "../orders/ajax/province.php",
	  data : {country:country},
	  error: function(jqXHR, textStatus, errorThrown) {
	            
			 }
			 
   }).done(function(msg) {
      
      if(msg != '0'){
	     $('#id_order_shipping_province').html(msg);
	  }else{
	     
	  }
   });
}



function ajax_city(){
   
   var country  = $('#id_order_shipping_country option:selected').val();
   var province = $('#id_order_shipping_province option:selected').val();
   
   $.ajax({
      type : "POST",
	  url  : "../orders/ajax/city.php",
	  data : {country:country, province:province},
	  error: function(jqXHR, textStatus, errorThrown) {
	            
			 }
			 
   }).done(function(msg) {
	  
      if(msg != '0'){
	     $('#id_order_shipping_city').html(msg);
	  }else{
	     
	  }
   });
}



function ajax_shipping(){
   
   var method  = $('#id_hidden_order_shipping_method').val();
   var weight  = $('#id_hidden_total_weight').val();
   
   $.ajax({
      type : "POST",
	  url  : "../orders/ajax/shipping.php",
	  data : {country:country, province:province},
	  error: function(jqXHR, textStatus, errorThrown) {
	            
			 }
			 
   }).done(function(msg) {
	  
      if(msg != '0'){
	     $('#id_order_shipping_city').html(msg);
	  }else{
	     
	  }
   });
}


function total_weight(){
   var total = 0;
   
   $("input[id^=id_hidden_item_weight_]").each(function( index, value ) {
	  var w   = $('#id_qty_'+(+1+index)).val();
	  
	  total += Number($(this).val()) * Number(w);
   });
   
   $('#id_hidden_total_weight').val(total);
}


function total_purchase(){
   var total = 0;
   
   $("input[id^=id_hidden_price_item_]").each(function( index, value ) {
	  var w   = $('#id_qty_'+(+1+index)).val();
	  
	  total += Number($(this).val()) * Number(w);
   });
   
   $('#id_hidden_total_purchase').val(total);
}


function check_stock(x){
   var input = Number($('input[name^=product_qty_'+x+']').val());
   var stock = Number($('input[name^=hidden_item_stock_'+x+']').val());
   
   if(input>stock){
      $('#id_alert_stock_'+x).removeClass('hidden');
	  $('#id_alert_stock_'+x).html('Available only: '+stock+'pc(s)');
	  
	  $('input[name=btn-edit-order]').attr('disabled', true);
   }else{
      $('#id_alert_stock_'+x).addClass('hidden');
	  
	  $('input[name=btn-edit-order]').attr('disabled', false);
   }
   
}

total_purchase();