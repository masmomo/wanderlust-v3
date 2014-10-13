<?php
function count_city($src_param, $post_order_by, $query_per_page){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_store_category 
              WHERE $src_param 
			  ORDER BY $post_order_by
			 ";
   $query  = mysql_query($sql, $conn);
   
   $full_order['total_query'] = mysql_num_rows($query);
   $full_order['total_page']  = ceil($full_order['total_query'] / $query_per_page); 

   return $full_order;
}


function get_city($src_param, $post_order_by, $start_record, $query_per_page){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_store_category
              WHERE $src_param 
			  ORDER BY $post_order_by
			  LIMIT $start_record, $query_per_page
			 ";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}


function count_job($post_category_id){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_store WHERE `category` = '$post_category_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function count_category(){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_store_category ORDER BY `category_name`";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function get_category(){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_store_category ORDER BY `category_name`";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}
?>