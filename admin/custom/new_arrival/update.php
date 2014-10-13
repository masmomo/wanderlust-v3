<?php
function insert_new_arrival($post_new_arrival, $post_id){
   $conn  =  connDB();
   
   $sql   = "UPDATE tbl_product_type SET `type_new_arrival` = '$post_new_arrival' WHERE `type_id` = '$post_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}


function insert_new_arrivals($post_start, $post_end, $post_type_id){
   $conn  =  connDB();
   
   $sql   = "INSERT INTO tbl_new_arrival (`new_start`, `new_end`, `new_type_id`) VALUES('$post_start', '$post_end', '$post_type_id')";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}

function delete_new_arrivals($post_new_arrival, $post_id){
   $conn  =  connDB();
   
   $sql   = "DELETE FROM tbl_new_arrival WHERE `new_id` = '$post_new_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}


function delete_new_arrival($post_new_arrival, $post_id){
   $conn  =  connDB();
   $sql   = "UPDATE tbl_product SET `type_new_arrival` = '$post_new_arrival' WHERE `type_id` = '$post_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}



function delete_all_new_arrivals($post_new_id){
   $conn  =  connDB();
   
   $sql   = "DELETE FROM tbl_new_arrival WHERE `new_id` != '$post_new_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}


function delete_all_new_arrival($post_new_arrival){
   $conn  =  connDB();
   $sql   = "UPDATE tbl_product_type SET `type_new_arrival` = '$post_new_arrival'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}
?>