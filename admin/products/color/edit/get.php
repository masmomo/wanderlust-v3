<?php
/* -- FUNCTIONS -- */
function get_color($post_color_id){
   $conn   = connDB();
    
   $sql    = "SELECT * FROM tbl_color WHERE `color_id` = '$post_color_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function count_products($post_color_id){
   $conn   = connDB();
    
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_product_type WHERE `color_id` = '$post_color_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}
?>