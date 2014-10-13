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


function get_item($post_order_number){
   $conn  = connDB();
   
   $sql    = "SELECT * FROM tbl_order WHERE `order_number` = '$post_order_number'";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
	  array_push($row, $result);
   }
   
   return $row;
}


$order_number = clean_alphanumeric($_REQUEST['order_number']);



// CALL FUNCTION
$cart   = get_cart($_REQUEST['ornum']);
$item   = get_item($_REQUEST['ornum']);
$person = get_person($_REQUEST['ornum']);

// DEFINED VARIABLE
$amount = $_REQUEST['amount'];


// MAIL CONFIRMED FOR ADMIN
   $name      = $general['website_title']; 
   $email     = $info['email']; 
   $recipient = $info['email']; 
   $mail_body = '<body style="font-family: Helvetica, Arial, sans-serif; color:#fff" topmargin="0" leftmargin="0">
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
                    <span style="font-weight: 100">Order no.</span> <i style="font-size: 14px; color: #333">'.$_REQUEST['ornum'].'</i>
                  </td>
                  <td style="font-size: 12px; color: #fff; padding: 10px 15px; text-align: right">
                    <span style="line-height: 18px; color: #999"><b style="color: #333">CONFIRMATION RECEIVED</b> </span>
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
          <a style="color: #0383ae" href="'.$prefix_url."admin/customer/".$person['user_alias'].'">'.$person['user_fullname'].'</a> has confirmed the payment for order <a style="color: #0383ae" href="'.$prefix_url."admin/order-detailing/".$order_number.'">'.$order_number.'</a> on '.date('D, j M Y').' at '.date('G:i A').' with the following details:<br>
          <br>
          <b>Paid to:</b> BCA 123456789 - '.$general['website_title'].'<br>
          <b>Amount:</b> IDR '.price($amount).'<br>
          <br>
          Once the payment has been verified, go to your admin panel and mark the order as paid.
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
  
	  $subject = '['.$general['website_title'].'] '.$order_number.' Confirmation Received';
	  $headers = "Content-Type: text/html; charset=ISO-8859-1\r\n".
	  $headers .= "From: ".$general['website_title']." <" .$info['email']. ">\r\n"; //optional headerfields
		 
	  mail($recipient, $subject, $mail_body, $headers);
	  
	  
header("Location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."../../../confirm");
?>