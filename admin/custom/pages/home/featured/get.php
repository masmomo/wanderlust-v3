<?php
/* -- FEATURED --*/
function getFeatured($get_featured_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_featured WHERE `featured_id` = '$get_featured_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function get_featured($post_featured_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_featured WHERE `featured_alias_id` = '$post_featured_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}
?>