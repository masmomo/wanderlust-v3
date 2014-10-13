<?php
function delete_color($post_color_id){
   $conn = connDB();
   
   $sql    = "DELETE FROM tbl_color WHERE `color_id` = '$post_color_id'";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
}


function update_visibility($post_color_visibility_status, $post_color_id){
   $conn = connDB();
   
   $sql    = "UPDATE tbl_color SET `color_visibility_status` = '$post_color_visibility_status' WHERE `color_id` = '$post_color_id'";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
}


function update_order($post_order, $post_color_id){
   $conn = connDB();
   
   $sql    = "UPDATE tbl_color SET `color_order` = '$post_order' WHERE `color_id` = '$post_color_id'";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
}
?>