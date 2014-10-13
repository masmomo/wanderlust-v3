<?php
// CALL FUNCTION
$courier  = get_detail($ship_id);
$shipping = get_shipping($ship_id);

$service       = $courier['services'];
$international = international($ship_id);

if($service == "Local Only"){
   $title = "Local";
}else if($service == "International Only"){
   $title = "International";
}else{
   $title = "Local";
}

$country = get_country();


if(isset($_POST['btn-edit-shipping'])){

   // DEFINED VARIABLE
   $courier_ids         = $_REQUEST['sid'];
   $courier_name        = $_POST['courier_name'];
   $courier_description = $_POST['description'];
   $courier_service     = $_POST['courier_service'];
   $courier_weight      = $_POST['courier_weight'];
   
   $courier_id          = $_POST['city_name'];
   $courier_rate        = clean_price($_POST['courier_rate']);
   
   if($_POST['btn-edit-shipping'] != "Delete"){
   
      update_local_courier($courier_name, $courier_description, $courier_service, 'Active', $courier_weight, $courier_ids);
	  
	  // RATE
	  foreach($courier_id as $index=>$courier_id){
         update_local_rate($courier_rate[$index], $courier_weight, $courier_id);	  
	  }
	  
	  $_SESSION['alert'] = "success";
	  $_SESSION['msg']   = "Changes have been successfully saved.";
   
   }else{
   
   } 

}
?>