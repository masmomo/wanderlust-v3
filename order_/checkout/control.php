<?php
include('get.php');
include('update.php');

// DEFINED VARIABLE
$session_type     = $_SESSION['cart_type_id'];
$session_stock    = $_SESSION['cart_stock_id'];
$session_qty      = $_SESSION['cart_qty'];
$session_amount   = $_SESSION['amount_purchase'];
$session_discount = $_SESSION['amount_discount'];

//promo module
$i=0;
$items = array();
foreach($session_type as $key=>$type){
	$single_item     = get_cart_item($type, $session_stock[$key]);
	
	$single_item['qty'] = $session_qty[$key];
	
	//currency module
	  if($currency=='USD'){
		$single_item['type_price'] = $single_item['type_price']/$general['currency_rate'];
	  }
	
	$single_item['total_per_item'] = $single_item['qty'] * $single_item['type_price'];
		
	//promo module
	if(!empty($single_item['promo_item_id']) && $single_item['promo_start_datetime'] <= date('Y-m-d') && $single_item['promo_end_datetime'] >= date('Y-m-d')){

	  if($single_item['promo_item_id'] == 1){
	    $single_item['type_discount_price'] = $single_item['type_price'] - (($single_item['promo_value'] / 100) * $single_item['type_price']);
	  }else{
	    $single_item['type_discount_price'] = $single_item['type_price'] - $single_item['promo_value'];
      }

	  $single_item['total_per_item'] = $single_item['qty'] * $single_item['type_discount_price'];
	}
	
	array_push($items,$single_item);
	$i++;
}

//print_r($items);

//COUNTRY
$get_country = get_country();

//CITY
if(!empty($global_user['user_city'])){

   // CALL FUNCTION
   $user_city = setCity($global_user['user_province']);
}
else{
   $user_city = setCity('Jakarta');
}


// ORDER NUMBER
$ord_name    = strtoupper(substr($global_user['user_first_name'], 0, 3));// 3 Character customer first name
$ord_day     = date("d");                                             // Day (01 - 31)
$ord_month   = date("m"); 											  // Month (01 - 12)
$ord_year    = date("y");                                             // Year (86, 99, 13 etc..)
$ord_date    = $ord_year."-".$ord_month."-".$ord_day;
$ord_dates   = $ord_day.$ord_month.$ord_year;

$generate_order_number = generate_order_number($ord_date);
$format_order_number   = $ord_name.$ord_dates;

if(strlen((int) $generate_order_number['digits']) == 1){
   $add_order = "00";
}else if(strlen((int) $generate_order_number['digits']) == 2){
   $add_order = "0";
}else if(strlen((int) $generate_order_number['digits']) == 3){
   $add_order = "";
}

$order_counter = $add_order.((int) $generate_order_number['digits']+1);


// WEIGHT
foreach($session_type as $key=>$type){
   $weight = get_cart($type);
   
   $total_weight += $weight['type_weight'] * $session_qty[$key];
      
}


// CALL FUNCTIONS
$province = get_province();

if(isset($_POST['btn_submit_checkout'])){

   /* --- COURIER --- */
   $courier_rate  = get_courier($_POST['hidden_checkout_courier']);
   $courier_name  = get_courier_name($courier_rate['courier_name']);
   $total_weights = ceil($total_weight/$courier_rate['courier_weight']);
   
   
   /* --- DEFINED VARIABLE --- */
   $order_number 			= $format_order_number.$order_counter;
   $order_billing_fname    = $global_user['user_first_name'];
   $order_billing_lname    = $global_user['user_last_name'];
   $order_billing_fullname = $global_user['user_fullname'];
   $order_billing_email    = $global_user['user_email'];
   $order_billing_phone    = $global_user['user_phone'];
   
   $order_ship_fname       = clean_alphabet($_POST['checkout_user_fname']);
   $order_ship_lname       = clean_alphabet($_POST['checkout_user_lname']);
   $order_ship_phone       = clean_number($_POST['checkout_user_phone']);
   $order_ship_address     = $_POST['checkout_user_address'];
   $order_ship_country     = clean_alphabet($_POST['checkout_user_country']);
   $order_ship_province    = clean_alphabet($_POST['checkout_user_province']);
   $order_ship_city        = clean_alphabet($_POST['checkout_user_city']);
   $order_ship_postal      = clean_number($_POST['checkout_user_postal']);
   $order_ship_note        = "No message";
   $order_ship_method      = $courier_name['courier_name'];
   $order_ship_gift        = 0;
   $order_ship_gift_msg    = "No message";
   
   $order_payment_method   = $_POST['checkout_payment_method'];
   $order_status           = "Open";
   $order_payment          = "Unpaid";
   $order_fulfillment      = "Unfulfilled";
   
   $purchase_amount        = clean_number($_POST['hidden_checkout_amount']);
   $purchase_shipping      = clean_number($total_weights * $courier_rate['courier_rate']);
   $purchase_discount      = clean_number($_POST['hidden_checkout_discount']);
   $purchase_voucher       = clean_number($_POST['hidden_checkout_discount']);
   $purchase_total         = clean_number($_POST['hidden_checkout_total']);
   
   /* --- currency module ---*/
   if($currency=='USD'){
      $purchase_amount        = clean_number($_POST['hidden_checkout_amount']*$general['currency_rate']);
	  //$purchase_shipping      = clean_number($courier_rate['courier_rate'] *$general['currency_rate'] * $total);
	  $purchase_discount      = clean_number($_POST['hidden_checkout_discount']*$general['currency_rate']);
	  $purchase_voucher       = clean_number($_POST['hidden_checkout_discount']*$general['currency_rate']);
	  $purchase_total         = clean_number($_POST['hidden_checkout_total']*$general['currency_rate']);
   }
   
   $purchase_date          = $ord_date;
   $purchase_open          = $ord_date;
   $purchase_cancelled     = "0000-00-00 00:00:00";
   $purchase_expired       = "0000-00-00 00:00:00";
   $purchase_closed        = "0000-00-00 00:00:00";
   
   $confirm_bank           = "";
   $confirm_name           = "";
   $confirm_amount         = "";
   
   $bank_info = get_bank_info();

   insertOrder($order_number, $order_billing_fname, $order_billing_lname, $order_billing_fullname, $order_billing_email, $order_billing_phone, $order_ship_fname, $order_ship_lname, $order_ship_phone, $order_ship_address, $order_ship_country, $order_ship_province, $order_ship_city, $order_ship_postal, $order_ship_method, $order_ship_gift, $order_ship_gift_msg, $order_payment_method, $order_status, $order_payment, $order_fulfillment, $purchase_amount, $purchase_shipping, $purchase_discount, $purchase_voucher, $purchase_total, $purchase_date, $purchase_open, $purchase_cancelled, $purchase_closed, $confirm_bank, $confirm_name, $confirm_amount);
   
   $get_order_id = get_latest_order();

   	//currency module
	if($currency=='USD'){
		updateOrderCurrency($currency,$general['currency_rate'],$get_order_id['latest_order_id']);
	 }
   
   insertUserPurchase($global_user['user_id'], $get_order_id['latest_order_id']);
   
   $_SESSION['order_number'] = $order_number;
   
   
   foreach($session_type as $key=>$order_item){
      $get_cart    = get_cart_item($order_item, $session_stock[$key]);
	  $get_stock   = get_stock($session_stock[$key]);
	
	  //promo module
	  if(!empty($get_cart['promo_item_id']) && $get_cart['promo_start_datetime'] <= date('Y-m-d') && $get_cart['promo_end_datetime'] >= date('Y-m-d')){

	  	if($get_cart['promo_type_id'] == 1){
	    	$get_cart['type_discount_price'] = $get_cart['type_price'] - (($get_cart['promo_value'] / 100) * $get_cart['type_price']);
	  	}else{
	    	$get_cart['type_discount_price'] = $get_cart['type_price'] - $get_cart['promo_value'];
      	}
	  }
	  else{
	    $get_cart['type_discount_price'] = '';
	  }
	  
      insertOrderItem($get_order_id['latest_order_id'], $order_item, $get_stock['stock_name'], $session_qty[$key], $get_cart['type_price'], $get_cart['type_discount_price'], "0000-00-00 00:00:00", ' ', ' ');
	  
	  // DECREMENT STOCK
	  $now_qty = $get_cart['stock_quantity'] - $session_qty[$key];
	  
	  updateProduct($now_qty, $session_stock[$key]);
	  
	  
	  // GET DISCOUNT
	  if($get_cart['promo_id'] == 1 and $get_cart['promo_start_datetime'] <= date('Y-m-d') and $get_cart['promo_end_datetime'] >= date('Y-m-d')){
         $item_discount = ($get_cart['promo_value'] / 100) * $get_cart['type_price'];
	  }else if($get_cart['promo_id'] == 2 and $get_cart['promo_start_datetime'] <= date('Y-m-d') and $get_cart['promo_end_datetime'] >= date('Y-m-d')){
         $item_discount = $get_cart['promo_value'];
	  }
	  
	  $get_discount += $item_discount;
	
	   //SOLD OUT
	   $get_product_id     = success_get_productid($order_item);

	   $check_product_sold = success_check_productsoldout($get_product_id['id']);
	   $check_type_sold    = success_check_typesoldout($order_item);

	   // UPDATE SOLD OUT TYPE
	   if($check_type_sold['stock'] < 1){
	      success_update_typesoldout($order_item);
	   }

	   // UPDATE SOLD OUT PRODUCT
	   if($check_product_sold['stock'] < 1){
	      success_update_productsoldout($get_product_id['id']);
	   }
	  
   }// FOREACH
   
   // UPDATE tbl_order
   update_discount($get_discount, $total_voucher, $order_number);
   
   // UPDATE tbl_user
   updateUser($order_ship_phone, $order_ship_address, $order_ship_country, $order_ship_province, $order_ship_city, $order_ship_postal, $_SESSION['user_id']);
   
    //currency module
    $purchase_amount        = clean_number($_POST['hidden_checkout_amount']);
	$purchase_shipping      = clean_number($courier_rate['courier_rate'] /$courier_rate['courier_weight']* $total_weight);
	$purchase_discount      = clean_number($_POST['hidden_checkout_discount']);
	$purchase_voucher       = clean_number($_POST['hidden_checkout_discount']);
	$purchase_total         = clean_number($_POST['hidden_checkout_total']);
   // MAIL
	
 
   $name      = $general['website_title']; 
   $email     = $info['email']; 
   $recipient = $global_user['user_email']; 
	
   $mail_body = '<body style="font-family: Helvetica, Arial, sans-serif; color:#333333" topmargin="0" leftmargin="0">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="overflow: hidden; background: #fff">
    <tbody>
        <tr>
          <td>
            <table width="600" border="0" cellspacing="0" cellpadding="0" align="center" style="overflow: hidden; background: #fff">
              <tr>
                <td style="padding-left: 15px; padding-top: 10px; padding-bottom: 10px">
                  <img src="'.$prefix_url.'admin/'.$general['logo'].'" height="50">
                </td>
              </tr>
            </table>
          </td>
        </tr>
    </tbody>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="overflow: hidden; background: #f0f0f0; border-bottom: 1px solid #e0e0e0">
    <tbody>
        <tr>
          <td>
            <table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
              <tr>
                <td>
                  <td style="font-size: 12px; color: #999; padding-left: 15px; text-align: left;">
                    <span style="font-weight: 100">Order no.</span> <i style="font-size: 14px; color: #333">'.$order_number.'</i>
                  </td>
                  <td style="font-size: 12px; color: #fff; padding: 10px 15px; text-align: right">
                    <span style="line-height: 18px; color: #999"><b style="color: #cc0000">WAITING FOR PAYMENT</b> </span>
                  </td>
                </td>
              </tr>
            </table>
          </td>
        </tr>
    </tbody>
  </table>
  <table width="600" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:12px; overflow: hidden; background: #fff; line-height: 20px">
    <tbody>
      <tr>
        <td width="600" bgcolor="#fff" style="padding: 25px">
          Dear '.$order_ship_fname." ".$order_ship_lname.',<br>
          <br>
          Thank you for placing your order at '.$general['website_title'].'. Your order number is <b>'.$order_number.'</b>. To complete the order process, please pay the total amount of <b style="color: #000">'.$currency.' '.price($purchase_total).'</b> to:<br>
          <br>
          <table width="100%" border="0" cellspacing="0" cellpadding="10" bgcolor="#f6f6f6" style="font-size: 14px">';
			  
			  foreach($bank_info as $bank_info){
			     echo '<tr>';
				 echo '   <td>';
				 echo       $bank_info['account_number']." - ".$bank_info['account_name'];
				 echo '   </td>';
				 echo '</tr>';
			  }
			  
			  $mail_body .='
          </table>
          <br>
          And confirm your payment at <a style="color: #0383ae" href="'.$prefix_url."confirm-payment".'">'.$general['url'].'/confirm-payment</a><br>
          <br>
          <i style="color: #cc0000">*Please note that your order will be set as expired if no confirmation is made within 2x24 hours.</i>
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
                      <td width="540" style="padding-top: 13px; padding-bottom: 13px; border-bottom: 1px solid #e0e0e0; font-weight: 100">
                        Order Receipt 
                      </td>
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
                    '.$order_ship_fname." ".$order_ship_lname.'<br>
					'.$order_ship_phone.' <br>
					'.$order_ship_address.' <br>
                    '.$order_ship_province.'<br>
                    '.$order_ship_country.'<br>
                  </td>
                  <td width="300" valign="top">
                    <b>Order Date</b> '.date('D, j M Y').'<br>
                    <b>Order No.</b> '.$order_number.'<br>
                    <b>Payment Method</b> '.$order_payment_method.'<br>
                    <b>Shipping Method</b> '.$order_ship_method.'<br>
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
				  
				
				  foreach ($items as $item){
					
					
					$sub_total = $item['type_price'] * $item['qty'];
					
                    $mail_body.= '<tr>
                      <td style="border-bottom: 1px solid #ccc; padding: 5px">
                        <table border="0" cellspacing="0" cellpadding="0">
                          <tr><td><b>'.$item['product_name'].'</b></td></tr>
                          <tr><td>Color : <b>'.$item['type_name'].'</b></td></tr>
                          <tr><td>Size : <b>'.$item['stock_name'].'</b></td></tr>
                        </table>
                      </td>
					  
                      <td style="border-bottom: 1px solid #ccc;">'.$currency.' '.price($item['type_price']).'</td>
                      <td style="border-bottom: 1px solid #ccc; text-align: center">'.$item['qty'].'</td>
                      <td style="border-bottom: 1px solid #ccc; text-align: right; padding-right: 5px">'.$currency.' '.price($sub_total).'</td>
                    </tr>';
					
				     $discount_amount += $item['type_discount_price'];
				     $item_amount += $sub_total;
				  }
					
                    $mail_body .= '
                  <tbody>
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
                      <td style="padding-bottom: 5px; padding-right: 5px; text-align: right">'.$currency.' '.price($purchase_shipping).'</td>
                    </tr>
                    <tr>
                      <td style="border-top: 1px solid #ccc; padding: 7px 0 5px 280px">TOTAL</td>
                      <td style="border-top: 1px solid #ccc; padding-right: 5px; font-size: 14px; text-align: right"><b>'.$currency.' '.price($item_amount+ $purchase_shipping -$discount_amount).'</b></td>
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
          © '.date('Y').' '.$general['website_title'].'. Powered by <a style="color: #666; text-decoration: none" href="http://www.antikode.com">Antikode</a>. <br><br>
        </td>
      </tr>
    </tbody>
  </table>';

	  $subject = '['.$general['website_title'].'] '.$order_number.' Waiting for Payment';
	  $headers = "Content-Type: text/html; charset=ISO-8859-1\r\n".
	  $headers .= "From: ".$general['website_title']." <" .$info['email']. ">\r\n"; //optional headerfields
		 
	  mail($recipient, $subject, $mail_body, $headers);
	
	// ADMIN MAIL

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
	                <td style="padding-left: 15px; padding-top: 10px; padding-bottom: 10px; color: #333; font-size: 20px;">
	                  '.$general['website_title'].'
	                </td>
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
	          <a style="color: #0383ae" href="">'.$global_user['user_first_name']." ".$global_user['user_last_name'].'</a> has placed an order <a style="color: #0383ae" href="">'.$order_number.'</a> on '.date('D, j M Y').' at '.date('H:i A').'.<br>
	          <br>
	          The total amount of <b>'.$currency.' '.price($purchase_total).'</b> will be paid to <b>'.$bank_info.'</b>.
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
	                      <td width="540" style="padding-top: 13px; padding-bottom: 13px; border-bottom: 1px solid #e0e0e0; font-weight: 100">
	                        Sales Order
	                      </td>
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
		                    '.$order_ship_fname." ".$order_ship_lname.'<br>
							'.$order_ship_phone.' <br>
							'.$order_ship_address.' <br>
							'.$order_ship_city.'<br>
		                    '.$order_ship_province.'<br>
		                    '.$order_ship_country.'<br>
		                  </td>
		                  <td width="300" valign="top">
		                    <b>Order Date</b> '.date('D, j M Y').'<br>
		                    <b>Order No.</b> '.$order_number.'<br>
		                    <b>Payment Method</b> '.$order_payment_method.'<br>
		                    <b>Shipping Method</b> '.$order_ship_method.'<br>
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
		
					  foreach ($items as $item){
						
						$sub_total    = $item['type_price'] * $item['qty'];
						$sub_discount = $item['type_discount_price'];

	                    $mail_body.='<tr>
	                      <td style="border-bottom: 1px solid #ccc; padding: 5px">
	                        <table border="0" cellspacing="0" cellpadding="0">
	                          <tr><td><b>'.$item['product_name'].'</b></td></tr>
	                          <tr><td>Color : <b>'.$item['type_name'].'</b></td></tr>
	                          <tr><td>Size : '.$item['stock_name'].'</td></tr>
	                        </table>
	                      </td>
	                      <td style="border-bottom: 1px solid #ccc;">'.$currency.' '.price($item['type_price']).'</td>
	                      <td style="border-bottom: 1px solid #ccc; text-align: center">'.$item['qty'].'</td>
	                      <td style="border-bottom: 1px solid #ccc; text-align: right; padding-right: 5px">'.$currency.' '.price($sub_total).'</td>
	                    </tr>';

						$discount_amount += $item['type_discount_price'];
						$item_amount     += $subtotal;

					  }

	                    $mail_body .='
	                  <tbody>
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
	                      <td style="padding-bottom: 5px; padding-right: 5px; text-align: right">'.$currency.' '.price($purchase_shipping).'</td>
	                    </tr>
	                    <tr>
	                      <td style="border-top: 1px solid #ccc; padding: 7px 0 5px 280px">TOTAL</td>
	                      <td style="border-top: 1px solid #ccc; padding-right: 5px; font-size: 14px; text-align: right"><b>'.$currency.' '.price($item_amount+ $purchase_shipping -$discount_amount).'</b></td>
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
	          © '.date('Y').' '.$general['website_title'].'. Powered by <a style="color: #666; text-decoration: none" href="http://www.antikode.com">Antikode</a>. <br><br>
	        </td>
	      </tr>
	    </tbody>
	  </table>';
	
		  $subject = "[".$general['website_title']."] ORDER PLACED : ".$global_user['customer_first_name'];
		  $headers = "Content-Type: text/html; charset=ISO-8859-1\r\n".
		  $headers .= "From: ".$general['website_title']." <" .$info['email']. ">\r\n"; //optional headerfields

		  $success = mail($recipient, $subject, $mail_body, $headers);
   
?>

<!--PAYPAL-->
<?php 
if($order_payment_method=='paypal'){
	if($currency=='IDR'){
		$purchase_total = ceil($purchase_total / $general['currency_rate']);
	}
?>
<script src="script/paypal-button.min.js?merchant=gary@antikode.com"
    data-button="buynow"
    data-name="<?=$order_number;?>"
    data-amount="<?=$purchase_total;?>"
	data-return="http://www.antikode.com/statuquo/finish" 
	data-env="sandbox"
></script>
<input type="hidden" id="paypal_flag" value="1" />
<?php 
}//paypal
?>

<?php
	}
?>