<?php
function delete($post_career_id){
   $conn  = connDB();
   
   $sql   = "DELETE FROM tbl_store WHERE `career_id` = '$post_career_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}

function update_visibility($post_visibility, $post_category_id){
   $conn  = connDB();
   
   $sql   = "UPDATE tbl_store SET `visibility` = '$post_visibility' WHERE `career_id` = '$post_category_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}
?>