<?php

// DEFINED VARIABLE
$req_collection_id = clean_number($_REQUEST['collection_id']);


// CALL FUNCTION
$detail_collection = get_detail($req_collection_id);

if(isset($_POST['btn_detail_collection'])){
   
   // DEFINED VARIABLE
   $collection_name       = $_POST['collection_name'];
   $collection_id         = $_POST['hidden_collection_id'];
   
   $collection_active_status     = 'Active';
   $collection_visibility_status = $_POST['visibility'];
	  
   // CALL FUNCTION
   $check = count_products($collection_id);
   
   if($_POST['btn_detail_collection'] != 'Delete'){
	  
	  update($collection_name, $collection_active_status, $collection_visibility_status, $collection_id);
	  
	  $_SESSION['alert'] = 'success';
	  $_SESSION['msg']   = 'Changes has been successfully saved';
	  
   
   }else{
      
	 if($check['rows'] > 0){
		$_SESSION['alert'] = 'error';
		$_SESSION['msg']   = "Can't delete because it contains one or more items.";
	 }else{
		deleteCollection($collection_id);
		
		$_SESSION['alert'] = 'success';
		$_SESSION['msg']   = "Item(s) has been successfully deleted.";
	 }
	  
   }
   
}
?>