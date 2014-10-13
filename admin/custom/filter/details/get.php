<?php
function get_city($post_filter_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_filter WHERE `filter_id` = '$post_filter_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function count_job($post_category_id){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_filter WHERE `filter_id` = '$post_filter_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}
?>