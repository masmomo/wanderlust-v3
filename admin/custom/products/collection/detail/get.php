<?php
/* -- FUNCTIONS -- */
function count_products($post_product_collection_id){
   $conn   = connDB();
    
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_product WHERE `product_collection` = '$post_product_collection_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function get_order(){
   $conn   = connDB();
    
   $sql    = "SELECT MAX(collection_order) AS max_order FROM tbl_collection";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function get_latest_id(){
   $conn   = connDB();
   $sql    = "SELECT * FROM tbl_collection ORDER BY collection_id DESC LIMIT 1";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function get_detail($post_collection_id){
   $conn   = connDB();
   $sql    = "SELECT * FROM tbl_collection
              WHERE collection_id = '$post_collection_id'
			 ";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}
?>