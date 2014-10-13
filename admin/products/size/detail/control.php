<?php

// DEFINED VARIABLE
$req_size_id = clean_number($_REQUEST['size_id']);


// CALL FUNCTION
$detail_size = get_detail($req_size_id);
$size        = get_detail_size($detail_size['size_type_id']);
$sku         = get_detail_size($detail_size['size_type_id']);

if(isset($_POST['btn_detail_size'])){
   
   // DEFINED VARIABLE
   $size_type_name       = $_POST['size_type_name'];
   $size_type_id         = $_POST['hidden_size_id'];
   
   $max_type_order       = get_order();
   $size_type_order      = ($max_type_order['size_type_order'] * 1 + 1);
   
   $size_type_active     = 'Active';
   $size_type_visibility = $_POST['visibility'];
   
   $size_name_array      = $_POST['size_group_name'];
   $size_name            = array();
   $size_name            = explode(", ",$size_name_array);
   
   $size_sku_array       = $_POST['size_sku'];
   $size_sku             = array();
   $size_sku             = explode(", ",$size_sku_array);
	  
   // CALL FUNCTION
   $check = count_products($size_type_id);
   
   if($_POST['btn_detail_size'] != 'Delete'){
	  
	  update($size_type_name, $size_type_order, $size_type_active, $size_type_visibility, $size_sku, $size_type_id, $size_name);
	  
	  $_SESSION['alert'] = 'success';
	  $_SESSION['msg']   = 'Changes has been successfully saved';
	  
   
   }else{
      
	 if($check['rows'] > 0){
		$_SESSION['alert'] = 'error';
		$_SESSION['msg']   = "Can't delete because it contains one or more items.";
	 }else{
		deleteSize($size_type_id);
		deleteSizeType($size_type_id);
		
		$_SESSION['alert'] = 'success';
		$_SESSION['msg']   = "Item(s) has been successfully deleted.";
	 }
	  
   }
   
}
?>