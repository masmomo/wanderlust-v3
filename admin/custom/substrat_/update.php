<?php
function delete($post_filter_id){
   $conn  = connDB();
   
   $sql   = "DELETE FROM tbl_filter_sub WHERE `filter_id` = '$post_filter_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}

function update_visibility($post_visibility, $post_filter_id){
   $conn  = connDB();
   
   $sql   = "UPDATE tbl_filter_sub SET `visibility` = '$post_visibility' WHERE `filter_id` = '$post_filter_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}
?>