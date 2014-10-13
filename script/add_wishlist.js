/*
# ----------------------------------------------------------------------
# FUNCTIONS
# ----------------------------------------------------------------------
*/
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
   $('#modal_view_button').attr("href","../../../wishlist");
   $('#modal_view_button').html('View Wishlist');
   
   
   //alert('Name: '+name+'; Type: '+type+' Stock: '+stock);
}


function addWishlist(){
   var type_id   = $('#id_hidden_type_id').val();
   var stock_id  = $('#id_hidden_stock').val();
   var qty       = $('#id_hidden_qty').val();
   
   var ajx       = $.ajax({
                      type: "POST",
					  url: "../../../shop_/ajax/add_wishlist.php",
					  data: {type_id:type_id, stock_id:stock_id, qty:qty},
					  error: function(jqXHR, textStatus, errorThrown) {
						        
							 }
							 
				   }).done(function(data) {		
						if (data=='user_ok'){
						
							modal();
						}else{
							var server = $('#prefix_redirect').html();
							location.href = server+'/login';
						}
				   });
}



