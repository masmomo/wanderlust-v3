function selectedQty(x, y){
   $('#bag_qty_'+x+' option[value="'+y+'"]').attr('selected', true);
}

function changeQty(x){
   $('#id_btn_update_'+x).removeClass("hidden");
}

function removeCart(x){
   var key = x;
   
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

function updateCart(x){
   var key     = x;
   var qty     = $('#bag_qty_'+x+' option:selected').val();
   var stock   = $('#hidden_stock_'+x).val();
   var numeric = /^[0-9]+$/;
   
   $.ajax({
      type : "POST",
	  url  : "order_/ajax/ajax_update.php",
	  data : {key:key, qty:qty, stock:stock},
	  error: function(jqXHR, textStatus, errorThrown) {
	            
			 }
			 
   }).done(function(msg) {
      
	  if(!numeric.test(msg)){
	     $('#bag_alert').removeClass('hidden');
		 $('#error_message').text(msg);
	  }else{
	     $('#bag_alert').removeClass('hidden');
	     $('#bag_alert').removeClass('alert-danger');
	     $('#bag_alert').addClass('alert-success');
		 $('#error_message').text('Success update quantity');
		 
		 updatePrice(x);
		 $('#id_btn_update_'+x).addClass("hidden");
	  }
	  
   });
}


function closeAlert(){
   $('#bag_alert').addClass("hidden");
}

function updatePrice(x){
   var price    = $('#hidden_bag_price_'+x).val();
   var discount = $('#hidden_bag_discount_price_'+x).val()
   var qty      = $('#bag_qty_'+x+' option:selected').val();
   var sum      = 0;
   var disc     = $('#hidden_bag_discount_'+x).val();
   var discs    = 0;
   
   var total_per_item = price * qty;
   
   var ftotal_per_item   = accounting.formatMoney(total_per_item, "", 0, ".", ",");
   
   $('#bag_tprice_'+x).text(ftotal_per_item);
   $('#bag_total_per_item_'+x).val(total_per_item);
   
   $('.amount_item').each(function() {
      sum += Number($(this).val());
   });
   
   var ftotal            = accounting.formatMoney(sum, "", 0, ".", ",");
   
   $('#total_amount').text(ftotal);
   $('#summary_subtotal').text(ftotal);
   $('#hidden_bag_subtotal').val(sum);
   
   var discount_per_item = disc * qty;
   
   $('#hidden_bag_discount_price_'+x).val(discount_per_item);
      
   $('.amount_discount').each(function() {
      discs += Number($(this).val());
   });
   
   $('#hidden_bag_subtotal_discount').val(discs);
   
}


$(document).ready(function(e) {
   
});