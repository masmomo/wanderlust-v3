<?php
/*
|--------------------|
|      SORTING       |
|--------------------|
*/

$equal_search    = array('collection_active_status', 'collection_visibility_status');
$default_sort_by = "collection_order DESC";

$pgdata = page_init($equal_search,$default_sort_by); // static/general.php

$page             = $pgdata['page'];
$query_per_page   = $pgdata['query_per_page'];
$sort_by          = $pgdata['sort_by'];
$first_record     = $pgdata['first_record'];
$search_parameter = $pgdata['search_parameter'];
$search_value     = $pgdata['search_value'];
$search_query     = $pgdata['search_query'];
$search           = $pgdata['search'];


$full_order  = get_full_collection_manage($search_query, $sort_by, $first_record ,$query_per_page);
$total_query = $full_order['total_query'];
$total_page  = ceil($full_order['total_query'] / $query_per_page);


// CALL FUNCTION
$listing_order = get_listing_collection_manage($search_query, $sort_by, $first_record ,$query_per_page);


// STORED VALUE
echo "<input type=\"hidden\" name=\"url\" id=\"url\" class=\"hidden\" value=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/collection-view\">\n";
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
if($_REQUEST['srt'] == "collection_name DESC"){
   $arr_collection_name = "<span class=\"sort-arrow-up\"></span>";
}else if($_REQUEST['srt'] == "collection_name"){
   $arr_collection_name = "<span class=\"sort-arrow-down\"></span>";
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


if(isset($_POST['btn-collection-index'])){
   if($_POST['btn-collection-index'] == "Save Changes"){
	   
	   if(empty($_POST['edit_collection_id'])){
	      insert($collection_name, $collection_order, $collection_active_status, $collection_visibility_status);
	      
		  $_SESSION['alert'] = "success";
		  $_SESSION['msg'] = "Success insert : ".$collection_name; 
	   }else{
	      update($collection_name, $collection_order, $collection_active_status, $collection_visibility_status, $edit_collection_id);
	      $_SESSION['alert'] = "success";
		  $_SESSION['msg'] = "Success update : ".$collection_name; 
	   }
	
   }else if($_POST['btn-collection-index'] == "Delete"){
	  // CALL FUNCTION
	  $check_delete = checkDelete($edit_collection_id);
	  
	  if($check_delete['total_product'] > 0){
         $_SESSION['alert'] = "error";
	     $_SESSION['msg']   = "Can't delete because it contains one or more items.";   
	  }else{
         delete($edit_collection_id);
	  }
   }else if($_POST['btn-collection-index'] == "GO"){
	  
	  // DEFINED VARIABLE
	  $collection_id = $_POST['collection_id'];
	  
      if($_POST['category-action'] == "delete"){
	     foreach($collection_id as $post_typeid){
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
	     
		 foreach($collection_id as $post_typeid){
		 
		    if($_POST['category-option'] == 'yes'){
		       update_visibility('Yes', $post_typeid);
			}else if($_POST['category-option'] == 'no'){
		       update_visibility('No', $post_typeid);
			}
			
		 }
		 
	  }	else if($_POST['category-action'] == 'order'){

				  // DEFINED VARIABLE
				  $hidden_id = $_POST['hidden_collection_id'];
				  $hidden_order = $_POST['collection_order'];

				//print_r($hidden_order);

				  $current_order = reset($hidden_order);
			      foreach($hidden_id as $collection_id){
				     update_order($current_order, $collection_id); 
				     $current_order = next($hidden_order);
				  }

		}
	  
   }
   
}

?>