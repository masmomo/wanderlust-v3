<?php
function get_news_detail($news_id){
   $conn   = connDB();
   $sql    = "SELECT * FROM tbl_news AS news INNER JOIN tbl_news_category AS cat ON news.news_category = cat.category_id WHERE news.news_id = '$news_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function getAllCategory(){
   $conn  = connDB();
   $sql   = "SELECT * FROM tbl_news_category ORDER BY category_name";
   $query = mysql_query($sql, $conn);
   $row   = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}

function check_news_title($news_title, $post_news_id){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_news WHERE `news_title` = '$news_title' AND `news_id` != '$post_news_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}
?>