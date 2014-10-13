<?php
function add_news_category(){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_news_category ORDER BY `category_name`";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}


function get_news_id(){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_news ORDER BY `news_id` DESC LIMIT 1";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function edit_news_category($news_category, $news_title, $news_date, $news_image, $news_content, $news_created_date, $news_id){
   $conn   = connDB();
   
   $sql    = "UPDATE tbl_news SET 
              `news_category` = '$news_category', 
			  `news_title` = '$news_title', 
			  `news_date` = '$news_date', 
			  `news_image` = '$news_image', 
			  `news_content` = '$news_content', 
			  `news_created_date` = '$news_created_date'
			  
			  WHERE `news_id` = '$news_id'";
   $query  = mysql_query($sql, $conn);
}

function check_news_title($news_title){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_news WHERE `news_title` = '$news_title'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

?>