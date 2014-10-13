<?php
//if(empty($_SESSION['user_id'])){
   //include("account_/login.php");
//}else{
?>

<?php
/* -- GET -- */

function get($post_order_number, $post_user_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_order AS order_ INNER JOIN tbl_user_purchase AS purchase ON order_.order_id = purchase.order_id
              WHERE `order_number` = '$post_order_number' AND `user_id` = '$post_user_id'
			 ";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function get_item($post_order_number, $post_user_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_order AS order_ INNER JOIN tbl_user_purchase AS purchase ON order_.order_id = purchase.order_id
                                                INNER JOIN tbl_order_item AS item_ ON order_.order_id = item_.order_id
												INNER JOIN tbl_product_type as type_ ON item_.type_id = type_.type_id
												INNER JOIN tbl_product AS product ON type_.product_id = product.id
												LEFT JOIN tbl_product_image as img ON type_.type_id = img.type_id
												LEFT JOIN tbl_promo_item AS promo ON type_.type_id = promo.product_type_id
              WHERE `order_number` = '$post_order_number' AND `user_id` = '$post_user_id'
			  GROUP BY item_id, stock_name
			  ORDER BY image_order
			 ";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}


/* -- UPDATE -- */


/* -- CONTROL -- */

// DEFINED VARIABLE
$order_number = clean_alphanumeric($_REQUEST['oid']);

// CALL FUNCTION
$order_info = get($order_number, $global_user['user_id']);
$order_item = get_item($order_number, $global_user['user_id']);

//currency module
$order_info['order_purchase_amount'] = $order_info['order_purchase_amount'];
$order_info['order_shipping_amount'] = $order_info['order_shipping_amount'];


//promo module
$i=0;
foreach($order_item as $item){
	//currency module
	  if($order_info['currency']=='USD'){
		$order_item[$i]['item_price'] = $item['item_price']/$order_info['currency_rate'];
		$item['item_price'] = $item['item_price']/$order_info['currency_rate'];				
	  }
	
	//promo module BELOW
	
	
	$i++;
}
?>

<div class="container main">
  <div class="content">

      <ul class="breadcrumb">
        <li><a href="<?php echo $prefix_url."account/".md5($global_user['user_alias']);?>">Account</a></li>
        <li><a href="<?php echo $prefix_url."order-history";?>">Order History</a></li>
        <li class="active"><?=$order_number;?></li>
      </ul>

      <div class="row">

        <div class="col-md-10 col-sm-12 col-xs-12">
          <div class="shop-bag">
            <form action="<?php echo $prefix;?>account/login.php">
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
  				//print_r($order_item);
  				foreach($order_item as $item){
                  ?>
                  <tr>
                    <td class="item">
                      <img class="pull-left" src="<?php echo $prefix_url.$item['img_src'];?>">
                      <p class="name"><a href=""><?php echo $item['product_name'];?></a></p>
                      <p class="attribute hidden-xs-"><?php echo $item['type_name'];?> / <?php echo $item['stock_name'];?></p>
                      <p class="attribute visible-xs"><?php echo $item['type_name'];?> / <?php echo $item['stock_name'];?> / <?php echo $item['item_quantity'];?> pc(s).</p>

                      <p class="attribute visible-xs">
					    
						<?php 
						if($item['item_discount_price']!=0){
						?>
                        
                        <span class="now-price"><?=$order_info['currency'];?> <?php echo price($item['item_discount_price']);?></span>
                        <span class="was-price"><?=$order_info['currency'];?> <?php echo price($item['item_price']);?></span>
						
						<?php }else{ ?>
                        
                        <span class="now-price"><?=$order_info['currency'];?> <?php echo price($item['item_price']);?></span>
						
						<?php }?>
                      
                      </p>
                    </td>

                    <td class="price hidden-xs clearfix">
                      <p class="currency"><?=$order_info['currency'];?></p>
  					<?php 
  					 if($item['item_discount_price']!=0){
  					 ?>
  					 <p class="amount">
                        <span class="now-price"><?php echo price($item['item_discount_price']);?></span>
                        <span class="was-price"><?php echo price($item['item_price']);?></span>
                       </p>
  					 <?php }else{?>
  					 <p class="amount">
                        <span class="now-price"><?php echo price($item['item_price']);?></span>
  					 </p>
                       <?php }?>
                    </td>

                    <td class="hidden-xs">
                      <p style="text-align: center; padding-top: 8px"><?php echo price($item['item_quantity']);?></p>
                    </td>

                    <td class="price hidden-xs clearfix">
                      <p class="currency"><?=$order_info['currency'];?></p> 
                      <?php
                      if($item['item_discount_price']!=0){
  					?>
                      <p class="amount"><?php echo price($item['item_quantity'] * $item['item_discount_price']);?></p>
  					<?php
  					}else{
  					?>
                      <p class="amount"><?php echo price($item['item_quantity'] * $item['item_price']);?></p>
                      <?php
  					}
  					?>
                    </td>
                  </tr>
                  <?php
                  }
                  ?>
                </tbody>
              </table>

            </form>
          </div> <!--.shop-bag-->
        </div>

        <div class="col-md-10 col-sm-12 col-xs-12">
          <div class="checkout" style="border-left: none">
            <form action="<?php echo $prefix;?>order/finish.php" class="form-horizontal">
              <fieldset>
                <div class="header">Shipping Details</div>
                <div class="form-group">
                  <label class="col-xs-3 control-label">First Name</label>
                  <div class="col-xs-9">
                    <p class="form-content"><?php echo $order_info['order_shipping_first_name'];?></p>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-xs-3 control-label">Last Name</label>
                  <div class="col-xs-9">
                    <p class="form-content"><?php echo $order_info['order_shipping_last_name'];?></p>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-xs-3 control-label">Phone</label>
                  <div class="col-xs-9">
                    <p class="form-content"><?php echo $order_info['order_shipping_phone'];?></p>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-xs-3 control-label">Address</label>
                  <div class="col-xs-9">
                    <p class="form-content"><?php echo $order_info['order_shipping_address'];?></p>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-xs-3 control-label">Country</label>
                  <div class="col-xs-9">
                    <p class="form-content"><?php echo $order_info['order_shipping_country'];?></p>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-xs-3 control-label">Province</label>
                  <div class="col-xs-9">
                    <p class="form-content"><?php echo $order_info['order_shipping_province'];?></p>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-xs-3 control-label">City</label>
                  <div class="col-xs-9">
                    <p class="form-content"><?php echo $order_info['order_shipping_city'];?></p>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-xs-3 control-label">Postal Code</label>
                  <div class="col-xs-9">
                    <p class="form-content"><?php echo $order_info['order_shipping_postal_code'];?></p>
                  </div>
                </div>
              </fieldset>

              <fieldset>
                <div class="header">Shipping Method</div>
                <div class="form-group">
                  <label class="col-xs-3 control-label">Method</label>
                  <div class="col-xs-9">
                    <p class="form-content"><?php echo $order_info['shipping_method'];?> - <?php echo price($order_info['order_shipping_amount']);?></p>
                  </div>
                </div>
              </fieldset>

              <fieldset>
                <div class="header">Payment Method</div>
                <div class="form-group">
                  <label class="col-xs-3 control-label">Method</label>
                  <div class="col-xs-9">
                    <p class="form-content">Bank Transfer via <?php echo $order_info['order_payment_method'];?></p>
                  </div>
                </div>
              </fieldset>

              <a href="<?php echo $prefix_url."account/".$global_user['user_alias'];?>" class="btn btn-default pull-right" style="margin-top: 10px; margin-right: 10px">BACK</a>
            </form>

          </div> <!--.checkout-->
        </div>

        <aside class="info col-md-2 col-sm-12 col-xs-12">

          <div class="box">
            <div class="title">Summary</div>
            <div class="content">
              <div class="info-row">
                <div class="subtitle">Total</div>
                <div class="price clearfix">
                  <div>
                    <p class="currency"><?=$order_info['currency'];?></p> 
                    <p class="amount"><?php echo price($order_info['order_purchase_amount']);?></p>
                  </div>
                </div>
              </div>
              <div class="info-row" style="padding-bottom: 10px">
                <div class="subtitle">Shipping</div>
                <div class="price clearfix">
                  <div>
                    <p class="currency"><?=$order_info['currency'];?></p> 
                    <p class="amount"><?php echo price($order_info['order_shipping_amount']);?></p>
                  </div>
                </div>
              </div>
              <div class="info-row" style="border-top: 1px solid #eee; padding-top: 10px">
                <div class="subtitle">Total</div>
                <div class="price clearfix">
                  <div>
                    <p class="currency"><?=$order_info['currency'];?></p> 
                    <p class="amount"><?php echo price($order_info['order_purchase_amount'] + $order_info['order_shipping_amount']);?></p>
                  </div>
                </div>
              </div>
            </div>
          </div><!--box-->

        </aside>

      </div> <!--row-->

    </div><!--.content-->
  </div><!--.container.main-->

<?php
	//}
?>