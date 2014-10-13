<?php
include("get.php");
include("update.php");
/*--------------------*/
/*        ABOUT       */
/*--------------------*/

if(isset($_POST['btn-about'])){
   if($_POST['btn-about'] == "Save Changes"){
      
	  $type_array = array('about', 'facilities', 'quality', 'description', 'faq');
	  
	  foreach($type_array as $type_array){
	     $check_about = check_about($type_array);
		 $fill = $_POST[$type_array];
	  
	     if($check_about['rows'] > 0){
	        update_about($fill, $type_array);
	     }else{
	        insert_about($fill, $type_array);
	     }
	  
	  }
	  
	  $_SESSION['alert'] = 'success';
	  $_SESSION['msg']   = 'Changes successfully saved.';
	  
   }
   
}
?>