<?php
function insertCourier($post_courier_name, $post_courier_description, $post_services, $post_weight_counter){
   $conn   = connDB();
   
   $sql    = "INSERT INTO tbl_courier (`courier_name`, `courier_description`, `services`, `active_status`, `weight_counter`) VALUES('$post_courier_name', '$post_courier_description', '$post_services', 'Active', '$post_weight_counter')";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function insertCourierRate($post_courier_name, $post_courier_province, $post_courier_city, $post_courier_rate, $post_courier_weight){
   $conn   = connDB();
   
   $sql    = "INSERT INTO tbl_courier_rate 
              (`courier_name`, `courier_province`, `courier_city`, `courier_rate`, `courier_weight`) VALUES 
			  ('$post_courier_name', '$post_courier_province', '$post_courier_city', '$post_courier_rate', '$post_courier_weight')";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function update_rate($post_courier_rate_id, $post_courier_name, $post_rate){
   $conn  = connDB();
   
   $sql   = "UPDATE tbl_courier_rate SET `courier_rate` = '$post_rate' WHERE `courier_rate_id` = '$post_courier_rate_id' AND `courier_name` = '$post_courier_name'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}
?>