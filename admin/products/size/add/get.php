<?php
/* -- FUNCTIONS -- */
function count_products($post_size_type_name){
   $conn   = connDB();
    
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_size_type WHERE `size_type_name` = '$post_size_type_name'";
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

function get_latest_id(){
   $conn   = connDB();
   $sql    = "SELECT * FROM tbl_size_type ORDER BY size_type_id DESC LIMIT 1";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}
?>