<?php
function insertCourier($post_courier_id){
   $conn  = connDB();
   
   $sql   = "INSERT INTO tbl_courier (`courier_name`, `courier_description`, `services`, `active_status`) VALUES('$post_courier_name', '$post_courier_description', '$post_courier_services', '$post_courier_active')";
   $query = mysql_query($sql, $conn);
}

function deleteCourier($post_courier_id){
   $conn  = connDB();
   
   $sql   = "DELETE FROM tbl_courier WHERE `courier_id` = '$post_courier_id'";
   $query = mysql_query($sql, $conn);
}

function deleteCourierRste($post_courier_name){
   $conn  = connDB();
   
   $sql   = "DELETE FROM tbl_courier_rate WHERE `courier_name` = '$post_courier_name'";
   $query = mysql_query($sql, $conn);
}
?>