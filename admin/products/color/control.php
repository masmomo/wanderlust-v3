<?php

/*
|--------------------|
|      SORTING       |
|--------------------|
*/

$equal_search    = array('color_active_status', 'color_visibility_status');
$default_sort_by = "color_order";

$pgdata = page_init($equal_search,$default_sort_by); // static/general.php

$page             = $pgdata['page'];
$query_per_page   = $pgdata['query_per_page'];
$sort_by          = $pgdata['sort_by'];
$first_record     = $pgdata['first_record'];
$search_parameter = $pgdata['search_parameter'];
$search_value     = $pgdata['search_value'];
$search_query     = $pgdata['search_query'];
$search           = $pgdata['search'];


$full_order  = get_all_color_filter($search_query, $sort_by, $first_record ,$query_per_page);
$total_query = $full_order['total_query'];
$total_page  = ceil($full_order['total_query'] / $query_per_page);

// CALL FUNCTION
$listing_order = get_all_color($search_query, $sort_by, $first_record ,$query_per_page);


// HANDLING ARROW SORTING
if($_REQUEST['srt'] == "color_name DESC"){
   $arr_color_name = "<span class=\"sort-arrow-up\"></span>";
}else if($_REQUEST['srt'] == "color_name"){
   $arr_color_name = "<span class=\"sort-arrow-down\"></span>";

}else if($_REQUEST['srt'] == "total_product DESC"){
   $arr_total_product = "<span class=\"sort-arrow-up\"></span>";
}else if($_REQUEST['srt'] == "total_product"){
   $arr_total_product = "<span class=\"sort-arrow-down\"></span>";
}

else if($_REQUEST['srt'] == "color_active_status DESC"){
   $arr_color_active = "<span class=\"sort-arrow-up\"></span>";
}else if($_REQUEST['srt'] == "color_active_status"){
   $arr_color_active = "<span class=\"sort-arrow-down\"></span>";
}

else if($_REQUEST['srt'] == "color_visibility_status DESC"){
   $arr_color_visibility = "<span class=\"sort-arrow-up\"></span>";
}else if($_REQUEST['srt'] == "color_visibility_status"){
   $arr_color_visibility = "<span class=\"sort-arrow-down\"></span>";
}


// STORED VALUE
echo "<input type=\"hidden\" name=\"url\" id=\"url\" class=\"hidden\" value=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/color-view\">\n";
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


function sort_by(){
	$sort_by=$_REQUEST["srt"];

   if ($sort_by==""){
      $sort_by="color_order ASC";
   }
}



if($_POST['btn-index-color'] == "GO"){
      
   // DEFINED VARIABLE
   $color_id  = $_POST['color_id'];
   
   $hidden_id = $_POST['hidden_color_id'];
   $order     = $_POST['color_order'];
	
   if($_POST['category-action'] == 'delete'){
	  
	  foreach($color_id as $color_id){
	     
		 // CALL FUNCTION
		 $check = check_color($color_id);
		 
		 if($check['rows'] > 0){
		    $_SESSION['alert'] = 'error';
		    $_SESSION['msg']   = "Can't delete because it contains one or more items.";
		 }else{
			
			delete_color($color_id);
			
		    $_SESSION['alert'] = 'success';
		    $_SESSION['msg']   = "Item(s) has been successfully deleted.";
		 }
		 
	  }
	  
   }else if($_POST['category-action'] == 'change'){
      
	  foreach($color_id as $color_id){
	  
	     if($_POST['category-option'] == 'yes'){
	        update_visibility('yes', $color_id);
	     }else if($_POST['category-option'] == 'no'){
	        update_visibility('no', $color_id);
	     }
	  
	  }
	  
   }else if($_POST['category-action'] == 'order'){
      
	  foreach($hidden_id as $key=>$hidden_id){
	     update_order($key, $hidden_id);
	  }
	  
   }
   
   
}
?>