<?php
/*
# ----------------------------------------------------------------------
# FUNCTIONS
# ----------------------------------------------------------------------
*/

function count_confirm($order_number){
   $conn   = connDB();
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_order WHERE `order_number` = '$order_number' AND `order_status` = 'Open'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function get_confirm($order_number){
   $conn   = connDB();
   $sql    = "SELECT * FROM tbl_order WHERE `order_number` = '$order_number' AND `order_status` = 'Open'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function update_confirm($order_confirm_bank, $order_confirm_name, $order_confirm_amount, $order_id, $order_payment_status){
   $conn  = connDB();
   $sql   = "UPDATE tbl_order SET `order_confirm_bank` = '$order_confirm_bank',
                                  `order_confirm_name` = '$order_confirm_name',
								  `order_confirm_amount` = '$order_confirm_amount',
								  `payment_status` = '$order_payment_status'
             WHERE `order_id` = '$order_id'         
			";
   $query = mysql_query($sql, $conn) or die(mysql_error()); 
}


function get_banks(){
	$conn   = connDB();
	$sql    = "SELECT * FROM tbl_account";
	$query  = mysql_query($sql, $conn);
	$row    = array();
	
	while($result = mysql_fetch_array($query)){
	   array_push($row, $result);
	}
	
	return $row;
}

function get_bank($id){
   $conn   = connDB();
   $sql    = "SELECT * FROM tbl_account WHERE `id` = '$id'";
   $query  = mysql_query($sql, $conn); 
   $result = mysql_fetch_array($query);
   
   return $result;
}



/*
# ----------------------------------------------------------------------
# CALL FUNCTION
# ----------------------------------------------------------------------
*/

$bank_info = get_banks();



/*
# ----------------------------------------------------------------------
# CONTROL
# ----------------------------------------------------------------------
*/

if(isset($_POST['btn_confirm'])){
   
   /* --- DEFINED VARIABLE --- */
   $order_number   = clean_alphanumeric($_POST['order_number']);
   
   $temp_bank      = get_bank($_POST['confirmation_bank']);
   $confirm_bank   = $temp_bank['account_bank'];
   $confirm_name   = escape_quote($_POST['order_confirm_name']);
   $confirm_amount = clean_number($_POST['order_confirm_amount']);
   
   
   /* --- CALL FUNCTION --- */
   $count_order  = count_confirm($order_number);
   $data_confirm = get_confirm($order_number);
   
   if($count_order['rows'] > 0){
      
	  if($data_confirm['payment_status'] != 'Paid' and $data_confirm['payment_status'] != 'Confirmed'){
		 
		 $name      = $general['website_title']; 
		 $email     = $info['email'];
		 $recipient = $user_confirm['user_email']; 
		 $mail_body = '<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="overflow: hidden; background: #fff">
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
								       <span style="font-weight: 100">Order no.</span> <i style="font-size: 14px; color: #333; text-transform: uppercase">'.$order_number.'</i>
								     </td>
								     <td style="font-size: 12px; color: #fff; padding: 10px 15px; text-align: right">
								       <span style="line-height: 18px; color: #999"><b style="color: #f27d20">CONFIRMATION RECEIVED</b> </span>
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
						       Dear '.$user_confirm['user_fullname'].',<br>
						       <br>
						       We have received your payment confirmation for order number <b style="text-transform: uppercase">'.$order_number.'</b>. Please wait while we&#39;re verifying the payment. Once the payment has been verified, we will notify you and process your order. Thank you!
						       <br>
						     </td>
					       </tr>
					     </tbody>
				       </table>
				   
				       <table width="600" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:11px; color: #999; margin-top:15px">
				         <tbody>
					       <tr>
					         <td style="padding-left:20px; padding-right:20px; margin-bottom: 20px">
						       &copy; '.date('Y').' '.$general['website_title'].'. Powered by <a style="color: #666; text-decoration: none" href="http://www.antikode.com">Antikode</a>. <br><br>
						     </td>
					       </tr>
						 </tbody>
				       </table>';
      
	     $subject   = "[".$general['website_title']."] ".strtoupper($order_number)." Confirmation Received"; 
         $headers   = "Content-Type: text/html; charset=ISO-8859-1\r\n".
	     //$headers .= "From: ". $name . " <" . $general['email'] . ">\r\n"; //optional headerfields
		 $headers  .= "From: ".$general['website_title']." <" .$info['email']. ">\r\n"; //optional headerfields
      
	     mail($recipient, $subject, $mail_body, $headers);
	     
		 update_confirm($confirm_bank, $confirm_name, $confirm_amount, $data_confirm['order_id'], 'Confirmed');
		 
		 $_SESSION['alert'] = 'success';
		 $_SESSION['msg']   = 'Your order has been confirmed. Please wait while your payment is being verified.';
		 
	  }else{
	     
		 $_SESSION['alert'] = 'error';
		 $_SESSION['msg']   = 'Order has already been confirmed.';
		 
	  }
	  
   }else{
      /* --- FAILED --- */
      $_SESSION['alert'] = 'error';
	  $_SESSION['msg']   = 'There is no order with order number: '.$order_number;
   }
   
}
?>
    
    <div class="container main">

      <img src="<?php echo $prefix_url;?>files/common/img_line-dotted.png" width="100%" height="2">
      <div class="content">
        
        <div class="row">
          <!--<div class="col-xs-12 col-sm-4 m_b_10">
            <div class="contact-info">
              
            </div>
          </div>-->

          <div class="col-xs-4">
            <img src="<?php echo $prefix_url?>script/holder.js/100%x400">
          </div>

          <div class="col-xs-12 col-sm-8">
            
            <form role="form" method="post" class="form-horizontal">
              <h1 class="heading">CONFIRM PAYMENT</h1>
              <p>Input your order number and your payment details to confirm order.</p>
              
              
              
            
			<?php
			/*
			# ----------------------------------------------------------------------
			# ALERT
			# ----------------------------------------------------------------------
			*/
			if(!empty($_SESSION['alert'])){
			   echo '<div class="alert '.$_SESSION['alert'].'" style="margin-top: 15px">';
  			   echo '  <button type="button" class="close" data-dismiss="alert">&times;</button>';
  			   echo '  <p>'.$_SESSION['msg'].'</p>';
  			   echo '</div>';
  			}
  			
  			/* --- UNSET ALERT --- */
              if(empty($_POST['btn_confirm'])){
  			   unset($_SESSION['alert']);
  			   unset($_SESSION['msg']);
  			}
  			?>
              
              <div class="form-group" id="lbl_order_number" style="margin-top: 20px">
                <label class="col-md-3 control-label">Order #</label>
                <div class="col-md-9">
                  <input type="text" class="form-control" id="id_order_number" name="order_number" style="text-transform: uppercase;">
                </div>
              </div>
              <div class="form-group" id="lbl_order_confirm_bank">
                <label class="col-md-3 control-label">Bank Account</label>
                <div class="col-md-9">
                  <select class="form-control" id="id_order_confirm_bank" name="confirmation_bank">
                  <?php
                  foreach($bank_info as $bank_info){
			             echo '<option value="'.$bank_info['id'].'">Bank Transfer via '.$bank_info['account_bank'].'</option>';
          			  }
          			  ?>
                  </select>
                </div>
              </div>
              <div class="form-group" id="lbl_order_confirm_name">
                <label class="col-md-3 control-label">Bank Account Name</label>
                <div class="col-md-9">
                  <input type="text" class="form-control" id="id_order_confirm_name" name="order_confirm_name">
                </div>
              </div>
              <div class="form-group m_b_10" id="lbl_order_confirm_amount">
                <label class="col-md-3 control-label">Amount</label>
                <div class="col-md-9">
                  <input type="text" class="form-control" placeholder="IDR" id="id_order_confirm_amount" name="order_confirm_amount">
                </div>
              </div>
              <div class="clearfix">
                <button type="button" class="btn btn-primary btn-sm pull-right" onClick="validateConfirm()">Confirm Payment</button>
                <input type="submit" class="hidden" name="btn_confirm" id="id_btn_confirm" value="confirm">
              </div>
            </form>
          </div><!--.col-sm-8-->

        </div><!--.row-->

      </div><!--.content-->
    </div><!--.container.main-->
    
<script src="<?php echo $prefix_url.'script/confirm.js';?>"></script>