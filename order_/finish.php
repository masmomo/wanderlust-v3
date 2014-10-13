<script>
<?php
if(!isset($_SESSION['order_number'])){
   echo 'location.href = "'.$prefix_url.'home"';
}
?>
</script>

<?php
/*
# ----------------------------------------------------------------------
# FUNCTIONS
# ----------------------------------------------------------------------
*/

function success($post_order_number){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_order AS order_ INNER JOIN tbl_order_item AS item_ ON order_.order_id = item_.order_id
                                                INNER JOIN tbl_product_type AS type_ ON type_.type_id = item_.type_id
											    INNER JOIN tbl_product AS prod ON type_.product_id = .prod.id
											    LEFT JOIN tbl_promo_item AS discount ON type_.type_id = discount.product_type_id
											    LEFT JOIN tbl_promo AS promo ON discount.promo_id = promo.promo_id
             WHERE `order_number` = '$post_order_number'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function get_cart_item($post_order_number){
   $conn  = connDB();
   
   $sql   = "SELECT * FROM tbl_order AS order_ INNER JOIN tbl_order_item AS item_ ON order_.order_id = item_.order_id
                                               INNER JOIN tbl_product_type AS type_ ON type_.type_id = item_.type_id
											   INNER JOIN tbl_product AS prod ON type_.product_id = .prod.id
											   LEFT JOIN tbl_promo_item AS discount ON type_.type_id = discount.product_type_id
											   LEFT JOIN tbl_promo AS promo ON discount.promo_id = promo.promo_id
             WHERE `order_number` = '$post_order_number'
            ";
   $query = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}


function get_bank_info($payment_method){
	$conn   = connDB();
	$sql    = "SELECT * FROM tbl_account";
	$query  = mysql_query($sql, $conn);
	
	for($i=0;$i<mysql_num_rows($query);$i++){
	   $query_array = mysql_fetch_array($query);
	   
	   if ($payment_method==$query_array['account_bank']){
	      $result = $query_array['account_bank'].' '.$query_array['account_number'].' - '.$query_array['account_name'];
	   }
	   
	}
	
	return $result;
}


function confirm_order($order_no){
   $conn   = connDB();
   $sql   = "UPDATE tbl_order SET   `payment_status` = 'Confirmed', 
	                                `order_confirm_bank` = 'Paypal'
			 WHERE `order_number` = '$order_no'
		    ";
				
   $query = mysql_query($sql, $conn) or die(mysql_error());
}



/*
# ----------------------------------------------------------------------
# DEFINED VARIABLE
# ----------------------------------------------------------------------
*/

$order_number = $_SESSION['order_number'];



/*
# ----------------------------------------------------------------------
# CALL FUNCTIONS
# ----------------------------------------------------------------------
*/
$success      = success($order_number);
$bank_info    = get_bank_info($success['order_payment_method']);


/* --- PAYPAL --- */
if($success['order_payment_method']=='paypal'){
   confirm_order($order_number);
}

//currency module
if($currency=='USD'){
	$success['order_total_amount']        = $success['order_total_amount']/$general['currency_rate'];
}



/*
# ----------------------------------------------------------------------
# EMAIL TO ADMIN
# ----------------------------------------------------------------------
*/
$name      = $general['website_title']; 
$email     = $info['email']; 
$recipient = $info['email']; 
$mail_body = '<body style="font-family: Helvetica, Arial, sans-serif; color:#333333" topmargin="0" leftmargin="0">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="overflow: hidden;">
				  <tbody>
				    <tr>
					  <td>
					    <table width="600" border="0" cellspacing="0" cellpadding="0" align="center" style="overflow: hidden;">
						  <tr>
						    <td style="padding-left: 15px; padding-top: 10px; padding-bottom: 10px; color: #333; font-size: 20px;">'.$general['website_title'].'</td>
					      </tr>
						</table>
				      </td>
					</tr>
			      </tbody>
				</table>
				
				<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="overflow: hidden;">
				  <tbody>
				    <tr>
					  <td>
					    <table width="600" border="0" cellspacing="0" cellpadding="0" align="center" style="border-bottom: 1px solid #e0e0e0">
						  <tr>
						    <td>
							  <td style="font-size: 12px; color: #999; padding-left: 15px; text-align: left;">
							    <span style="font-weight: 100">Order no.</span> <i style="font-size: 14px; color: #333">'.$order_number.'</i>
							  </td>
							  <td style="font-size: 12px; color: #fff; padding: 10px 15px; text-align: right">
							    <span style="line-height: 18px; color: #999"><b style="color: #333">ORDER PLACED</b> </span>
							  </td>
							</td>
					      </tr>
						</table>
					  </td>
					</tr>
				  </tbody>
				</table>
				
				<table width="600" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:12px; overflow: hidden; line-height: 20px; color: #333">
				  <tbody>
				    <tr>
					  <td width="600" style="padding: 25px">
					    <a style="color: #0383ae" href="'.$prefix_url.'admin/customer/'.$global_user['user_alias'].'">'.$global_user['user_fullname'].'</a> has placed an order 
						<a style="color: #0383ae" href="'.$prefix_url.'/admin/order-detailing/'.$order_number.'">'.$order_number.'</a> on '.date('D, j M Y').' at '.date('H:i A').'.<br>
						<br>
						The total amount of <b>IDR '.price($success['order_total_amount']).'</b> will be paid to <b>BCA 6040123123 - '.$general['website_title'].'</b>.
					  </td>
					</tr>
					
					<tr>
					  <td>
					    <table border="0" cellspacing="0" cellpadding="0" style="margin-left: 15px; margin-right: 15px; padding-bottom: 15px; border: 1px solid #e0e0e0">
						  <tr>
						    <td>
							  <table border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 10px; font-size: 14px; text-align: center">
							    <tr>
								  <td width="15"></td>
								  <td width="540" style="padding-top: 13px; padding-bottom: 13px; border-bottom: 1px solid #e0e0e0; font-weight: 100">Sales Order</td>
								  <td width="15"></td>
								</tr>
							  </table>
							</td>
						  </tr>
						  
						  <tr>
						    <td>
							  <table border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 20px; margin-top: 10px; font-size: 11px">
							    <td width="310" style="padding-left: 20px;">
								  <b>Shipping Address</b><br>
								  '.$success['order_shipping_first_name']." ".$success['order_shipping_last_name'].'<br>
								  '.$success['order_shipping_phone'].' <br>
								  '.$success['order_shipping_address'].' <br>
								  '.$success['order_shipping_city'].'<br>
								  '.$success['order_shipping_province'].'<br>
								  '.$success['order_shipping_country'].'<br>
								</td>
								<td width="300" valign="top">
								  <b>Order Date</b> '.date('d/m/Y').'<br>
								  <b>Order No.</b> '.$order_number.'<br>
								  <b>Payment Method</b> '.$success['order_payment_method'].'<br>
								  <b>Shipping Method</b> '.$success['shipping_method'].'<br>
								</td>
							  </table>
							</td>
						  </tr>
						  
						  <tr>
						    <td>
							  <table width="540" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size: 11px; border:">
							    <thead>
								  <tr style="text-align: left;">
								    <th style="border-top: 1px solid #ccc; border-bottom: 1px solid #ccc; padding-left: 5px" width="345">Items</th>
									<th style="border-top: 1px solid #ccc; border-bottom: 1px solid #ccc;" width="120">Price</th>
									<th style="border-top: 1px solid #ccc; border-bottom: 1px solid #ccc; text-align: center" width="60">Qty.</th>
									<th style="border-top: 1px solid #ccc; border-bottom: 1px solid #ccc; padding-right: 5px; text-align: right" width="115">Total</th>
								  </tr>
								</thead>
						      <tbody style="line-height: 18px">';
							  
							  $feeder_mail = get_cart_item($order_number);
							  
							  foreach ($feeder_mail as $mail){
							     $sub_total    = $mail['item_price'] * $mail['item_quantity'];
								 $sub_discount = $mail['item_discount_price'];
								 
								 // DISCOUNT
								 $price = discount_price($mail['promo_id'], $mail['promo_value'], $mail['type_price'], $mail['promo_start_datetime'], $mail['promo_end_datetime']);
								 
								 if(!empty($mail['promo_id']) || $mail['promo_id'] = "" || $mail['promo_start_datetime'] <= date('Y-m-d') and $mail['promo_end_datetime'] >= date('Y-m-d')){
   
								    $cart_price = $price['now_price'];
								    $sub_total  = $cart_price * $mail['item_quantity'];
								 }else{
								    $cart_price = $price['now_price'];
								    $sub_total  = $cart_price * $mail['item_quantity'];
								 }
								 
		              $mail_body.='<tr>
					                <td style="border-bottom: 1px solid #ccc; padding: 5px">
									  <table border="0" cellspacing="0" cellpadding="0">
									    <tr><td><b>'.$mail['product_name'].'</b></td></tr>
										<tr><td>Color : <b>'.$mail['type_name'].'</b></td></tr>
										<tr><td>Size : '.$mail['stock_name'].'</td></tr>
									  </table>
									</td>
									
									<td style="border-bottom: 1px solid #ccc;">IDR '.price($cart_price).'</td>
									<td style="border-bottom: 1px solid #ccc; text-align: center">'.$mail['item_quantity'].'</td>
									<td style="border-bottom: 1px solid #ccc; text-align: right; padding-right: 5px">IDR '.price($sub_total).'</td>
								  </tr>';
								  
				      $discount_amount += $mail['item_discount_price'];
					  $shipping_amount = $mail['order_shipping_amount'];
					  $item_amount     = $mail['order_total_amount'];
					
							  }
		  $mail_body .='      <tbody>
		                    </table>
						  </td>
						</tr>
						
						<tr>
						  <td>
						    <table width="540" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size: 11px; line-height: 16px; padding-top: 7px">
							  <tbody>
							    <tr>
								  <td style="padding-left: 280px; padding-bottom: 5px">DISCOUNT</td>
								  <td style="padding-bottom: 5px; padding-right: 5px; text-align: right">'.price($discount_amount).'</td>
								</tr>
								
								<tr>
								  <td style="padding-left: 280px; padding-bottom: 5px">SHIPPING FEE</td>
								  <td style="padding-bottom: 5px; padding-right: 5px; text-align: right">IDR '.price($shipping_amount).'</td>
								</tr>
								
								<tr>
								  <td style="border-top: 1px solid #ccc; padding: 7px 0 5px 280px">TOTAL</td>
								  <td style="border-top: 1px solid #ccc; padding-right: 5px; font-size: 14px; text-align: right"><b>IDR '.price($item_amount).'</b></td>
								</tr>
							  <tbody>
							</table>
					      </td>
						</tr>
					  </table>
					</td>
				  </tr>
				</tbody>
			  </table>
			  
			  <table width="600" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:11px; color: #999; margin-top:15px">
			    <tbody>
				  <tr>
				    <td style="padding-left:20px; padding-right:20px">
					  &copy; '.date('Y').' '.$general['website_title'].'. Powered by <a style="color: #666; text-decoration: none" href="http://www.antikode.com">Antikode</a>. <br><br>
					</td>
				  </tr>
				</tbody>
			  </table>';
			  
	  $subject  = "[".$general['website_title']."] ORDER PLACED : ".$global_user['customer_first_name'];
	  $headers  = "Content-Type: text/html; charset=ISO-8859-1\r\n".
	  $headers .= "From: ".$general['website_title']." <" .$info['email']. ">\r\n"; //optional headerfields
		 
	  mail($recipient, $subject, $mail_body, $headers);
?>

<div class="container main">
	<img class="m_b_20" src="<?php echo $prefix_url;?>files/common/img_line-dotted.png" width="100%" height="2">
  <div class="content">
    

      <div class="row">

        <ul class="steps col-md-2 visible-md visible-lg">
          <li>Login</li>
          <li class="divider"></li>
          <li>Checkout</li>
          <li class="divider"></li>
          <li class="active">Finish</li>
        </ul>

        <div class="checkout finish col-md-8 col-sm-12 col-xs-12">
          <p>
            Dear <?php echo $global_user['user_first_name'];?>,<br/>
            <br/>
            Your order number is:<br/>
            <span class="orderno"><?php echo $order_number;?></span><br/>
            <br/>
			<?php 
			/* --- PAYPAL --- */
			if($success['order_payment_method']!='paypal'){
			?>
            Please follow the steps below to complete your order:<br/>
            <br/>
			<?php
			}
			?>
          </p>
		  
		  
		  <?php 
		  /* --- NON PAYPAL --- */
		  if($success['order_payment_method']!='paypal'){
		  ?>
          
          <div class="step-box">
            <div class="step-head">STEP 1</div>
            <div class="step-content">
              Pay the amount of <span><?=$currency;?> <?php echo price($success['order_total_amount']);?></span><br/>
              To <span><?php echo $bank_info;?></span>
            </div>
          </div>
          <div class="step-box">
            <div class="step-head">STEP 2</div>
            <div class="step-content">
              Confirm your payment at<br/>
              <a href="<?php echo $prefix_url."confirm";?>"><?php echo $prefix_url."confirm";?></a>
            </div>
          </div>
          
		  <?php
		  }
		  ?>
          
          <p>
            Thank you for shopping with <?php echo $general['website_title'];?>!
          </p>
        </div> <!-- checkout -->

        <aside class="info col-md-2 col-sm-12 col-xs-12">
          <div class="box">
            <div class="title">My Account</div>
            <div class="content">
            - See order history</a><br>
            - Track order<br>
            - Manage details</a><br>
            </div>
          </div><!--box-->
          <a href="<?php echo $prefix_url."my-account/".$global_user['user_alias'];?>" class="btn btn-primary">GO TO MY ACCOUNT</a>
        </aside>

      </div> <!--row-->

        </div><!--.content-->
      </div><!--.container.main-->
    

<?php
/*
# ----------------------------------------------------------------------
# UNSET SESSION
# ----------------------------------------------------------------------
*/

unset($_SESSION['cart_type_id']);
unset($_SESSION['cart_stock_id']);
unset($_SESSION['amount_discount']);
unset($_SESSION['cart_qty']);
unset($_SESSION['amount_purchase']);
unset($_SESSION['order_number']);
?>

<script>
function warning(){
    if(true){
      console.log('leaving');
      return "You are leaving the page";
    }
}
</script>

	