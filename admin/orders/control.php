<?php

/* --- CONTROL --- */

/*
# ----------------------------------------------------------------------
# SORTING
# ----------------------------------------------------------------------
*/

$equal_search     = array('order_payment_method', 'payment_status', 'fulfillment_status', 'order_date');
$default_sort_by  = "order_id DESC";

$pgdata = page_init($equal_search,$default_sort_by); // static/general.php

$page             = $pgdata['page'];
$query_per_page   = $pgdata['query_per_page'];
$sort_by          = $pgdata['sort_by'];
$first_record     = $pgdata['first_record'];
$search_parameter = $pgdata['search_parameter'];
$search_value     = $pgdata['search_value'];
$search_query     = $pgdata['search_query'];
$search           = $pgdata['search'];


$full_order  = fullOrderIndex($search_query, $sort_by, $first_record ,$query_per_page);
$total_query = $full_order['total_query'];
$total_page  = $full_order['total_page']; // RESULT


/* --- CALL FUNCTION --- */
$listing_order = orderIndex($search_query, $sort_by, $first_record, $query_per_page);



/* --- HANDLING ARROW SORTING --- */

if($_REQUEST['srt'] == "order_number DESC"){
   $arr_order_number = "<span class=\"sort-arrow-up\"></span>";
}else if($_REQUEST['srt'] == "order_number"){
   $arr_order_number = "<span class=\"sort-arrow-down\"></span>";
			   
}else if($_REQUEST['srt'] == "order_date DESC"){
   $arr_order_date = "<span class=\"sort-arrow-up\"></span>";
}else if($_REQUEST['srt'] == "order_date"){
   $arr_order_date = "<span class=\"sort-arrow-down\"></span>";
									  
}else if($_REQUEST['srt'] == "order_confirm_name DESC"){
   $arr_confirm_name = "<span class=\"sort-arrow-up\"></span>";
}else if($_REQUEST['srt'] == "order_confirm_name"){
   $arr_confirm_name = "<span class=\"sort-arrow-down\"></span>";
									  
}else if($_REQUEST['srt'] == "order_confirm_bank DESC"){
   $arr_confirm_bank = "<span class=\"sort-arrow-up\"></span>";
}else if($_REQUEST['srt'] == "order_confirm_bank"){
   $arr_confirm_bank = "<span class=\"sort-arrow-down\"></span>";
									  
}else if($_REQUEST['srt'] == "order_confirm_amount DESC"){
   $arr_confirm_amount = "<span class=\"sort-arrow-up\"></span>";
}else if($_REQUEST['srt'] == "order_confirm_name"){
   $arr_confirm_amount = "<span class=\"sort-arrow-down\"></span>";
									  
}else if($_REQUEST['srt'] == "payment_status DESC"){
   $arr_payment_status = "<span class=\"sort-arrow-up\"></span>";
}else if($_REQUEST['srt'] == "payment_status"){
   $arr_payment_status = "<span class=\"sort-arrow-down\"></span>";
									  
}else if($_REQUEST['srt'] == "fulfillment_status DESC"){
   $arr_fulfillment_status = "<span class=\"sort-arrow-up\"></span>";
}else if($_REQUEST['srt'] == "fulfillment_status"){
   $arr_fulfillment_status = "<span class=\"sort-arrow-down\"></span>";
}



/* --- STORED VALUE --- */
echo "<input type=\"hidden\" name=\"url\" id=\"url\" class=\"hidden\" value=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/order-view\">\n";
echo "<input type=\"hidden\" name=\"url\" id=\"alternate-url\" class=\"hidden\" value=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/order\">\n"; // Reset option
echo "<input type=\"hidden\" name=\"page\" id=\"page\" class=\"hidden\" value=\"".$page."\" /> \n";
echo "<input type=\"hidden\" name=\"query_per_page\" id=\"query_per_page\" class=\"hidden\" value=\"".$query_per_page."\" /> \n";
echo "<input type=\"hidden\" name=\"total_page\" id=\"total_page\" class=\"hidden\" value=\"".$total_page."\" /> \n";
echo "<input type=\"hidden\" name=\"sort_by\" id=\"sort_by\" class=\"hidden\" value=\"".$sort_by."\" /> \n";
echo "<input type=\"hidden\" name=\"search\" id=\"search\" class=\"hidden\" value=\"".$search_parameter."-".$search_value."\" /> \n";


function edit_mode(){

   echo '<div class="info-header">';
   echo '   <div class="content">';
   
   if($_POST['btn-order-detail'] == "Cancel"){   
      echo "   Edit Order Mode <br />";
   }else if($_POST['btn-order-detail'] == "Save Changes"){   
      echo "Data has successfully updated <br />";  
   }else if($_POST['btn-order-detail'] == "Mark as Paid"){
      echo "   An email has been sent to demo@antikode.com <br />";
   }else{   
      echo "   Edit Order Mode <br />"; 
   }
   
   echo '   </div>';
   echo '</div>';
	  
}



/* --- Handling css for payment_status --- */
function payment_status_flag($flag_payment_status){
   
   if($flag_payment_status == "Paid"){
      $payment_status = "stat green";
   }else if($flag_payment_status == "Confirmed"){
      $payment_status = "stat yellow";
   }else if($flag_payment_status == "Unpaid"){
	  $payment_status = "stat red";
   }
   
   return $payment_status;
   
}


/* --- Handling css for fulfillment_status --- */
function fulfillment_status_flag($flag_fulfillment_status){

   if($flag_fulfillment_status == "Unfulfilled"){
      $fulfillment_status = "stat grey";
   }else if($flag_fulfillment_status == "In Process" || $flag_fulfillment_status == "Partial"){
      $fulfillment_status = "stat yellow";
   }else if($flag_fulfillment_status == "Delivered"){
      $fulfillment_status = "stat green";
   }else if ($flag_fulfillment_status == "Cancelled" || $flag_fulfillment_status == "Expired"){
      $fulfillment_status = "stat red";
   }
   
   return $fulfillment_status;
   
}


/* --- Capitalizing Bank Name --- */
function capitaling_bank_name($flag_bank_name){
   
   if (strlen($flag_bank_name) > 4){
      $order_confirm_bank = ucwords(strtolower($flag_bank_name));
   }else{
      $order_confirm_bank = strtoupper($flag_bank_name);
   }
   
   return $order_confirm_bank;
   
}



/* --- BUTTON HANDLER --- */

if($_POST['index-order'] == "GO" ){
	
   $order_id    = $_POST['checkbox'];      // Get order_id
   $post_action = $_POST['option-action']; // Action : Change or Delete
   
   if($post_action == "delete"){
      
	  foreach($order_id as $order_id){
		 
		 /* --- CALL FUNCTION --- */
		 $get_item = order_get_size_type($order_id);
		 
		 foreach($get_item as $get_item){
			/* --- RECOVER STOCK QUANTITY --- */
			order_update_stock($get_item['item_quantity'], $get_item['stock_id']);
		 }
		 
		 $sql    = "DELETE FROM `tbl_order` WHERE `order_id` = '$order_id'";
		 $query  = mysql_query($sql, $conn);
		 
		 delete_user_purchase($order_id);
		 delete_order_item($order_id);
		 
	  }
   
   }else{
	   
	  $post_status = $_POST['option-status']; // Option : Unpaid, Paid, Unfulfilled, In Process, Delivered, Cancelled, Expired
	  
	  if($post_status == "Unpaid"){
		 
		 foreach($order_id as $order_id){
			$sql     = "UPDATE `tbl_order` SET `payment_status` = '$post_status' WHERE `order_id` = '$order_id'";
			$query   = mysql_query($sql, $conn);
		 }
      
      }else if($post_status == "Confirmed"){
	     
		 foreach($order_id as $order_id){
		    $sql     = "UPDATE `tbl_order` SET `payment_status` = '$post_status' WHERE `order_id` = '$order_id'";
			$query   = mysql_query($sql, $conn);
		 }
	  
	  }else if($post_status == "Paid"){
		 
		 foreach($order_id as $order_id){
		    $sql     = "UPDATE `tbl_order` SET `payment_status` = '$post_status', `fulfillment_status`  = 'In Process' WHERE `order_id` = '$order_id'";
		    $query   = mysql_query($sql, $conn);
		 }
	        
      }else if ($post_status == "Expired" || $post_status == "Cancelled"){
		 
		 foreach($order_id as $order_id){
			 
		    $check_order = get_order_information($order_id);
			
			if($check_order['payment_status'] == 'Paid'){
			   $sql     = "UPDATE `tbl_order` SET `payment_status` = 'Refunded' WHERE `order_id` = '$order_id'";
			   $query   = mysql_query($sql, $conn);
			}
			
			if($check_order['fulfillment_status'] != 'Unfulfilled'){
			   $sql     = "UPDATE `tbl_order` SET `fulfillment_status` = 'Refunded' WHERE `order_id` = '$order_id'";
			   $query   = mysql_query($sql, $conn);
			}
			
		    $sql     = "UPDATE `tbl_order` SET `order_status` = '$post_status' WHERE `order_id` = '$order_id'";
			$query   = mysql_query($sql, $conn);
		 }
			
      }else if ($post_status == "In Process" || $post_status == "Delivered"){
		 
		 foreach($order_id as $order_id){
		    //$sql     = "UPDATE `tbl_order` SET `payment_status` = 'Paid', `fulfillment_status` = '$post_status' WHERE `order_id` = '$order_id'";
		    $sql     = "UPDATE `tbl_order` SET `fulfillment_status` = '$post_status' WHERE `order_id` = '$order_id'";
			$query   = mysql_query($sql, $conn);
		 }
			
      }
	  
   }

}




/* -- BUTTON RESET -- */
if(empty($search_parameter)){
   $reset = "hidden";
}else{
   $reset = "";
}


/*
# ----------------------------------------------------------------------
# FUNCTION
# ----------------------------------------------------------------------
*/


/* --- VIEW PAGE --- */
function view_page($total_page, $page){
   
   for($i=1;$i<=$total_page;$i++){
      echo "<option value=\"".$i."\"";
	  if($i == $total_page){
	     echo 'selected="selected"';
	  }
	  echo ">".$i."</option> \n";
   }

}

function view_per_page($qpp){
   
   echo '<option value="25"';
   if($qpp =="25"){ 
      echo "selected=\"selected\"";
   }
   echo '>25</option>';
   
   echo '<option value="50"';
   if($qpp =="50"){ 
      echo "selected=\"selected\"";
   }
   echo '>50</option>';
   
   
   echo '<option value="100"';
   if($qpp =="100"){ 
      echo "selected=\"selected\"";
   }
   echo '>100</option>';
   
}
?>