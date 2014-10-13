<?php
/*
|--------------------|
|      SORTING       |
|--------------------|
*/

$equal_search    = array('size_type_active', 'size_type_visibility');
$default_sort_by = "size_type_name";

$pgdata = page_init($equal_search,$default_sort_by); // static/general.php

$page             = $pgdata['page'];
$query_per_page   = $pgdata['query_per_page'];
$sort_by          = $pgdata['sort_by'];
$first_record     = $pgdata['first_record'];
$search_parameter = $pgdata['search_parameter'];
$search_value     = $pgdata['search_value'];
$search_query     = $pgdata['search_query'];
$search           = $pgdata['search'];


$full_order  = get_full_size_manage($search_query, $sort_by, $first_record ,$query_per_page);
$total_query = $full_order['total_query'];
$total_page  = ceil($full_order['total_query'] / $query_per_page);


// CALL FUNCTION
$listing_order = get_listing_size_manage($search_query, $sort_by, $first_record ,$query_per_page);


// STORED VALUE
echo "<input type=\"hidden\" name=\"url\" id=\"url\" class=\"hidden\" value=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/size-view\">\n";
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

// HANDLING ARROW SORTING
if($_REQUEST['srt'] == "size_type_name DESC"){
   $arr_size_group_name = "<span class=\"sort-arrow-up\"></span>";
}else if($_REQUEST['srt'] == "size_type_name"){
   $arr_size_group_name = "<span class=\"sort-arrow-down\"></span>";
}

else if($_REQUEST['srt'] == "size_name DESC"){
   $arr_size_name = "<span class=\"sort-arrow-up\"></span>";
}else if($_REQUEST['srt'] == "size_name"){
   $arr_size_name = "<span class=\"sort-arrow-down\"></span>";
   

}else if($_REQUEST['srt'] == "total_product DESC"){
   $arr_total_product = "<span class=\"sort-arrow-up\"></span>";
}else if($_REQUEST['srt'] == "total_product"){
   $arr_total_product = "<span class=\"sort-arrow-down\"></span>";

}else if($_REQUEST['srt'] == "active_status DESC"){
   $arr_active_status = "<span class=\"sort-arrow-up\"></span>";
}else if($_REQUEST['srt'] == "active_status"){
   $arr_active_status = "<span class=\"sort-arrow-down\"></span>";
   

}else if($_REQUEST['srt'] == "visibility_status DESC"){
   $arr_visibility_status = "<span class=\"sort-arrow-up\"></span>";
}else if($_REQUEST['srt'] == "visibility_status"){
   $arr_visibility_status = "<span class=\"sort-arrow-down\"></span>";
}


if(isset($_POST['btn-size-index'])){
   if($_POST['btn-size-index'] == "Save Changes"){
	   
	   if(empty($_POST['edit_size_type_id'])){
	      insert($size_type_name, $size_type_order, $size_type_active, $size_type_visibility, $size_sku, $size_type_id, $size_name);
	      
		  $_SESSION['alert'] = "success";
		  $_SESSION['msg'] = "Success insert : ".$size_type_name; 
	   }else{
	      update($size_type_name, $size_type_order, $size_type_active, $size_type_visibility, $edit_size_sku, $edit_size_type_id, $edit_size_name);
	      $_SESSION['alert'] = "success";
		  $_SESSION['msg'] = "Success update : ".$size_type_name; 
	   }
	
   }else if($_POST['btn-size-index'] == "Delete"){
	  // CALL FUNCTION
	  $check_delete = checkDelete($edit_size_type_id);
	  
	  if($check_delete['total_product'] > 0){
         $_SESSION['alert'] = "error";
	     $_SESSION['msg']   = "Can't delete because it contains one or more items.";   
	  }else{
         delete($edit_size_type_id);
	  }
   }else if($_POST['btn-size-index'] == "GO"){
	  
	  // DEFINED VARIABLE
	  $size_type_id = $_POST['size_type_id'];
	  
      if($_POST['category-action'] == "delete"){
	     foreach($size_type_id as $post_typeid){
	        // CALL FUNCTION
	        $check_delete = checkDelete($post_typeid);
	  
	        if($check_delete['total_product'] > 0){
     		   $_SESSION['alert'] = "error";
			   $_SESSION['msg']   = "Can't delete because it contains one or more items.";   
	        }else{
               delete($post_typeid);
	           $_SESSION['alert'] = "success";
		       $_SESSION['msg'] = "Item(s) has been successfully deleted."; 
	        }
		 
	     }// FOREACH
	  
	  }else if($_POST['category-action'] == "change"){
	     
		 foreach($size_type_id as $post_typeid){
		 
		    if($_POST['category-option'] == 'yes'){
		       update_visibility('Yes', $post_typeid);
			}else if($_POST['category-option'] == 'no'){
		       update_visibility('No', $post_typeid);
			}
			
		 }
		 
	  }
	  
   }
   
}

?>