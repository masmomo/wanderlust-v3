<?php
$clean       = ucwords(strtolower($_REQUEST['cid']));
$user_name   = ucwords(strtolower(preg_replace("/[\/_|+ -]+/", ' ', $clean)));
$user        = strtolower($user_name);

include("get.php");
include("update.php");

$get_user_id = detail_get_user_id($_REQUEST['cid']);
$user_detail = get_detail_customer($get_user_id['user_id']);

/*
|--------------------|
|      SORTING       |
|--------------------|
*/

$equal_search    = array('order_payment_method', 'payment_status', 'fulfillment_status', 'order_date');
$default_sort_by = "order_id";

$pgdata = page_init($equal_search,$default_sort_by); // static/general.php

$page             = $pgdata['page'];
$query_per_page   = $pgdata['query_per_page'];
$sort_by          = $pgdata['sort_by'];
$first_record     = $pgdata['first_record'];
$search_parameter = $pgdata['search_parameter'];
$search_value     = $pgdata['search_value'];
$search_query     = $pgdata['search_query'];
$search           = $pgdata['search'];


$full_order  = fullOrderUser($user, $search_query, $sort_by, $first_record ,$query_per_page);
$total_query = $full_order['total_query'];
$total_page  = $full_order['total_page']; // RESULT

// CALL FUNCTION
$listing_order = orderUser($user, $search_query, $sort_by, $first_record, $query_per_page);
$getCountry    = getCountry();
$getProvince   = getProvince();
$getCity       = get_city($user_detail['user_province']);


// HANDLING ARROW SORTING

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


// STORED VALUE
echo "<input type=\"hidden\" name=\"url\" id=\"url\" class=\"hidden\" value=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/customer-details/".cleanurl($user)."\">\n";
echo "<input type=\"hidden\" name=\"url\" id=\"alternate-url\" class=\"hidden\" value=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/customer/".$_REQUEST['cid']."\">\n"; // Reset option
echo "<input type=\"hidden\" name=\"page\" id=\"page\" class=\"hidden\" value=\"".$page."\" /> \n";
echo "<input type=\"hidden\" name=\"query_per_page\" id=\"query_per_page\" class=\"hidden\" value=\"".$query_per_page."\" /> \n";
echo "<input type=\"hidden\" name=\"total_page\" id=\"total_page\" class=\"hidden\" value=\"".$total_page."\" /> \n";
echo "<input type=\"hidden\" name=\"sort_by\" id=\"sort_by\" class=\"hidden\" value=\"".$sort_by."\" /> \n";
echo "<input type=\"hidden\" name=\"search\" id=\"search\" class=\"hidden\" value=\"".$search_parameter."-".$search_value."\" /> \n";


/* -- BUTTON RESET -- */
if(empty($search_parameter)){
   $reset = "hidden";
}else{
   $reset = "";
}


// DELETE USER
if(isset($_POST['btn-detail-customer'])){
   
   if($_POST['btn-detail-customer'] == "Delete"){ 
   
      $delete_validation = checkUserOrder($_POST['user_id']);
	  
	  if($delete_validation['rows'] > 0){
		 $_SESSION['alert'] = "error";
	     $_SESSION['msg']   = "Can't delete because ".$user_detail['user_fullname']." has placed one or more order(s).";
		 $_SESSION['page']  = $act;
	  }else{
         delete_user($_POST['user_id']);
	  
	     $_SESSION['alert'] = "success";
	     $_SESSION['msg']   = "Successfully deleted customer(s).";
		 $_SESSION['page']  = $act;
	  }
	  
   }else if($_POST['btn-detail-customer'] == "GO"){
      $order_id    = $_POST['order_id'];      // Get order_id
      $post_action = $_POST['option-action']; // Action : Change or Delete
	  
	  if($post_action == "delete"){
	     
		 foreach($order_id as $order_id){
		    $sql    = "DELETE FROM `tbl_order` WHERE `order_id` = '$order_id'";
		    $query  = mysql_query($sql, $conn);
	     }
   
      }else{
	     $post_status = $_POST['option-status']; // Option : Unpaid, Paid, Unfulfilled, In Process, Delivered, Cancelled, Expired
	  
	     if($post_status == "Unpaid"){
		 
		    foreach($order_id as $order_id){
			   $sql     = "UPDATE `tbl_order` SET `payment_status` = '$post_status', `fulfillment_status` = 'Unfulfilled' WHERE `order_id` = '$order_id'";
			   $query   = mysql_query($sql, $conn);
		    }
      
         }else if($post_status == "Paid"){
		 
		    foreach($order_id as $order_id){
		       $sql     = "UPDATE `tbl_order` SET `payment_status` = '$post_status', `fulfillment_status`  = 'In Process' WHERE `order_id` = '$order_id'";
		       $query   = mysql_query($sql, $conn);
		    }
	        
         }else if ($post_status == "Unfulfilled" || $post_status == "Expired" || $post_status == "Cancelled"){
		 
		    foreach($order_id as $order_id){
		       $sql     = "UPDATE `tbl_order` SET `fulfillment_status` = '$post_status' WHERE `order_id` = '$order_id'";
			   $query   = mysql_query($sql, $conn);
		    }
			
         }else if ($post_status == "In Process" || $post_status == "Delivered"){
		 
		    foreach($order_id as $order_id){
		       $sql     = "UPDATE `tbl_order` SET `payment_status` = 'Paid', `fulfillment_status` = '$post_status' WHERE `order_id` = '$order_id'";
			   $query   = mysql_query($sql, $conn);
		    }
			
         }
	  
      }
	  
	  $_SESSION['alert'] = "Filled";
	  
   }else if($_POST['btn-detail-customer'] == "Send Email"){
      //send mail
	  $_POST['message'] = removeHtmlTags($_POST['message']);
	  
	  $name = $_POST['name']; 
	  $email = $_POST['email']; 
	  $recipient = $user_detail['user_email']; 
	  $mail_body = preg_replace("/\n/","\n<br>",$_POST['message']);
	  $subject = "[Bionic] Contact Form";/*"[".$_POST['purpose']."] ".$_POST['subject'];*/ 
	  $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n".
	  $headers .= "From: ". $name . " <" . $email . ">\r\n"; //optional headerfields
	  
	  mail($recipient, $subject, $mail_body, $headers);
	  $_POST['msg'] = "Your message has been submited, we will review your message and reply you as soon as possible";
   }
   
   
   
}else if(isset($_POST['btn-edit-customer'])){
	
   // Initialization
   $first_name  = clean_alphabet($_POST['user_first_name']);
   $last_name   = clean_alphabet($_POST['user_last_name']);
   $name        = clean_alphabet($_POST['user_first_name']." ".$_POST['user_last_name']);
   $user_email  = $_POST['user_email'];
   $user_phone  = clean_number($_POST['user_phone']);
   $status      = $_POST['user_status_backup'];
   $address     = $_POST['user_address'];
   $city        = $_POST['user_city'];
   $province    = $_POST['user_province'];
   $country     = $_POST['user_country'];
   $postal_code = clean_number($_POST['user_postal_code']);
   $uid         = $_POST['user_id'];
   
   //$get_name
	
   if($_POST['btn-edit-customer'] == "Save Changes" || $_POST['btn-edit-customer'] == "Save Changes & Exit"){
	   
	  $check_alias    = checkAlias(cleanurl($name));
	  $check_aliasing = checkAliasing(cleanurl($user_name));
	  $count_check    = countUser($name);
	  $get_user       = edit_get_user($uid);
	  $edit_alias     = countUser($first_name." ".$last_name);
	  $check_email    = edit_get_email($user_email, $uid);
	  
	  
	  if($check_email['rows'] > 0){
	     $_SESSION['alert'] = "error";
		 $_SESSION['msg']   = $user_email." has been taken, please input email with other valid email address";
		 $_SESSION['page']  = $act;
	  
	  }else{
	  
	     if($check_alias['rows'] > 0){
	     
		    if($_POST['user_id'] == $check_aliasing['user_id']){
			
			   if(strtolower($get_user['user_first_name']) == strtolower($first_name) and strtolower($get_user['user_last_name']) == strtolower($last_name)){
	              $post_alias = $check_aliasing['user_alias'];
			   }else{
			   
			      if($edit_alias['rows'] > 0){
			         $post_alias = cleanurl($first_name." ".$last_name.$edit_alias['rows']);
			      }else{
			         $post_alias = cleanurl($first_name." ".$last_name);
			      }
			   
			   }
			
	        }else{
	           $post_alias = cleanurl($name.$count_check['rows']);
		    }
		 
	     }else{
	        $post_alias = cleanurl($name);
	     }
	  
         edit_customer($first_name, $last_name, $name, $status, $user_email, $user_phone, $address, $city, $province, $country, $postal_code, $post_alias, $uid);
	  
	     $_SESSION['alert'] = "success";
	     $_SESSION['msg']   = "Changes successfully saved.";
	  
	  }
	  
   }
   
}
?>