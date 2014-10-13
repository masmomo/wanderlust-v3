<?php
function count_filter($post_filter_name){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_filter_sub WHERE `filter_name` = '$post_filter_name' ";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);

   return $result;
}
?>