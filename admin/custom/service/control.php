<?php
/*
|--------------------|
|      SORTING       |
|--------------------|
*/

$equal_search    = array('visibility');
$default_sort_by = "category_name";

$pgdata = page_init($equal_search,$default_sort_by); // static/general.php

$page             = $pgdata['page'];
$query_per_page   = $pgdata['query_per_page'];
$sort_by          = $pgdata['sort_by'];
$first_record     = $pgdata['first_record'];
$search_parameter = $pgdata['search_parameter'];
$search_value     = $pgdata['search_value'];
$search_query     = $pgdata['search_query'];
$search           = $pgdata['search'];


$full_order  = count_city($search_query, $sort_by, $query_per_page);
$total_query = $full_order['total_query'];
$total_page  = ceil($full_order['total_query'] / $query_per_page);

// CALL FUNCTION
$listing_order = get_city($search_query, $sort_by, $first_record, $query_per_page);


// HANDLING ARROW SORTING
if($_REQUEST['srt'] == "category_name DESC"){
   $arr_order_number = "<span class=\"sort-arrow-up\"></span>";
}else if($_REQUEST['srt'] == "category_name"){
   $arr_order_number = "<span class=\"sort-arrow-down\"></span>";
}else{
   $arr_order_number = "<span class=\"sort-arrow-down\"></span>";
}


// STORED VALUE
echo "<input type=\"hidden\" name=\"url\" id=\"url\" class=\"hidden\" value=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/service-city-view\">\n";
echo "<input type=\"hidden\" name=\"page\" id=\"page\" class=\"hidden\" value=\"".$page."\" /> \n";
echo "<input type=\"hidden\" name=\"query_per_page\" id=\"query_per_page\" class=\"hidden\" value=\"".$query_per_page."\" /> \n";
echo "<input type=\"hidden\" name=\"total_page\" id=\"total_page\" class=\"hidden\" value=\"".ceil($full_order['total_query'] / $query_per_page)."\" /> \n";
echo "<input type=\"hidden\" name=\"sort_by\" id=\"sort_by\" class=\"hidden\" value=\"".$sort_by."\" /> \n";
echo "<input type=\"hidden\" name=\"search\" id=\"search\" class=\"hidden\" value=\"".$search_parameter."-".$search_value."\" /> \n";

/* -- BUTTON RESET -- */
if(empty($search_parameter)){
   $reset = "hidden";
}else{
   $reset = "";
}



if(isset($_POST['btn_index_service_city'])){
   
   // DEFINED VARIABLE
   
   $id     = $_POST['category_id'];
   $action = $_POST['option-action'];
   $option = $_POST['option-option'];
   
   if($action == 'delete'){
      
	  foreach($id as $id){
	     $check = count_job($id);
		 
		 if($check['rows'] > 0){
				
		    $_SESSION['alert'] = 'error';
			$_SESSION['msg']   = "Can't delete item(s) because it contains one or more item(s)";
		 
		 }else{
			   
		    delete($id);
			
			$_SESSION['alert'] = 'success';
			$_SESSION['msg']   = "Item(s) has been successfully removed";
		 
		 }
		 
	  }
	  
   }else if($action == 'visibility'){
      
	  foreach($id as $id){
	     
		 if($option == 'yes'){
		    update_visibility(1, $id);
		 }else if($option == 'no'){
		    update_visibility(0, $id);
		 }
		 
	  }
	  
	  $_SESSION['alert'] = 'success';
	  $_SESSION['msg']   = "Changes has been saved";
	  
   }
   
}
?>