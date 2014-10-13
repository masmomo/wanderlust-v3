<?php
function count_job($src_param, $query_per_page){
   $conn   = conndB();
   
   $sql    = "SELECT * FROM tbl_filter_sub WHERE $src_param";
   $query  = mysql_query($sql, $conn);
  
   $full_order['total_query'] = mysql_num_rows($query);
   $full_order['total_page']  = ceil($full_order['total_query'] / $query_per_page); 

   return $full_order;
}


function get_job($src_param, $post_order_by, $start_record, $query_per_page, $cat){
   $conn   = conndB();
   
   $sql    = "SELECT * FROM tbl_filter_sub WHERE $src_param ORDER BY $post_order_by LIMIT $start_record, $query_per_page";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}


function get_city($post_filter_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_filter_sub WHERE `filter_id` = '$post_filter_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function count_category(){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_career_category ORDER BY `category_name`";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function get_category(){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_career_category ORDER BY `category_name`";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}


function get_detail($post_career_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_career WHERE `career_id` = '$post_career_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}
?>