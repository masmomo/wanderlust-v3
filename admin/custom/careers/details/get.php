<?php
function get_city($post_category_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_career_category WHERE `category_id` = '$post_category_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function count_job($post_category_id){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_career WHERE `category` = '$post_category_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}
?>