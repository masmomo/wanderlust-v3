<?php
include("get.php");
include("update.php");
/*
|--------------------|
|      SORTING       |
|--------------------|
*/

$equal_search    = array('user_status', 'user_created_date', 'last_order');
$default_sort_by = "user_created_date DESC";

$pgdata = page_init($equal_search,$default_sort_by); // static/general.php

$page             = $pgdata['page'];
$query_per_page   = $pgdata['query_per_page'];
$sort_by          = $pgdata['sort_by'];
$first_record     = $pgdata['first_record'];
$search_parameter = $pgdata['search_parameter'];
$search_value     = $pgdata['search_value'];
$search_query     = $pgdata['search_query'];
$search           = $pgdata['search'];


$full_user   = getFullCustomer($search_query, $sort_by, $first_record ,$query_per_page);
$total_query = $full_user['total_query'];
$total_page  = $full_user['total_page']; // RESULT

// CALL FUNCTION
$customers   = getCustomers($search_query, $sort_by, $first_record, $query_per_page);


// HANDLING ARROW SORTING

if($_REQUEST['srt'] == "user_fullname DESC"){
   $arr_user_fullname = "<span class=\"sort-arrow-up\"></span>";
}else if($_REQUEST['srt'] == "user_fullname"){
   $arr_user_fullname = "<span class=\"sort-arrow-down\"></span>";
			   
}else if($_REQUEST['srt'] == "user_status DESC"){
   $arr_user_status = "<span class=\"sort-arrow-up\"></span>";
}else if($_REQUEST['srt'] == "user_status"){
   $arr_user_status = "<span class=\"sort-arrow-down\"></span>";
									  
}else if($_REQUEST['srt'] == "user_country DESC"){
   $arr_user_country = "<span class=\"sort-arrow-up\"></span>";
}else if($_REQUEST['srt'] == "user_country"){
   $arr_user_country = "<span class=\"sort-arrow-down\"></span>";
									  
}else if($_REQUEST['srt'] == "total_spent DESC"){
   $arr_total_spent = "<span class=\"sort-arrow-up\"></span>";
}else if($_REQUEST['srt'] == "total_spent"){
   $arr_total_spent = "<span class=\"sort-arrow-down\"></span>";
									  
}else if($_REQUEST['srt'] == "total_order DESC"){
   $arr_total_order = "<span class=\"sort-arrow-up\"></span>";
}else if($_REQUEST['srt'] == "total_order"){
   $arr_total_order = "<span class=\"sort-arrow-down\"></span>";
									  
}else if($_REQUEST['srt'] == "last_order DESC"){
   $arr_last_order = "<span class=\"sort-arrow-up\"></span>";
}else if($_REQUEST['srt'] == "last_order"){
   $arr_last_order = "<span class=\"sort-arrow-down\"></span>";								  
}


// STORED VALUE
echo "<input type=\"hidden\" name=\"url\" id=\"url\" class=\"hidden\" value=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/customer-view\">\n";
echo "<input type=\"hidden\" name=\"url\" id=\"alternate-url\" class=\"hidden\" value=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/customer\">\n"; // Reset option
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


// DEFINED VARIABLE
$array_user_id = $_POST['user_id'];

if(isset($_POST['btn-index-customer'])){
   
   if($_POST['btn-index-customer'] == "GO"){
      
	  if(!empty($array_user_id)){
	  
	     foreach($array_user_id as $user_id){
			
			// DELETE VALIDATION
			$delete_validation = checkUserOrder($user_id);
			
			if($delete_validation['rows'] > 0){
			   $_SESSION['alert'] = "error";
			   $_SESSION['msg']   = "Can't delete because the customer has placed one or more order(s).";
			   $_SESSION['page']  = $act;
			}else{
               deleteCustomers($user_id);
			
			   $_SESSION['alert'] = "success";
			   $_SESSION['msg']   = "Successfully deleted customer(s).";
			   $_SESSION['page']  = $act;
			}
	     }
		 
	  }
	  
   }
   
}


?>