<?php
/*
|--------------------|
|      SORTING       |
|--------------------|
*/

$equal_search    = array('active_status', 'service');
$default_sort_by = "courier_name";

$pgdata = page_init($equal_search,$default_sort_by); // static/general.php

$page             = $pgdata['page'];
$query_per_page   = $pgdata['query_per_page'];
$sort_by          = $pgdata['sort_by'];
$first_record     = $pgdata['first_record'];
$search_parameter = $pgdata['search_parameter'];
$search_value     = $pgdata['search_value'];
$search_query     = $pgdata['search_query'];
$search           = $pgdata['search'];


$full_order  = get_full_courier($search_query, $sort_by, $first_record ,$query_per_page);
$total_query = $full_order['total_query'];
$total_page  = $full_order['total_page']; // RESULT

// CALL FUNCTION
$listing_order = get_courier($search_query, $sort_by, $first_record, $query_per_page);

// HANDLING ARROW SORTING

if($_REQUEST['srt'] == "courier_name DESC"){
   $arr_courier_name = "<span class=\"sort-arrow-up\"></span>";
}else if($_REQUEST['srt'] == "courier_name"){
   $arr_courier_name = "<span class=\"sort-arrow-down\"></span>";
			   
}else if($_REQUEST['srt'] == "courier_description DESC"){
   $arr_courier_description = "<span class=\"sort-arrow-up\"></span>";
}else if($_REQUEST['srt'] == "courier_description"){
   $arr_courier_description = "<span class=\"sort-arrow-down\"></span>";
									  
}else if($_REQUEST['srt'] == "service DESC"){
   $arr_service = "<span class=\"sort-arrow-up\"></span>";
}else if($_REQUEST['srt'] == "service"){
   $arr_service = "<span class=\"sort-arrow-down\"></span>";
									  
}else if($_REQUEST['srt'] == "active_status DESC"){
   $arr_active_status = "<span class=\"sort-arrow-up\"></span>";
}else if($_REQUEST['srt'] == "active_status"){
   $arr_active_status = "<span class=\"sort-arrow-down\"></span>";					  
}


// STORED VALUE
echo "<input type=\"hidden\" name=\"url\" id=\"url\" class=\"hidden\" value=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/shipping-view\">\n";
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

$courier_id = $_POST['courier_id'];

/* -- DATABASE ACTION -- */
if(isset($_POST['btn-index-shipping']) and !empty($courier_id)){
   
   if($_POST['btn-index-shipping'] == "GO"){
      
	  if($_POST['ship-action'] == "delete"){
	  
	     if(in_array('1', $courier_id)){
			$_SESSION['alert'] = "error";
		    $_SESSION['msg']   = "Mandatory courier";
	     }else{
	  
	     foreach($courier_id as $courier_id){
			deleteCourier($courier_id);
			deleteCourierRste($courier_id);
	     }
		 
		 
		 $_SESSION['alert'] = "success";
		 $_SESSION['msg']   = "<center>Item(s) has been successfully deleted.</center>";
		 }
	  }
	  
   }
   
}
?>