<?php
/* -- FUNCTIONS -- */
function count_products($post_color_name){
   $conn   = connDB();
    
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_color WHERE `color_name` = '$post_color_name'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function get_order(){
   $conn   = connDB();
    
   $sql    = "SELECT MAX(color_order) AS max_order FROM tbl_color";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}
?>