<?php
function get_all_news_category(){
   $conn = connDB();
   
   $sql   = "SELECT * FROM tbl_inspiration_category";
   $query = mysql_query($sql, $conn);
   $row   = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
   
}


function count_listing_news_category($search, $sort_by, $query_per_page){
   $conn  = connDB();
   
   $sql   = "SELECT * FROM tbl_inspiration_category WHERE $search ORDER BY $sort_by";
   $query = mysql_query($sql, $conn);

   $full_order['total_query'] = mysql_num_rows($query);
   $full_order['total_page']  = ceil($full_order['total_query'] / $query_per_page);
   
   return $full_order;
}


function get_listing_news_category($search, $sort_by, $first_record, $query_per_page){
   $conn = connDB();
   
   $sql   = "SELECT * FROM tbl_inspiration_category
			 WHERE $search 
			 ORDER BY $sort_by
			 LIMIT $first_record , $query_per_page
			";
   $query = mysql_query($sql, $conn);
   $row   = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
   
}


function get_inspirations($post_category_id){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_inspiration where `category` = '$post_category_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}
?>