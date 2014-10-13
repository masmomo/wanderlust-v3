<?php

if(isset($_POST['btn_add_collection'])){
   
   // DEFINED VARIABLE
   $collection_name       = $_POST['collection_name'];
   
   $max_type_order       = get_order();
   $collection_order      = ($max_type_order['max_order'] * 1 + 1);
   
   $collection_active_status     = 'Active';
   $collection_visibility_status = $_POST['visibility'];
   
   
   
   // CALL FUNCTION
   $check = count_products($collection_name);
   
   if($check['rows'] > 0){
	  $_SESSION['alert'] = 'error';
	  $_SESSION['msg']   = $collection_name.' has already taken, please input another collection group name';
   }else{
      insert($collection_name, $collection_order, $collection_active_status, $collection_visibility_status);
	  
	  $_SESSION['alert'] = 'success';
	  $_SESSION['msg']   = 'Item(s) has been successfully saved';
   }
}
?>