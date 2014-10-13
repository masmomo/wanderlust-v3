<?php
// CALL FUNCTION
$provinces = get_province();
$country   = get_country();

if(isset($_POST['btn-add-shipping'])){
   // DEFINED VARIABLE
   $courier_name        = $_POST['courier_name'];
   $courier_description = $_POST['description'];
   $service             = $_POST['courier_service'];
   $weight              = $_POST['courier_weight'];
   
   insertCourier($courier_name, $courier_description, $service, $weight);
   
   $courier_id      = get_max_courier();
   $courier_service = $_POST['courier_service'];
   
   if($courier_service == "Local Only"){
      $foreach_province  = $_POST['province_name'];
	  $foreach_city_name = $_POST['city_name'];
	  $foreach_rate      = clean_price($_POST['array_rate']);
	  $weight            = $_POST['courier_weight'];
	  
	  foreach($foreach_province as $provinces){
         $city = get_city($provinces);
		 
		 foreach($city as $key=>$city){
		    insertCourierRate($courier_id['latest_id'], $provinces, $city['city_name'], '0', $weight);
	     }
      }
	  
	  $rate = clean_price($_POST['courier_rate']);
	  $courier_rate_id = get_min_courier($courier_id['latest_id']);
	  $initial_id      = $courier_rate_id['latest_id'];
	  
	  foreach($rate as $rate){
         update_rate($initial_id, $courier_id['latest_id'], $rate);
	  
         $initial_id++;
      }
   
   }else if($courier_service == "International Only"){
	   
	   $courier_name     = $courier_id['latest_id'];
	   $courier_province = "international";
	   $courier_city     = $_POST['international_id'];
       $courier_rate     = clean_price($_POST['international_rate']);
	   $courier_weight   = $_POST['courier_weight'];
	   
	   $courier_rate_id  = get_min_courier($courier_id['latest_id']);
	   $initial_id       = $courier_rate_id['latest_id'];
	   
	   foreach($courier_city as $key=>$city){
		 insertCourierRate($courier_name, $courier_province, $city, $courier_rate[$key], $courier_weight);
	   }
	   
	   foreach($courier_rate as $rate){
          update_rate($initial_id, $courier_id['latest_id'], $rate);
		  
		  $initial_id++;
	   }
	   
   }else if($courier_service == "Local & International"){
	   
	  // LOCAL
      $foreach_province  = $_POST['province_name'];
	  $foreach_city_name = $_POST['city_name'];
	  $foreach_rate      = clean_price($_POST['array_rate']);
	  $weight            = $_POST['courier_weight'];
	  
	  foreach($foreach_province as $provinces){
         $city = get_city($provinces);
		 
		 foreach($city as $key=>$city){
		    insertCourierRate($courier_id['latest_id'], $provinces, $city['city_name'], '0', $weight);
	     }
      }
	  
	  $rate = clean_price($_POST['courier_rate']);
	  $courier_rate_id = get_min_courier($courier_id['latest_id']);
	  $initial_id      = $courier_rate_id['latest_id'];
	  
	  foreach($rate as $rate){
         update_rate($initial_id, $courier_id['latest_id'], $rate);
	  
         $initial_id++;
      }
	  
	  
	   // INTERNATIONAL
	   $courier_name     = $courier_id['latest_id'];
	   $courier_province = "international";
	   $courier_city     = $_POST['international_id'];
       $courier_rate     = clean_price($_POST['international_rate']);
	   $courier_weight   = $_POST['courier_weight'];
	   
	   $courier_rate_id  = get_min_courier($courier_id['latest_id']);
	   $initial_id       = $courier_rate_id['latest_id'];
	   
	   foreach($courier_city as $key=>$city){
		 insertCourierRate($courier_name, $courier_province, $city, $courier_rate[$key], $courier_weight);
	   }
	   
	   foreach($courier_rate as $rate){
          update_rate($initial_id, $courier_id['latest_id'], $rate);
		  
		  $initial_id++;
	   }
      
   }
   
   //$_SESSION['alert'] = "success";
   //$_SESSION['msg']   = "Item(s) has been successfully added.";
		 
   
}
?>