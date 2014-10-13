/*
# ----------------------------------------------------------------------
# FUNCTIONS
# ----------------------------------------------------------------------
*/

function redirType(){
   var target    = $('#id_option_type option:selected').val();
   location.href = target;
}

function getStock(){
   
   var ajax_stock_id = $('#id_option_stock option:selected').val();
   
   $.ajax({
      type: "POST",
      url: "../../../shop_/ajax/stock.php",
      data: {ajax_stock_id:ajax_stock_id},
      error: function(jqXHR, textStatus, errorThrown) {				        
      
	         }
   }).done(function(data) {		
      $('#id_option_qty').html(data);
	  
	  var stock = $('#id_option_stock option:selected').val();
	  $('#id_hidden_stock').val(stock);
   });
}


function getQty(){
   var qty = $('#id_option_qty option:selected').val();
   $('#id_hidden_qty').val(qty);
}


function modal(){
   var name  = $('#md_product_name').val();
   var image = $('#md_product_image').val();
   var type  = $('#md_type_name').val();;
   var stock = $('#id_option_stock option:selected').attr('md_name');
   var qty   = $('#id_hidden_qty').val();
   
   /* --- ASSIGNING --- */
   $('#modal_title').text(qty+' item(s) has been added to bag.');
   $('#modal_qty').text(qty+' pc(s)');
   $('#modal_image').attr('src', image);
   $('#modal_product_name').text(name);
   $('#modal_type_name').text(type);
   $('#modal_stock_name').text(stock);
   
   //alert('Name: '+name+'; Type: '+type+' Stock: '+stock);
}


function addBag(){
   var type_id   = $('#id_hidden_type_id').val();
   var stock_id  = $('#id_hidden_stock').val();
   var qty       = $('#id_hidden_qty').val();
   
   var ajx       = $.ajax({
                      type: "POST",
					  url: "../../../shop_/ajax/add_bag.php",
					  data: {type_id:type_id, stock_id:stock_id, qty:qty},
					  error: function(jqXHR, textStatus, errorThrown) {
						        
							 }
							 
				   }).done(function(data) {		
				      modal();
					  $('#id_shop_count').text(data);
				   });
}

function viewThumb(x){
   $('#id_default_image').attr('src', x);
}


$(window).ready(function(e) {
   getStock();
   getQty();
});