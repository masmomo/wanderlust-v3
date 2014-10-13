<?php
function count_news_category(){
   $conn = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_news_category ORDER BY category_name";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function get_news_category(){
   $conn = connDB();
   
   $sql    = "SELECT * FROM tbl_news_category ORDER BY category_name";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}


function count_news($post_search, $post_sort_by, $post_qpp, $post_column_name,$post_opt_name, $post_record_name){
   $conn = connDB();
   
   $sql    = "SELECT * FROM tbl_news AS news INNER JOIN tbl_news_category AS cat ON news.news_category = cat.category_id 
              WHERE $post_search AND $post_column_name $post_opt_name '$post_record_name'
              ORDER BY $post_sort_by
			 ";
   $query  = mysql_query($sql, $conn);

   $full_order['total_query'] = mysql_num_rows($query);
   $full_order['total_page']  = ceil($full_order['total_query'] / $post_qpp);
   
   return $full_order;
}


function get_listing_news($post_search, $post_sort_by, $post_first_record, $post_qpp, $post_column_name,$post_opt_name, $post_record_name){
   $conn = connDB();
   
   $sql    = "SELECT * FROM tbl_news AS news INNER JOIN tbl_news_category AS cat ON news.news_category = cat.category_id 
              WHERE $post_search AND $post_column_name $post_opt_name '$post_record_name'
              ORDER BY $post_sort_by
			  LIMIT $post_first_record, $post_qpp
			 ";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}
?>