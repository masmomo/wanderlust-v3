<?php
function count_category_lang($post_id_param, $post_lang_code){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_category_lang WHERE `id_param` = '$post_id_param' AND `language_code` = '$post_lang_code'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function get_default_lang($post_category_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_category WHERE `category_id` = '$post_id_param'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function get_category_lang($post_id_param, $post_lang_code){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_category_lang WHERE `id_param` = '$post_id_param' AND `language_code` = '$post_lang_code'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}
?>