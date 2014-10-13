<?php
/* -- FEATURED -- */
function insertFeatured($post_type_id, $post_alias_id){
   $conn   = connDB();
   
   $sql    = "INSERT INTO tbl_featured (`featured_type_id`, `featured_alias_id`) VALUES ('$post_type_id', '$post_alias_id')";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
}

function updateFeatured($post_type_id, $post_featured_id){
   $conn   = connDB();
   
   $sql    = "UPDATE tbl_featured SET `featured_type_id` = '$post_type_id' WHERE `featured_id` = '$post_featured_id'";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
}
?>