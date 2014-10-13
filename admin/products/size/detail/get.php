<?php
/* -- FUNCTIONS -- */
function count_products($post_product_size_type_id){
   $conn   = connDB();
    
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_product WHERE `product_size_type_id` = '$post_product_size_type_id'";
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


function get_detail($post_size_type_id){
   $conn   = connDB();
   $sql    = "SELECT * FROM tbl_size_type AS type_ INNER JOIN tbl_size AS size_ ON type_.size_type_id = size_.size_type_id
              WHERE type_.size_type_id = '$post_size_type_id'
			 ";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function get_detail_size($post_size_type_id){
   $conn   = connDB();
   $sql    = "SELECT * FROM tbl_size WHERE size_type_id = '$post_size_type_id' ORDER BY `size_id`";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}
?>