<?php
/*
|--------------------|
|      SORTING       |
|--------------------|
*/

$equal_search    = array('visibility');
$default_sort_by = "career_name";

$pgdata = page_init($equal_search,$default_sort_by); // static/general.php

$page             = $pgdata['page'];
$query_per_page   = $pgdata['query_per_page'];
$sort_by          = $pgdata['sort_by'];
$first_record     = $pgdata['first_record'];
$search_parameter = $pgdata['search_parameter'];
$search_value     = $pgdata['search_value'];
$search_query     = $pgdata['search_query'];
$search           = $pgdata['search'];

if(empty($_REQUEST['cat']) || $_REQUEST['cat'] == 'all'){
   $cat = '';
}else{
   $cat = "AND category_name = '".$_REQUEST['cat']."' ";
}


$full_order       = count_job($search_query, $sort_by, $query_per_page, $cat);
$total_query      = $full_order['total_query'];
$total_page       = ceil($full_order['total_query'] / $query_per_page);

// CALL FUNCTION
$listing_order    = get_job($search_query, $sort_by, $first_record, $query_per_page, $cat);

// OPTION CATEGORY
$category         = get_category();


// HANDLING ARROW SORTING
if($_REQUEST['srt'] == "category_name DESC"){
   $arr_order_number = "<span class=\"sort-arrow-up\"></span>";
}else if($_REQUEST['srt'] == "category_name"){
   $arr_order_number = "<span class=\"sort-arrow-down\"></span>";
}else{
   $arr_order_number = "<span class=\"sort-arrow-down\"></span>";
}


// STORED VALUE
echo "<input type=\"hidden\" name=\"url\" id=\"url\" class=\"hidden\" value=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/service-view\">\n";
echo "<input type=\"hidden\" name=\"page\" id=\"page\" class=\"hidden\" value=\"".$page."\" /> \n";
echo "<input type=\"hidden\" name=\"query_per_page\" id=\"query_per_page\" class=\"hidden\" value=\"".$query_per_page."\" /> \n";
echo "<input type=\"hidden\" name=\"current_category\" id=\"current_category\" class=\"hidden\" value=\"";
if($cat == 'all' || empty($_REQUEST['cat'])){ 
   echo 'all';
}else{
   echo $_REQUEST['cat'];
}
echo "\" /> \n";
echo "<input type=\"hidden\" name=\"total_page\" id=\"total_page\" class=\"hidden\" value=\"".ceil($full_order['total_query'] / $query_per_page)."\" /> \n";
echo "<input type=\"hidden\" name=\"sort_by\" id=\"sort_by\" class=\"hidden\" value=\"".$sort_by."\" /> \n";
echo "<input type=\"hidden\" name=\"search\" id=\"search\" class=\"hidden\" value=\"".$search_parameter."-".$search_value."\" /> \n";


/* -- BUTTON RESET -- */
if(empty($search_parameter)){
   $reset = "hidden";
}else{
   $reset = "";
}



if(isset($_POST['btn_index_service_job'])){
   
   // DEFINED VARIABLE
   $career_id = $_POST['category_id'];
   $action    = $_POST['option-action'];
   $option    = $_POST['option-option'];
   
   if($action == 'delete'){
   
      foreach($career_id as $career_id){
         delete($career_id);
	  }
	  
	  $_SESSION['alert'] = 'success';
	  $_SESSION['msg']   = 'Item(s) has been successfully deleted';
	  
   }else{
      
	  foreach($career_id as $career_id){
	     
		 if($option == 'yes'){
		    update_visibility(1, $career_id);
		 }else if($option == 'no'){
		    update_visibility(0, $career_id);
		 }
		 
	  }
	  
	  $_SESSION['alert'] = 'success';
	  $_SESSION['msg']   = "Changes has been saved";
   
   }
   
}
?>