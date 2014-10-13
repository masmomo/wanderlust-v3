<?php



/*
# ----------------------------------------------------------------------
# FUNCTIONS
# ----------------------------------------------------------------------
*/
function get_wishlists($user_id){
	$conn   = connDB();

	   $sql    = "SELECT * FROM tbl_wishlist AS wish INNER JOIN tbl_product_type AS type_ ON wish.type_id = type_.type_id
	              WHERE user_id = '$user_id' AND type_visibility='1' AND type_delete!='1'
				  ORDER BY wishlist_date DESC
				 ";
	   $query  = mysql_query($sql, $conn);
	   $row    = array();

	   while($result = mysql_fetch_array($query)){
		  array_push($row, $result);
	   }
	   return $row;
}

function get_carts($post_type_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_product_type AS type_ LEFT JOIN tbl_product AS prod_ ON type_.product_id = prod_.id
                                                      LEFT JOIN tbl_product_image AS img_ ON type_.type_id = img_.type_id
													  LEFT JOIN tbl_product_stock AS stock_ ON type_.type_id = stock_.type_id
													  LEFT JOIN tbl_promo_item AS discount_ ON type_.type_id = discount_.product_type_id
													  LEFT JOIN tbl_category AS cat_ ON prod_.product_category = cat_.category_id
              WHERE type_.type_id = '$post_type_id' AND img_.image_order = '0'
			 ";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function get_stock($post_stock_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_product_stock WHERE `stock_id` = '$post_stock_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}



/*
# ----------------------------------------------------------------------
# CALL FUNCTION
# ----------------------------------------------------------------------
*/

/* --- DISCOUNT --- */
$price = discount_price($bag['promo_id'], $bag['promo_value'], $bag['type_price'], $bag['promo_start_datetime'], $bag['promo_end_datetime']);



/*
# ----------------------------------------------------------------------
# DEFINED VARIABLE
# ----------------------------------------------------------------------
*/
$wishlists = get_wishlists($_SESSION['user_id']);
$cart_type_id = array();
$cart_stock_id = array();
$cart_qty = array();
$cart_date = array();
$wishlist_id = array();
foreach ($wishlists as $wishlist){
	array_push($cart_type_id,$wishlist['type_id']);
	array_push($cart_stock_id,$wishlist['stock_name']);
	array_push($cart_qty,$wishlist['item_quantity']);
	array_push($cart_date,$wishlist['wishlist_date']);
	array_push($wishlist_id,$wishlist['wishlist_id']);
}
//print_r($cart_date);
/*
# ----------------------------------------------------------------------
# CONTROL
# ----------------------------------------------------------------------
*/

if(isset($_POST['btn_checkout'])){
   $_SESSION['amount_purchase'] = $_POST['hidden_bag_subtotal'];
   $_SESSION['amount_discount'] = $_POST['hidden_bag_subtotal_discount'];
}
?>

    <div class="container">
      <img class="m_b_20" src="<?php echo $prefix_url;?>files/common/img_line-dotted.png" width="100%" height="2">

      <div class="row">

        <div class="shop-bag col-md-10 col-xs-12">
          <form method="post">
            <table class="table">
              <thead>
                <tr class="hidden-xs">
                  <th class="th-item" width="40%" style="width: 40%">Item(s)</th>
                  <th class="th-item" width="15%" style="width: 15%">Date</th>
                  <th class="th-item" width="15%" style="width: 15%">Availability</th>
                  <th class="th-price hidden-xs" width="20%" style="width: 15%">Price</th>
                  <th class="th-price hidden-xs" width="20%" style="width: 15%">Action</th>
                </tr>
              </thead>
              <tbody>
	
				<?php
				/*
				# ----------------------------------------------------------------------
				# NO ITEM
				# ----------------------------------------------------------------------
				*/
				
                if(empty($cart_type_id)){
				   echo '<tr>';
				   echo '<td colspan="4" style="padding:15px 0; text-align:center;">No Item(s)</td>';
				   echo '</tr>';
				}
				
				
				/*
				# ----------------------------------------------------------------------
				# LOOPING ITEM(S)
				# ----------------------------------------------------------------------
				*/
				
				$key=0;
                foreach($cart_type_id as $key=>$cart){
				   /* --- CALL FUNCTION --- */
				   $bag   = get_carts($cart);
				   $stock = get_stock($cart_stock_id[$key]);
				   $price = discount_price($bag['promo_id'], $bag['promo_value'], $bag['type_price'], $bag['promo_start_datetime'], $bag['promo_end_datetime']);
				   
				   /*
				   # ----------------------------------------------------------------------
				   # HIDDEN INPUT VALUE
				   # ----------------------------------------------------------------------
				   */
				   echo "<input type=\"hidden\" id=\"product_name_".$key."\" value=\"".$bag['product_name']."\">";
				   echo "<input type=\"hidden\" id=\"product_image_".$key."\" value=\"".$prefix_url."admin/static/thimthumb.php?src=../".$bag['img_src']."&h=93&w=70&q=100\">";
				   echo "<input type=\"hidden\" id=\"type_name_".$key."\" value=\"".$bag['type_name']."\">";
				   echo "<input type=\"hidden\" id=\"stock_name_".$key."\" value=\"".$bag['stock_name']."\">";
				
				
				   echo "<input type=\"hidden\" id=\"hidden_bag_qty_".$key."\" value=\"".$price['now_price']."\">";
				   echo "<input type=\"hidden\" id=\"hidden_bag_price_".$key."\" value=\"".$price['now_price']."\">";
                   echo "<input type=\"hidden\" id=\"hidden_bag_discount_".$key."\" value=\"".$price['promo_value']."\">";
                   echo "<input type=\"hidden\" class=\"amount_discount\" id=\"hidden_bag_discount_price_".$key."\" value=\"".($price['promo_value'] * $cart_qty[$key])."\">";
				   echo '<input type="hidden" class="custom_price_'.$key.' amount_item" value="'.($price['now_price'] * $cart_qty[$key]).'" id="bag_total_per_item_'.$key.'">';
				   echo "<input type=\"text\" class=\"hidden\" id=\"hidden_stock_".$key."\" value=\"".$cart_stock_id[$key]."\"> \n"; // STOCK ID
                ?>
					<?php //print_r($bag);?>
				
                <tr id="item_<?=$key;?>">
                  <td class="item">
                    <img class="pull-left" src="<?php echo $prefix_url."admin/static/thimthumb.php?src=../".$bag['img_src']."&h=93&w=70&q=100";?>">
                    <p class="name"><a href="<?=$prefix_url;?>item/<?=cleanurl($bag['category_name']);?>/<?=$bag['product_alias'];?>/<?=$bag['type_alias'];?>"><?php echo $bag['product_name'];?></a></p>
                    <p class="attribute hidden-xs"><?php echo $bag['type_name'];?> / <?php echo $bag['stock_name'];?></p>
                    <p class="attribute visible-xs"><?php echo $bag['type_name'];?> / <?php echo $bag['stock_name'];?> / <?php echo $cart_qty[$key]?> pc(s).</p>
                    <p class="attribute visible-xs">
                    	<?php
						if(!empty($bag['promo_id']) || $bag['promo_id'] = "" || $bag['promo_start_datetime'] <= date('Y-m-d') and $bag['promo_end_datetime'] >= date('Y-m-d')){
						   echo "<span class=\"now-price \">Rp ".price($price['now_price'])."</span> \n";
						   echo "<span class=\"was-price \">Rp ".price($price['was_price'])."</span> \n";
						}else{
						   echo "<span class=\"normal-price \">Rp ".price($price['now_price'])."</span> \n";
						}
						?>
                    </p>
                    <div class="remove" onClick="removeCart(<?php echo $wishlist_id[$key].','.$key;?>)"><span>remove</span></div>
                    <div class="visible-xs"><input type="button" class="btn btn-primary btn-sm" value="Add to Bag" data-toggle="modal" href="#bagViewer" onclick="addBag(<?=$cart_type_id[$key];?>,<?=$cart_stock_id[$key];?>,1,<?=$key;?>,<?=$wishlist_id[$key];?>)"></div>
                  </td>
                  <td class="price hidden-xs clearfix text-center">
                    <p><?php echo date('d/m/Y',strtotime($cart_date[$key]));?>
                    </p>
                  </td>
                  <td class="hidden-xs text-center">
						
                    <p style="padding-top: 8px <?php if($stock['stock_quantity']>0){ echo';color:#006600;';}else{echo ';color:#ff0000;';}?>"><strong><?php if($stock['stock_quantity']>0){ echo 'AVAILABLE';}else{echo 'SOLD OUT';}?></strong></p>
                  </td>
                  <td class="price hidden-xs clearfix">
                    <p class="currency"><?php $currency;?></p> 
                    <p class="amount">
					<?php
                      /*
					  # ----------------------------------------------------------------------
					  # DISCOUNT
					  # ----------------------------------------------------------------------
					  */

					  if(!empty($bag['promo_id']) || $bag['promo_id'] = "" || $bag['promo_start_datetime'] <= date('Y-m-d') and $bag['promo_end_datetime'] >= date('Y-m-d')){
					     echo "<span class=\"now-price \">Rp ".price($price['now_price'])."</span> \n";
					     echo "<span class=\"was-price \">Rp ".price($price['was_price'])."</span> \n";
					  }else{
					     echo "<span class=\"normal-price \">Rp ".price($price['now_price'])."</span> \n";
					  }
                      ?>
					</p><!--amount-->
                  </td>
                  <td class="hidden-xs text-center">
                    <?php if($stock['stock_quantity']>0){?><input type="button" class="btn btn-primary btn-sm pull-right" value="Add to Bag" data-toggle="modal" href="#bagViewer" onclick="addBag(<?=$cart_type_id[$key];?>,<?=$cart_stock_id[$key];?>,1,<?=$key;?>,<?=$wishlist_id[$key];?>)"><?php }else{echo '<p style="margin-top: 8px">-</p>';} ?>
                    <!--<p style="margin-top: 8px">-</p>-->
                  </td>
                </tr>

				<?php
                   
                }// END FOREACH
                ?>

				<!--
                <tr id="item_<?=$key;?>">
                  <td class="item">
                    <img class="pull-left" src="<?php echo $prefix_url;?>script/holder.js/73x90">
                    <p class="name">Product Name</a></p>
                    <p class="attribute hidden-xs">White / One</p>
                    <p class="attribute visible-xs">White / One / 1 pc(s).</p>
                    <p class="attribute visible-xs"></p>
                    <div class="remove" onClick="removeCart(<?php echo $key;?>)"><span>remove</span></div>
                  </td>
                  <td class="price hidden-xs clearfix">
                    <p>22/8/2014
                    </p>
                  </td>
                  <td class="hidden-xs">
                    <p>SOLD OUT</p>
                  </td>
                  <td class="price hidden-xs clearfix">
                    <p class="currency">Rp</p> 
                    <p class="amount">200.000</p>
                  </td>
                  <td class="hidden-xs"></td>
                </tr>
                -->
              </tbody>
            </table>

          </form>
        </div> <!-- shop-bag -->

        <aside class="info col-md-2 col-xs-12">

          <!--<div class="box">
            <div class="title">Summary</div>
            <div class="content">
              <div class="info-row">
                <div class="subtitle">Total</div>
                <div class="price clearfix">
                  <div>
                    <p class="currency"><?php $currency;?></p> 
                    <p class="amount" id="summary_subtotal"><?php echo price($sub_total);?></p>
                  </div>
                </div>
              </div>
              <div class="info-caption">
                excluding shipping cost
              </div>
            </div>
          </div>-->

          <div class="box">
            <div class="title">Help</div>
            <div class="content">
              <div class="info-row info-email text-center">
                <a href="mailto:<?php echo $info['email_display'];?>">Email Us</a>
              </div>
            </div>
          </div><!--box-->

        </aside>

      </div> <!--row-->

    </div><!--.container-->

	<div class="modal fade" id="bagViewer">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <p class="modal-title" id="modal_title">1 item(s) has been added to bag.</p>
          </div>
          <div class="modal-body clearfix">
            <img id="modal_image" class="pull-left" src="<?php echo$prefix_url?>holder.js/100x150">
            <p>
              <strong><span id="modal_product_name">Product Name</span></strong><br>
              <span id="modal_type_name">Black</span><br>
              <span id="modal_stock_name">S</span>
            </p>
            <p class="m_t_5" id="modal_qty">1 pc(s)</p>
            <div class="btn-placeholder">
              <a href="<?php echo $prefix_url."bag";?>" class="btn btn-primary">View Bag</a>
              <a data-dismiss="modal" class="btn btn-default">Continue Shopping</a>
            </div>
          </div>
        </div><!--.modal-content -->
      </div><!--.modal-dialog -->
    </div><!--.modal -->

    
<script src="<?php echo $prefix_url."script/bag.js"?>"></script>

<script type="text/javascript">
function modal(key){
   var name  = $('#product_name_'+key).val();
   var image = $('#product_image_'+key).val();
   var type  = $('#type_name_'+key).val();
   var stock = $('#stock_name_'+key).val();
   var qty   = 1;
   
   /* --- ASSIGNING --- */
   $('#modal_title').text(qty+' item(s) has been added to bag.');
   $('#modal_qty').text(qty+' pc(s)');
   $('#modal_image').attr('src', image);
   $('#modal_product_name').text(name);
   $('#modal_type_name').text(type);
   $('#modal_stock_name').text(stock);
   
   //alert('Name: '+name+'; Type: '+type+' Stock: '+stock);
}

function addBag(type_id,stock_id,qty,key,wishlist_id){
   //var type_id   = $('#id_hidden_type_id').val();
   //var stock_id  = $('#id_hidden_stock').val();
   //var qty       = $('#id_hidden_qty').val();
   
   var ajx       = $.ajax({
                      type: "POST",
					  url: "shop_/ajax/add_bag.php",
					  data: {type_id:type_id, stock_id:stock_id, qty:qty},
					  error: function(jqXHR, textStatus, errorThrown) {
						        
							 }
							 
				   }).done(function(data) {		
				      modal(key);
					  $('#id_shop_count').text(data);
					
					  removeCart(wishlist_id,key);
				   });
}

function removeCart(x,y){
   var key = x;
   
   $.ajax({
      type : "POST",
	  url  : "order_/ajax/ajax_wishlist_remove.php",
	  data : {key:key},
	  error: function(jqXHR, textStatus, errorThrown) {
	            
			 }
			 
   }).done(function(msg) {
      $('#item_'+y).slideUp("slow").remove();
   });
}
</script>