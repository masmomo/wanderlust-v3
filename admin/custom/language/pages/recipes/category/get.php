<?php
function lang_get_param($post_category_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_recipes_category WHERE `category_id` = '$post_category_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function check_default(){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_recipes_category_lang";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function check_action($post_id_param, $post_lang_code){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_recipes_category_lang WHERE `id_param` = '$post_id_param' AND `language_code` = '$post_lang_code'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function get_default_value(){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_recipes_category";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
	  array_push($row, $result);
   }
   
   return $row;
   
}
?>