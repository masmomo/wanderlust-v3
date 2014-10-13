<?php
// DEFAULT

function get_news_detail_check($news_id){
   $conn   = connDB();
   $sql    = "SELECT * FROM tbl_news AS news INNER JOIN tbl_news_category AS cat ON news.news_category = cat.category_id WHERE news.news_id = '$news_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function getAllCategory_check(){
   $conn  = connDB();
   $sql   = "SELECT * FROM tbl_news_category ORDER BY category_name";
   $query = mysql_query($sql, $conn);
   $row   = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}

function check_news_title_check($news_title){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_news WHERE `news_title` = '$news_title'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


// LANGUAGE
function get_news_detail_lang($news_id, $news_title){
   $conn   = connDB();
   $sql    = "SELECT * FROM tbl_news_lang AS news LEFT JOIN tbl_news_category_lang AS cat ON news.news_category = cat.id_param WHERE news.id_param = '$news_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function get_new_param($post_news_id){
   $conn   = connDB();
   $sql    = "SELECT * FROM tbl_news_lang WHERE `news_id` = '$post_news_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function getAllCategory_lang(){
   $conn  = connDB();
   $sql   = "SELECT * FROM tbl_news_category_lang ORDER BY category_name";
   $query = mysql_query($sql, $conn);
   $row   = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}

function get_category_lang($post_id_param, $post_lang_code){
   $conn   = connDB();
   $sql    = "SELECT * FROM tbl_news_category_lang WHERE `id_param` = '$post_id_param' AND `language_code` = '$post_lang_code'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function check_news_title_lang($news_title){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_news_lang WHERE `news_title` = '$news_title'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function check_news_lang($post_news_id, $post_lang_code){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_news_lang WHERE `id_param` = '$post_news_id' AND `language_code` = '$post_lang_code'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function check_news_cat_lang($post_id_param, $post_lang_code){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_news_category_lang WHERE `id_param` = '$post_id_param' AND `language_code` = '$post_lang_code'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

?>