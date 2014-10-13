<?php
/* -- DEFINED VARIABLE -- */

// REQUEST
$category_id   = $_REQUEST['cat_id'];


// CALL FUNCTION
$category = get_city($category_id);
$check    = count_job($category_id);

//$category_name = 


if(isset($_POST['btn_detail_city'])){
   
   // DEFINED VARIABLE
   $active     = '1';
   $visibility = $_POST['visibility_status'];
   $city_name  = stripslashes($_POST['category_name']);
   $cat_id     = $_POST['cat_id'];
   
   if($_POST['btn_detail_city'] == 'Delete'){
   
      if($check['rows'] > 0){
	     $_SESSION['alert'] = 'error';
		 $_SESSION['msg']   = "Can't delete item because it's contains one or more item under this category";
	  }else{
		 delete($cat_id);
		 
	     $_SESSION['alert'] = 'success';
		 $_SESSION['msg']   = 'Item has been successfully deleted.';
	  }
   
   }else{
      update($city_name, $visibility, $cat_id);
	  
	  $_SESSION['alert'] = 'success';
	  $_SESSION['msg']   = 'Item has been successfully saved.';
   }
   
}
?>