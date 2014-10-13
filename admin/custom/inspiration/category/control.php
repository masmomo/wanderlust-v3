<?php
/* --- CONTROL HEADER --- */

$equal_search     = array('visibility');
$default_sort_by  = "category_order";

$pgdata = page_init($equal_search,$default_sort_by); // static/general.php

$page             = $pgdata['page'];
$query_per_page   = $pgdata['query_per_page'];
$sort_by          = $pgdata['sort_by'];
$first_record     = $pgdata['first_record'];
$search_parameter = $pgdata['search_parameter'];
$search_value     = $pgdata['search_value'];
$search_query     = $pgdata['search_query'];
$search           = $pgdata['search'];


$full_order  = count_listing_news_category($search_query, $sort_by, $query_per_page);
$total_query = $full_order['total_query'];
$total_page  = $full_order['total_page']; // RESULT


// CALL FUNCTION
$all_news = get_listing_news_category($search_query, $sort_by, $first_record, $query_per_page);


// STORED VALUE
echo "<input type=\"hidden\" name=\"url\" id=\"url\" class=\"hidden\" value=\"".$prefix_url."project-category-view\">\n";
echo "<input type=\"hidden\" name=\"page\" id=\"page\" class=\"hidden\" value=\"".$page."\" /> \n";
echo "<input type=\"hidden\" name=\"query_per_page\" id=\"query_per_page\" class=\"hidden\" value=\"".$query_per_page."\" /> \n";
echo "<input type=\"hidden\" name=\"total_page\" id=\"total_page\" class=\"hidden\" value=\"".$total_page."\" /> \n";
echo "<input type=\"hidden\" name=\"sort_by\" id=\"sort_by\" class=\"hidden\" value=\"".$sort_by."\" /> \n";
echo "<input type=\"hidden\" name=\"search\" id=\"search\" class=\"hidden\" value=\"".$search_parameter."-".$search_value."\" /> \n";


// HANDLING ARROW SORTING
if($_REQUEST['srt'] == "category_name DESC"){
   $arr_category_name = "<span class=\"sort-arrow-up\"></span>";
}else if($_REQUEST['srt'] == "category_name"){
   $arr_category_name = "<span class=\"sort-arrow-down\"></span>";

}else if($_REQUEST['srt'] == "category_active DESC"){
   $arr_category_active = "<span class=\"sort-arrow-up\"></span>";
}else if($_REQUEST['srt'] == "category_active"){
   $arr_category_active = "<span class=\"sort-arrow-down\"></span>";
   
}else if($_REQUEST['srt'] == "category_visibility DESC"){
   $arr_category_visibility = "<span class=\"sort-arrow-up\"></span>";
}else if($_REQUEST['srt'] == "category_visibility"){
   $arr_category_visibility = "<span class=\"sort-arrow-down\"></span>";
   
}else{
   $arr_order_number = "<span class=\"sort-arrow-down\"></span>";
}


/* -- BUTTON RESET -- */
if(empty($search_parameter)){
   $reset = "hidden";
}else{
   $reset = "";
}


if(isset($_POST['btn_pop_category'])){
   
   $cat_id = $_POST['cat_id'];
   $action = $_POST['option-action'];
   $option = $_POST['option-option'];
   
   if($_POST['btn_pop_category'] == "GO"){
      
      if($action == "delete"){
	  
	     foreach($cat_id as $post_cat_id){
		 
		    // CALL FUNCTION
			$listing_child = get_inspirations($post_cat_id);
			
			if($listing_child['rows'] > 0){
		   
			   $_SESSION['alert'] = 'error';
			   $_SESSION['msg']   = "Can't delete item(s) because it contains one or more item(s)";
			
			}else{
			   
			   delete_category($post_cat_id);
			   
			   $_SESSION['alert'] = 'success';
			   $_SESSION['msg']   = "Item(s) has been successfully removed";
			}
			
		 }
			
	  }else if($action == 'visibility'){
	     
		 foreach($cat_id as $post_cat_id){
		 
			if($option == 'yes'){
			   update_category_visibility(1, $post_cat_id);
			}else if($option == 'no'){
			   update_category_visibility(0, $post_cat_id);
			}
			
			$_SESSION['alert'] = 'success';
			$_SESSION['msg']   = "Changes has been saved";
		 }
			
	  }
		 
   }
      
}
?>