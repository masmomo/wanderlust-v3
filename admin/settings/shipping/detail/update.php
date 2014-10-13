<?php 
function update_local_courier($post_courier_name, $post_courier_description, $post_service, $post_active_status, $post_weight_counter, $post_courier_id){
   $conn  = connDB();
   
   $sql   = "UPDATE tbl_courier SET `courier_name` = '$post_courier_name', `courier_description` = '$post_courier_description', `services` = '$post_service', `active_status` = '$post_active_status', `weight_counter` = '$post_weight_counter' WHERE `courier_id` = '$post_courier_id'";
   $query = mysql_query($sql, $conn) or die("Error: ".mysql_error());
}


function update_local_rate($post_courier_rate, $post_courier_weight, $post_courier_rate_id){
   $conn  = connDB();
   
   $sql   = "UPDATE tbl_courier_rate SET `courier_rate` = '$post_courier_rate', `courier_weight` = '$post_courier_weight' WHERE `courier_rate_id` = '$post_courier_rate_id'";
   $query = mysql_query($sql, $conn) or die("Error: ".mysql_error());
}

?>