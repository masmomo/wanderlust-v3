<?php

if(isset($_POST['btn_add_size'])){
   
   // DEFINED VARIABLE
   $size_type_name       = $_POST['size_type_name'];
   
   $max_type_order       = get_order();
   $size_type_order      = ($max_type_order['size_type_order'] * 1 + 1);
   
   $size_type_active     = 'Active';
   $size_type_visibility = $_POST['visibility'];
   
   $size_name_array      = $_POST['size_group_name'];
   $size_name            = array();
   $size_name            = explode(",",$size_name_array);
   
   $size_sku_array       = $_POST['size_sku'];
   $size_sku             = array();
   $size_sku             = explode(",",$size_sku_array);
   
   // CALL FUNCTION
   $check = count_products($size_type_name);
   
   if($check['rows'] > 0){
	  $_SESSION['alert'] = 'error';
	  $_SESSION['msg']   = $size_type_name.' has already taken, please input another size group name';
   }else{
      insert($size_type_name, $size_type_order, $size_type_active, $size_type_visibility, $size_sku, $size_type_id, $size_name);
	  
	  $_SESSION['alert'] = 'success';
	  $_SESSION['msg']   = 'Item(s) has been successfully saved';
   }
}
?>