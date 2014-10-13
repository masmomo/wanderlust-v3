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
	     
		 update_confirm($confirm_bank, $confirm_name, $confirm_amount, $data_confirm['order_id'], 'Confirmed');
		 
		 $_SESSION['alert'] = 'success';
		 $_SESSION['msg']   = 'Successfully confirm order';
		 
	  }else{
	     
		 $_SESSION['alert'] = 'error';
		 $_SESSION['msg']   = 'Order has been confirmed';
		 
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

          <div class="col-xs-12 col-sm-8">
            
            <form role="form" method="post" class="form-horizontal">
              <h1 class="h6">CONFIRM PAYMENT</h1>
              <p class="m_b_10">Input your order number and your payment details to confirm order.</p>
              
              
              
            
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
              
              <div class="form-group" id="lbl_order_number">
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