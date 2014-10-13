<?php
/* -- DEFINED VARIABLE -- */

// REQUEST
$category_id   = $_REQUEST['cat_id'];


// CALL FUNCTION
$category = get_city($category_id);
$check    = count_job($category_id);
$city     = get_cities();

//$category_name = 


if(isset($_POST['btn_detail_service_job'])){
   
   // DEFINED VARIABLE
   $active     = '1';
   $visibility = $_POST['visibility_status'];
   $city_name  = stripslashes($_POST['category_name']);
   $cat_id     = $_POST['cat_id'];
   $category   = $_POST['category_department'];
   $desc       = stripslashes($_POST['career_description']);
   $map        = stripslashes($_POST['category_maps']);
   
   if($_POST['btn_detail_job'] == 'Delete'){
   
      delete($cat_id);
	  
	  $_SESSION['alert'] = 'success';
	  $_SESSION['msg']   = 'Item has been successfully deleted.';
   
   }else{
	   
      update($city_name, $category, $desc, $map, $visibility, $cat_id);
	  
	  $_SESSION['alert'] = 'success';
	  $_SESSION['msg']   = 'Item has been successfully saved.';
   }
   
}
?>