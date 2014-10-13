<?php
/*
# ----------------------------------------------------------------------
# FUNCTIONS
# ----------------------------------------------------------------------
*/

function get_carts($post_type_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_product_type AS type_ LEFT JOIN tbl_product AS prod_ ON type_.product_id = prod_.id
                                                      LEFT JOIN tbl_product_image AS img_ ON type_.type_id = img_.type_id
													  LEFT JOIN tbl_product_stock AS stock_ ON type_.type_id = stock_.type_id
													  LEFT JOIN tbl_promo_item AS discount_ ON type_.type_id = discount_.product_type_id
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

$cart_type_id  = $_SESSION['cart_type_id'];
$cart_stock_id = $_SESSION['cart_stock_id'];
$cart_qty      = $_SESSION['cart_qty'];

$currency = 'RP ';
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

        <div class="shop-bag col-md-10 col-sm-12 col-xs-12">
          <div class="alert alert-danger hidden" id="bag_alert" style="margin-top: 15px">
            <!--<button type="button" class="close" data-dismiss="alert">&times;</button>-->
            <button type="button" class="close" onclick="closeAlert()">&times;</button>
            <p id="error_message">Quantity available is 5, you tried to add 6.</p>
          </div>
          <form method="post">
            <table class="table">
              <thead>
                <tr class="hidden-xs">
                  <th class="th-item">Item(s)</th>
                  <th class="th-price hidden-xs" width="17%">Price</th>
                  <th class="th-qty hidden-xs" width="12%">Qty.</th>
                  <th class="th-total hidden-xs" width="17%">Total</th>
                </tr>
              </thead>
              <tbody>
                
                <?php
				/*
				# ----------------------------------------------------------------------
				# NO ITEM
				# ----------------------------------------------------------------------
				*/
				
                if(!isset($_SESSION['cart_type_id']) and count($_SESSION['cart_type_id'] == 0)){
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
				   
				   echo "<input type=\"hidden\" id=\"hidden_bag_qty_".$key."\" value=\"".$price['now_price']."\">";
				   echo "<input type=\"hidden\" id=\"hidden_bag_price_".$key."\" value=\"".$price['now_price']."\">";
                   echo "<input type=\"hidden\" id=\"hidden_bag_discount_".$key."\" value=\"".$price['promo_value']."\">";
                   echo "<input type=\"hidden\" class=\"amount_discount\" id=\"hidden_bag_discount_price_".$key."\" value=\"".($price['promo_value'] * $cart_qty[$key])."\">";
				   echo '<input type="hidden" class="custom_price_'.$key.' amount_item" value="'.($price['now_price'] * $cart_qty[$key]).'" id="bag_total_per_item_'.$key.'">';
				   echo "<input type=\"text\" class=\"hidden\" id=\"hidden_stock_".$key."\" value=\"".$cart_stock_id[$key]."\"> \n"; // STOCK ID
                ?>
                
                <tr id="item_<?=$key;?>">
                  <td class="item">
                    <img class="pull-left" src="<?php echo $prefix_url."admin/static/thimthumb.php?src=../".$bag['img_src']."&h=93&w=70&q=100";?>">
                    <p class="name"><a href="<?=$prefix_url;?>item/<?=cleanurl($bag['category_name']);?>/<?=$bag['product_alias'];?>/<?=$bag['type_alias'];?>"><?php echo $bag['product_name'];?></a></p>
                    <p class="attribute hidden-xs"><?php echo $bag['type_name'];?> / <?php echo $bag['stock_name'];?></p>
                    <p class="attribute visible-xs"><?php echo $bag['type_name'];?> / <?php echo $bag['stock_name'];?> / <?php echo $cart_qty[$key]?> pc(s).</p>
          
                    <p class="attribute visible-xs">
                    
                    <?php
					if(!empty($bag['promo_id']) || $bag['promo_id'] = "" || $bag['promo_start_datetime'] <= date('Y-m-d') and $bag['promo_end_datetime'] >= date('Y-m-d')){
					   echo "<span class=\"now-price \">Rp".price($price['now_price'])."</span> \n";
					   echo "<span class=\"was-price \">Rp".price($price['was_price'])."</span> \n";
					}else{
					   echo "<span class=\"normal-price \">Rp".price($price['now_price'])."</span> \n";
					}
					?>
            
                    </p>
                    
                    <div class="remove" onClick="removeCart(<?php echo $key;?>)"><span>remove</span></div>
                    
                  </td>
                  <td class="price hidden-xs clearfix">
                    <p class="currency"><?php echo 'Rp'//$currency;?></p> 
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
                    
                    </p>
                  </td>
                  <td class="hidden-xs">
                    <select class="form-control" id="bag_qty_<?php echo $key;?>" onChange="changeQty(<?php echo $key;?>)">
				      
					  <?php
                      /*
					  # ----------------------------------------------------------------------
					  # STOCK
					  # ----------------------------------------------------------------------
					  */
					  
                      if($bag['stock_quantity'] > 9){
                         $counter = 9;
                      }else{
                         $counter = $bag['stock_quantity'];
                      }
					  
					  for($i=1;$i<=$counter;$i++){
					     echo "<option ";
						 
						 if ($cart_qty[$key] == $i){
                            echo 'selected="selected"';
						 }
					     
						 echo " value=\"".$i."\">".$i."</option> \n";
                      }
                      ?>
                      
                    </select>
                    <div class="outer-center hidden" id="id_btn_update_<?php echo $key;?>">
                      <div class="inner-center">
                        <div class="update" onClick="updateCart(<?php echo $key;?>)">update</div>
                      </div>
                    </div>
                  </td>
                  <td class="price hidden-xs clearfix">
                    <p class="currency"><?php //$currency;?></p> 
                    <p class="amount" id="bag_tprice_<?php echo $key;?>"><?php echo "Rp ".price($price['now_price'] * $cart_qty[$key]);?></p>
                  </td>
                </tr>
                
                <?php
                   $sub_total += $price['now_price'] * $cart_qty[$key];
				   $sub_discount += $price['promo_value'] * $cart_qty[$key];
                }// END FOREACH
                ?>
                
              </tbody>
            </table>

            <div class="clearfix">
              
			  <?php
              if(isset($_SESSION['cart_type_id']) and count($_SESSION['cart_type_id'] != 0)){
			  ?>
              
              <div class="tfooter clearfix">
                <div class="tf-row clearfix">
                  <div class="tf-title">Subtotal</div>
                    <div class="tf-price price clearfix">
                      <div>
                        <p class="currency"><?php //$currency;?></p> 
                          <p class="amount" id="total_amount"><?php echo 'Rp '.price($sub_total);?></p>
                            <input type="text" name="hidden_bag_subtotal" id="hidden_bag_subtotal" class="hidden" value="<?php echo $sub_total;?>">
                            <input type="text" name="hidden_bag_subtotal_discount" id="hidden_bag_subtotal_discount" class="hidden" value="<?php echo $sub_discount;?>">
                      </div>
                    </div>
                  </div><!-- tf-row -->
                </div><!-- tfooter -->
              
			  <?php
			    echo '<input type="submit" class="btn btn-primary btn-sm pull-right" style="margin-top: 10px" id="id_btn_checkout" name="btn_checkout" value="checkout">';
			  }
			  ?>
              <a href="<?php echo $prefix_url."shop"?>" class="btn btn-default btn-sm pull-right" style="margin-top: 10px; margin-right: 10px">Back to Shop</a>
            </div>

          </form>
        </div> <!-- shop-bag -->

        <aside class="info col-md-2 col-xs-12">

          <div class="box">
            <div class="title">Summary</div>
            <div class="content">
              <div class="info-row">
                <div class="subtitle">Total</div>
                <div class="price clearfix">
                  <div>
                    <p class="currency"><?php //$currency;?></p> 
                    <p class="amount" id="summary_subtotal"><?php echo 'Rp '.price($sub_total);?></p>
                  </div>
                </div>
              </div>
              <div class="info-caption">
                <em>excluding shipping cost</em>
              </div>
            </div>
          </div><!--box-->

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
    
<script src="<?php echo $prefix_url."script/bag.js"?>"></script>