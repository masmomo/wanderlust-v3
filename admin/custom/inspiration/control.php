<?php
/* -- FUNCTIONS -- */
$category = get_category();


function show_alert($post_alert, $post_msg, $session_check){
   
   if(!empty($session_check)){
      echo "<div class=\"alert-message ".$post_alert."\">";
      echo $post_msg;
      echo "</div> \n";
   }
   
}

function view_status($post_status, $post_param){
   
   if($post_status == "active"){
      
	  if($post_param == 1){
	     $return = "Active";
	  }else{
	     $return = "Inactive";
	  }
	  
   }else if($post_status == "inspiration_visibility"){
      
	  if($post_param == 1){
	     $return = "Yes";
	  }else{
	     $return = "No";
	  }
   }
   
   echo $return;
   
}



/*
|--------------------|
|      SORTING       |
|--------------------|
*/

// CATEGORY
if ($_REQUEST["cat"] == "" || $_REQUEST["cat"] == "top"){
   $column_name = '';
   $opt_name    = '';
   $record_name = 1;
}else{
   $column_name = 'category';
   $opt_name    = ' = ';
   $record_name = $_REQUEST["cat"];
}

$equal_search    = array('date_created', 'visibility');
$default_sort_by = "name";

$pgdata = page_init($equal_search,$default_sort_by); // static/general.php

$page             = $pgdata['page'];
$query_per_page   = $pgdata['query_per_page'];
$sort_by          = $pgdata['sort_by'];
$first_record     = $pgdata['first_record'];
$search_parameter = $pgdata['search_parameter'];
$search_value     = $pgdata['search_value'];
$search_query     = $pgdata['search_query'];
$search           = $pgdata['search'];


$data_record = get_record_inspirations($search_query, $sort_by, $first_record ,$query_per_page, $column_name, $opt_name, $record_name);
$total_query = $data_record['total_query'];
$total_page  = $data_record['total_page']; // RESULT

// CALL FUNCTION
$data        = get_inspirations($search_query, $sort_by, $first_record, $query_per_page, $column_name, $opt_name, $record_name);



/* ARROW */
if($_REQUEST['srt'] == "name DESC"){
   $arr_name = "<span class=\"sort-arrow-up\"></span>";
}else if($_REQUEST['srt'] == "name"){
   $arr_name = "<span class=\"sort-arrow-down\"></span>";
			   
}else if($_REQUEST['srt'] == "date_created DESC"){
   $arr_date_created = "<span class=\"sort-arrow-up\"></span>";
}else if($_REQUEST['srt'] == "date_created"){
   $arr_odate_created = "<span class=\"sort-arrow-down\"></span>";
									  
}else if($_REQUEST['srt'] == "active DESC"){
   $arr_active = "<span class=\"sort-arrow-up\"></span>";
}else if($_REQUEST['srt'] == "active"){
   $arr_active = "<span class=\"sort-arrow-down\"></span>";
									  
}else if($_REQUEST['srt'] == "visibility DESC"){
   $arr_visibility = "<span class=\"sort-arrow-up\"></span>";
}else if($_REQUEST['srt'] == "visibility"){
   $arr_visibility = "<span class=\"sort-arrow-down\"></span>";								  
}


/* -- BUTTON RESET -- */
if(empty($search_parameter)){
   $reset = "hidden";
}else{
   $reset = "";
}


/* -- STORED VALUE --*/
echo "<input type=\"hidden\" name=\"url\" id=\"url\" class=\"hidden\" value=\"".$prefix_url."view-project\">\n"; // Reset option
echo "<input type=\"hidden\" name=\"page\" id=\"page\" class=\"hidden\" value=\"".$page."\" /> \n";
echo "<input type=\"hidden\" name=\"current_category\" id=\"current_category\" class=\"hidden\" value=\"";
	if($cat == ''){
	   echo 'top';
	}else{
	   echo $_REQUEST["cat"];
	}
echo "\" /> \n";
echo "<input type=\"hidden\" name=\"query_per_page\" id=\"query_per_page\" class=\"hidden\" value=\"".$query_per_page."\" /> \n";
echo "<input type=\"hidden\" name=\"total_page\" id=\"total_page\" class=\"hidden\" value=\"".$total_page."\" /> \n";
echo "<input type=\"hidden\" name=\"sort_by\" id=\"sort_by\" class=\"hidden\" value=\"".$sort_by."\" /> \n";
echo "<input type=\"hidden\" name=\"search\" id=\"search\" class=\"hidden\" value=\"".$search_parameter."-".$search_value."\" /> \n";


// DATA VARIABLE
$inspiration_id = $_POST['inspiration_id'];


// LISTING ACTION
if(isset($_POST['btn_index_inspiration'])){
	
   if(!empty($inspiration_id)){
   
   // DELETE
   if($_POST['option-action'] == "delete"){
	  
	  foreach($inspiration_id as $inspiration_id){
         
		 // DELETING IMAGES
		 delete_inspiration_image($inspiration_id);
         
		 // DELETING FEATURED
		 delete_inspiration_featured($inspiration_id);
         
		 // DELETING INSPIRATION
		 delete_inspiration($inspiration_id);
		 
	  }
	  
	  $_SESSION['alert'] = "success";
	  $_SESSION['msg']   = "Success delete item(s)";
	  
   }else if($_POST['option-action'] == "visibility"){
      
	  foreach($inspiration_id as $inspiration_id){
	     
		 $get_data = get_inspiration($inspiration_id);
		 
		 // PREDEFINED VALUE
		 
		 $name        = "";
		 $description = "";
		 $active      = "";
		 $visibility  = $_POST['option-option'];
		 
		 if($visibility == "yes"){
		    update_inspirations(1, $inspiration_id);
		 }else{
		    update_inspirations(0, $inspiration_id);
		 }
		
	  }
	  
	  $_SESSION['alert'] = "success";
	  $_SESSION['msg']   = "Changes successfuly saved";
	  
   }
   
   }else{
	  $_SESSION['alert'] = "error";
	  $_SESSION['msg']   = "Please choose list";
   }
   
}
?>