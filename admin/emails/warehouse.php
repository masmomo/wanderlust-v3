<?php
include("../custom/static/general.php");
include("../static/general.php");

function get_person($post_order_number){
   $conn  = connDB();
   
   $sql    = "SELECT * FROM tbl_order AS order_ INNER JOIN tbl_user_purchase AS pur ON order_.order_id = pur.order_id
                                                INNER JOIN tbl_user AS user ON pur.user_id = user.user_id
              WHERE `order_number` = '$post_order_number'
			 ";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function get_cart($post_order_number){
   $conn  = connDB();
   
   $sql    = "SELECT * FROM tbl_order AS order_ INNER JOIN tbl_order_item AS item ON order_.order_id = item.order_id
              WHERE `order_number` = '$post_order_number'
			 ";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function get_items($post_order_number){
   $conn  = connDB();
   
   $sql    = "SELECT * FROM tbl_order AS order_ INNER JOIN tbl_order_item AS item ON order_.order_id = item.order_id
                                                INNER JOIN tbl_product_type AS type_ ON item.type_id = type_.type_id
												INNER JOIN tbl_product AS prod ON type_.product_id = prod.id
              WHERE `order_number` = '$post_order_number'
			 '";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
	  array_push($row, $result);
   }
   
   return $row;
}


$order_number = $_REQUEST['ornum'];



// CALL FUNCTION
$cart   = get_cart($_REQUEST['ornum']);
$person = get_person($order_number);
$item   = get_items($_REQUEST['ornum']);

// DEFINED VARIABLE
$amount = $_REQUEST['amount'];


// MAIL CONFIRMED FOR ADMIN
   $name      = $general['website_title']; 
   $email     = $info['email']; 
   $recipient = $info['email_warehouse']; 
   $mail_body = '<body style="font-family: Helvetica, Arial, sans-serif; color:#fff" topmargin="0" leftmargin="0">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="overflow: hidden;">
    <tbody>
        <tr>
          <td>
            <table width="600" border="0" cellspacing="0" cellpadding="0" align="center" style="overflow: hidden;">
              <tr>
                <td style="padding-left: 15px; padding-top: 10px; padding-bottom: 10px; color: #333; font-size: 20px;">
                  '.$general['website_title'].' Admin
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
                    <span style="font-weight: 100">Order no.</span> <i style="font-size: 14px; color: #333">'.$cart['order_number'].'</i>
                  </td>
                  <td style="font-size: 12px; color: #fff; padding: 10px 15px; text-align: right">
                    <span style="line-height: 18px; color: #999"><b style="color: #333">DELIVERY ORDER</b> </span>
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
          Please process the following order immediately.
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
                        Delivery Order
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
                    '.$person['user_fullname'].'<br>
                    '.$person['user_address'].'<br>
                    '.$person['user_city'].'<br>
                    '.$person['user_province'].'<br>
                    '.$person['user_country'].'<br>
                  </td>
                  <td width="300" valign="top">
                    <b>Order Date</b> '.format_date_min($cart['order_date']).'<br>
                    <b>Order No.</b> '.$cart['order_number'].'
                    <b>Payment Method</b> Bank Transfer via '.$cart['order_payment_method'].'<br>
                    <b>Shipping Method</b> '.$cart['shipping_method'].'<br>
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
				  
				  foreach($item as $item){
				     
					 $price    = $item['item_price'] - $item['item_discount_price'];
					 $sub_item = $price * $item['item_quantity'];
				  
                    $mail_body .= ' <tr>
                      <td style="border-bottom: 1px solid #ccc; padding: 5px">
                        <table border="0" cellspacing="0" cellpadding="0">
                          <tr><td><b>'.$item['product_name'].'</b></td></tr>
                          <tr><td>'.$item['type_name'].'</td></tr>
                          <tr><td>'.$item['stock_name'].'</td></tr>
                        </table>
                      </td>
                      <td style="border-bottom: 1px solid #ccc;">IDR '.price($price).'</td>
                      <td style="border-bottom: 1px solid #ccc; text-align: center">'.$item['item_quantity'].'</td>
                      <td style="border-bottom: 1px solid #ccc; text-align: right; padding-right: 5px">IDR '.price($sub_item).'</td>
                    </tr>';
				  }
					
                  $mail_body .= ' <tbody>
                </table>
              </td>
            </tr>
            <tr>
              <td>
                <table width="540" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size: 11px; line-height: 16px; padding-top: 7px">
                  <tbody>
                    <tr>
                      <td style="padding-left: 280px; padding-bottom: 5px">SHIPPING FEE</td>
                      <td style="padding-bottom: 5px; padding-right: 5px; text-align: right">IDR '.price($cart['order_shipping_amount']).'</td>
                    </tr>
                    <tr>
                      <td style="border-top: 1px solid #ccc; padding: 7px 0 5px 280px">TOTAL</td>
                      <td style="border-top: 1px solid #ccc; padding-right: 5px; font-size: 14px; text-align: right"><b>IDR '.price($cart['order_total_amount']).'</b></td>
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
          &copy; '.date("Y").' '.$general['website_title'].'. Powered by <a style="color: #666; text-decoration: none" href="http://www.antikode.com">Antikode</a>. <br><br>
        </td>
      </tr>
    </tbody>
  </table>';
  
	  $subject = '['.$general['website_title'].'] '.$order_number.' Delivery Order';
	  $headers = "Content-Type: text/html; charset=ISO-8859-1\r\n".
	  $headers .= "From: ".$general['website_title']." <" .$info['email']. ">\r\n"; //optional headerfields
		 
	  mail($recipient, $subject, $mail_body, $headers);
	  
	  
header("Location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/../order-detailing/".$_REQUEST['ornum']);
?>