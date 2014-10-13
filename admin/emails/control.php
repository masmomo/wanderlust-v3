<?php
include("get.php");
include("update.php");

/*
==============================
|							 |
|        DETAIL ORDER 	     |
|							 |
==============================

*/
// Set date
$set_fulfilment_date = date("Y-m-d H:i:s");
$courier_order       = orderdetail_get_courier();


$order_number = $_REQUEST['oid'];

$get_order_id = get_order_detail_by_number($order_number);
$order_detail = get_order_detail($get_order_id['order_id']);
$order_item = order_item($order_detail['order_id']);


// Get payment_status
function control_get_payment_status($pay_stat){
   
   if($pay_stat == "Unpaid"){
      $flag_payment_status = "stat red";
   }else if($pay_stat == "Confirmed"){
      $flag_payment_status = "stat yellow";
   }else if($pay_stat == "Paid"){
      $flag_payment_status = "stat green";
   }
   
   return $flag_payment_status;
   
}

// Get fulfillment_status
function control_fulfillment_status($ful_stat){

   if($ful_stat == "Unfulfilled"){
      $flag_fulfillment_status = "stat grey";
   }else if($ful_stat == "In Process" || $ful_stat == "Partial"){
      $flag_fulfillment_status = "stat yellow";
   }else if($ful_stat == "Cancelled" || $ful_stat == "Expired"){
      $flag_fulfillment_status = "stat red";
   }else if($ful_stat == "Delivered"){
      $flag_fulfillment_status = "stat green";
   }
   
   return $flag_fulfillment_status;
}

$order_number = $_REQUEST['oid'];

// CALL FUNCTION
$detail = detail_order($order_number);
$info   = get_info();


if(isset($_POST['btn-order-detail'])){

   if($_POST['btn-order-detail'] == "Mark as Paid"){
      db_update_mark_as_paid($order_detail['order_id']);
	  
   }else if($_POST['btn-order-detail'] == "Save Changes"){

	  $one   = $_POST['order_confirm_bank'];
	  $two   = $_POST['order_confirm_name'];
	  $number = $_POST['order_confirm_amount'];
	  $four  = $order_detail['order_id'];
	  
	  $ten    = $_POST['item_quantity'];
	  $eleven = $_POST['item_id_quantity'];
	  
	  update_order_detail_1($one,$two,$number,$four);
	  update_order_detail_2($ten,$eleven);
   }
   
}

if(isset($_POST['btn-order-detailing'])){

   if($_POST['btn-order-detailing'] == "Mark as Paid"){
      db_update_mark_as_paid($detail['order_id']);
	  
	  if($detail['payment_status'] == "Confirmed"){
	  //send mail
	  $name      = $general['website_title']; 
	  $email     = $info['email']; 
	  $recipient = $detail['user_email']; 
	  $mail_body = '<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="overflow: hidden; background: #fff">
    <tbody>
        <tr>
          <td>
            <table width="600" border="0" cellspacing="0" cellpadding="0" align="center" style="overflow: hidden;">
              <tr>
                <td style="padding-left: 15px; padding-top: 10px; padding-bottom: 10px">
                  <img src="'.$prefix_url.'files/common/logo.jpg" height="50">
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
                    <span style="line-height: 18px; color: #999"><b style="color: #39b54a">PAYMENT VERIFIED</b> </span>
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
          Dear '.$detail['user_fullname'].',<br>
          <br>
          We have verified your payment for order number <b>'.$order_number.'</b>. We are currently processing your order and will be delivered using <b>'.$detail['shipping_method'].'</b> to:<br>
          <br>
          <b>'.$detail['order_shipping_first_name'].' '.$detail['order_shipping_last_name'].'</b><br>
          '.$detail['order_billing_phone'].'<br>
          '.$detail['order_shipping_address'].'<br>
          '.$detail['order_shipping_province'].'<br>
          '.$detail['order_shipping_country'].'<br>
          <br>
          Once the order has been delivered, we will send another email notifying you about the delivery details.<br>
          <br>
          If you believe there is an error regarding the information stored. Please contact us through email at <a style="color:#0383ae" href="'.$info['email'].'">'.$info['email'].'</a>. Thank you!
        </td>
      </tr>
    </tbody>
  </table>





  <table width="600" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:11px; color: #999; margin-top:15px">
    <tbody>
      <tr>
        <td style="padding-left:20px; padding-right:20px;padding-bottom:20px">
          &copy; 2014 '.$general['website_title'].'. Powered by <a style="color: #666; text-decoration: none" href="http://www.antikode.com">Antikode</a>. <br><br>
        </td>
      </tr>
    </tbody>
  </table>';
  
  	  $subject   = "[".$general['website_title']."] ".$order_number." Payment Verified"; 
  	  $headers   = "Content-Type: text/html; charset=ISO-8859-1\r\n".
      $headers  .= "From: ".$general['website_title']." <" .$info['email']. ">\r\n"; //optional headerfields
  
      mail($recipient, $subject, $mail_body, $headers);
	  }
   }
   /*
   else if($_POST['btn-order-detail'] == "Save Changes"){

	  $one   = $_POST['order_confirm_bank'];
	  $two   = $_POST['order_confirm_name'];
	  $three = $_POST['order_confirm_amount'];
	  $four  = $order_detail['order_id'];
	  
	  $ten    = $_POST['item_quantity'];
	  $eleven = $_POST['item_id_quantity'];
	  
	  update_order_detail_1($one,$two,$three,$four);
	  update_order_detail_2($ten,$eleven);
   }
   */
   
}

/* VALIDATION FRO BUTTON DELIVER ITEM */

if(isset($_POST['deliver-validation'])){
   
   if($_POST['deliver-validation'] == "validation"){
      $_SESSION['alert'] = "error";
	  $_SESSION['msg']   = "Can't deliver item because this order must be paid first";
   }
   
}

/* DML SHIPPING NUMBER */
if(isset($_POST['btn-order-confirm'])){
   
   if($_POST['btn-order-confirm'] == "Confirm"){ 
	  $order_item   = $_POST['backup_item_id'];
	  $current_date = current_date_sql();
	  
	  foreach($order_item as $order_item){
	     // DEFINED VARIABLE
	     $service          = $_POST['shipping-service'];
	     $order_id         = $_POST['hidden_order_id'];
	     $shipping_number  = $_POST['order_shipping_number'];
	     $fulfillment_date = $current_date;
	     $notify           = $_POST['notify-deliver'];
	     $user_email       = $detail['user_email'];
		 
         updateShippingNumber($order_id, $order_item, $shipping_number, $fulfillment_date, $service);
	  }
	  
	  updateFulfillment_status($order_id, 'Delivered');
	  
	  if(!empty($notify)){
		  
	     // SEND MAIL TO CUSTOMER
		 $updated_detail = detail_order($order_number);
	  
	  //if($detail['payment_status'] == "Paid"){
	  //send mail
	  $name      = $general['website_title']; 
	  $email     = $info['email']; 
	  $recipient = $detail['user_email']; 
	  $mail_body = '<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="overflow: hidden;">
    <tbody>
        <tr>
          <td>
            <table width="600" border="0" cellspacing="0" cellpadding="0" align="center" style="overflow: hidden;">
              <tr>
                <td style="padding-left: 15px; padding-top: 10px; padding-bottom: 10px">
                  <img src="'.$prefix_url.'files/common/logo.jpg" height="50">
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
                    <span style="line-height: 18px; color: #999"><b style="color: #39b54a">DELIVERED</b> </span>
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
          Dear '.$detail['user_fullname'].',<br>
          <br>
          Your order <b>'.$order_number.'</b> has been delivered to your shipping address with the following details:<br>
          <br>
          <table width="100%" border="0" cellspacing="0" cellpadding="10" bgcolor="#f6f6f6" style="font-size: 12px">
            <tr>
              <td>
                <b>Courier</b> '.$detail['shipping_method'].'<br>';
				
				function trim_shipping_number($num){
				   $first  = substr($num,0,1);
				   $second = substr($num,1,5);
				   $last   = substr($num,6,5);
				   
				   $return = $first.' '.$second.' '.$last;
				   
				   return $return;
				}
				
				$mail_body .='
                <b>Delivery No.</b> '.trim_shipping_number($updated_detail['shipping_number']).'<br>
              </td>
            </tr>
          </table>
          <br>
          For order tracking, please go to <a style="color: #0383ae" href="http://www.jne.co.id">www.jne.co.id</a> and put your delivery number.<br>
          <br>
          Remember that you can always see your order history by visiting <a style="color: #0383ae" href="'.$prefix_url.'../account/'.$detail['user_alias'].'">My Account</a> on our web store. Thank you for shopping with Shop Name.
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
                        Sales Receipt
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
					'.$detail['order_shipping_first_name'].' '.$detail['order_shipping_last_name'].'</b><br>
					'.$detail['order_billing_phone'].'<br>
					'.$detail['order_shipping_address'].'<br>
					'.$detail['order_shipping_province'].'<br>
					'.$detail['order_shipping_country'].'<br>
                  </td>
                  <td width="300" valign="top">
                    <b>Order Date</b> '.date('j/m/Y',strtotime($detail['order_date'])).'<br>
                    <b>Order No.</b> '.$order_number.'<br>
                    <b>Receipt Date</b> '.date('j/m/Y',strtotime($detail['fulfillment_date'])).'<br>
                    <b>Payment Method</b> Bank Transfer via '.$updated_detail['order_payment_method'].'<br>
                    <b>Shipping Method</b> '.$detail['services'].'<br>
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
                  <tbody style="line-height: 18px">
                    <tr>
                      <td style="border-bottom: 1px solid #ccc; padding: 5px">
                        <table border="0" cellspacing="0" cellpadding="0">
                          <tr><td><b>Product Name</b></td></tr>
                          <tr><td>Color</td></tr>
                          <tr><td>Size</td></tr>
                        </table>
                      </td>
                      <td style="border-bottom: 1px solid #ccc;">IDR 100.000</td>
                      <td style="border-bottom: 1px solid #ccc; text-align: center">2</td>
                      <td style="border-bottom: 1px solid #ccc; text-align: right; padding-right: 5px">IDR 200.000</td>
                    </tr>
                    <tr>
                      <td style="border-bottom: 1px solid #ccc; padding: 5px">
                        <table border="0" cellspacing="0" cellpadding="0">
                          <tr><td><b>Product Name</b></td></tr>
                          <tr><td>Color</td></tr>
                          <tr><td>Size</td></tr>
                        </table>
                      </td>
                      <td style="border-bottom: 1px solid #ccc;">IDR 100.000</td>
                      <td style="border-bottom: 1px solid #ccc; text-align: center">2</td>
                      <td style="border-bottom: 1px solid #ccc; text-align: right; padding-right: 5px">IDR 200.000</td>
                    </tr>
                    <tr>
                      <td style="border-bottom: 1px solid #ccc; padding: 5px">
                        <table border="0" cellspacing="0" cellpadding="0">
                          <tr><td><b>Product Name</b></td></tr>
                          <tr><td>Color</td></tr>
                          <tr><td>Size</td></tr>
                        </table>
                      </td>
                      <td style="border-bottom: 1px solid #ccc;">IDR 100.000</td>
                      <td style="border-bottom: 1px solid #ccc; text-align: center">2</td>
                      <td style="border-bottom: 1px solid #ccc; text-align: right; padding-right: 5px">IDR 200.000</td>
                    </tr>
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
                      <td style="padding-bottom: 5px; padding-right: 5px; text-align: right">0</td>
                    </tr>
                    <tr>
                      <td style="padding-left: 280px; padding-bottom: 5px">SHIPPING FEE</td>
                      <td style="padding-bottom: 5px; padding-right: 5px; text-align: right">IDR 10.000</td>
                    </tr>
                    <tr>
                      <td style="border-top: 1px solid #ccc; padding: 7px 0 5px 280px">TOTAL</td>
                      <td style="border-top: 1px solid #ccc; padding-right: 5px; font-size: 14px; text-align: right"><b>IDR 110.000</b></td>
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
        <td style="padding-left:20px; padding-right:20px; padding-bottom: 20px">
          &copy; 2014 Website Name. Powered by <a style="color: #666; text-decoration: none" href="http://www.antikode.com">Antikode</a>. <br><br>
        </td>
      </tr>
    </tbody>
  </table>';
  
  	  $subject   = "[".$general['website_title']."] ".$order_number." Order Delivered + Sales Receipt"; 
  	  $headers   = "Content-Type: text/html; charset=ISO-8859-1\r\n".
      $headers  .= "From: ".$general['website_title']." <" .$info['email']. ">\r\n"; //optional headerfields
  
      mail($recipient, $subject, $mail_body, $headers);
	  //}
		 
         $_SESSION['alert'] = "success";
	     $_SESSION['msg']   = "Successfully delivered item(s). An email has been sent to ".$detail['user_email'];
	  }else{
         $_SESSION['alert'] = "success";
	     $_SESSION['msg']   = "Successfully delivered item(s).";
	  }
	  
   }
   
}

// Submit handler
if(isset($_POST['btn-order-detail'])){

   if($_POST['btn-order-detail'] == "Mark as Paid"){
      db_update_mark_as_paid($order_detail['order_id']);
   }else if($_POST['btn-order-detail'] == "Save Changes"){

	  $one   = $_POST['order_confirm_bank'];
	  $two   = $_POST['order_confirm_name'];
	  $three = $_POST['backup_order_confirm_amount'];
	  $four  = $order_detail['order_id'];
	  
	  $ten    = $_POST['item_quantity'];
	  $eleven = $_POST['item_id_quantity'];
	  
	  update_order_detail_1($one,$two,$three,$four);
	  update_order_detail_2($ten,$eleven);
   }

}


// Get payment_status
$flag_payment_status = control_get_payment_status($order_detail['payment_status']);

// Get fulfillment_status
$flag_fulfillment_status = control_fulfillment_status($order_detail['fulfillment_status']);

$flag_paid = $detail['order_confirm_amount'] - $detail['order_total_amount'];

function flag_paid($total, $confirm){
   $flag_paid = $confirm - $total;
   
   if($flag_paid > 0){
      $print = "<p class=\"help-block help-danger\">Underpaid IDR : ".number_format($flag_paid,0,',','.')."</p>";
   }else{
      $print = "<p class=\"help-block help-success\">Overpaid IDR : ".number_format($flag_paid,0,',','.')."</p>";
   }
   
   echo $print;
   
}

function get_price($post_promo_id, $post_promo_value, $post_was_price){
   
   if($post_promo_id == 1){
      $now_price = $post_was_price - (($post_promo_value / 100) * $post_was_price);
   }else{
      $now_price = $post_was_price - $post_promo_value;
   }
   
   return $now_price;
   
}
?>