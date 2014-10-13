<?php
/* -- GET LANGUAGE -- */

// PAGE DATA
function page_get_product($post_product_alias){
   $conn  = connDB();
   
   $sql     = "SELECT * FROM tbl_product AS prod INNER JOIN tbl_category AS cat ON prod.product_category = cat.category_id
                                                 INNER JOIN tbl_size_type AS size ON prod.product_size_type_id = size.size_type_id 
               WHERE `product_alias` = '$post_product_alias'
			  ";
   $query   = mysql_query($sql, $conn);
   $result  = mysql_fetch_array($query);
   
   return $result;
}


function page_get_type($post_product_alias){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_product AS prod INNER JOIN tbl_product_type AS type_ ON prod.id = type_.product_id
                                                LEFT JOIN tbl_product_image AS img ON type_.type_id = img.type_id
              WHERE `product_alias` = '$post_product_alias'
			 ";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}

function page_get_default_type($post_type_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_product_type WHERE `type_id` = '$post_type_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function page_get_color($post_color_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_color WHERE color_id = '$post_color_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function page_count_image($post_type_id){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_product_image WHERE `type_id` = '$post_type_id'
			 ";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function page_get_image($post_type_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_product_image WHERE `type_id` = '$post_type_id'
			 ";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}


function page_get_size($size_type_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_size_type AS type LEFT JOIN tbl_size AS size ON type.size_type_id = size.size_type_id
              WHERE type.size_type_id = '$size_type_id'
			 ";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}


function page_get_stock($post_type_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_product_stock WHERE `type_id` = '$post_type_id'";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}


// DEFAULT
function get_default_products($post_product_alias){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_product AS prod INNER JOIN tbl_product_type AS type_ ON prod.id = type_.product_id
                                                INNER JOIN tbl_product_image AS img ON type_.type_id = img.type_id
              WHERE `product_alias` = '$post_product_alias' GROUP BY `id`
			 ";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


// DUAL
function count_products_lang($post_id_param, $post_lang_code){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_product_lang AS prod LEFT JOIN tbl_product_type_lang AS type_ ON prod.id_param = type_.product_id
              WHERE prod.id_param = '$post_id_param' AND prod.language_code = '$post_lang_code'
			 ";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function get_products_lang($post_id_param, $post_lang_code){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_products_lang AS prod LEFT JOIN tbl_product_type_lang AS type_ ON prod.id_param = type_.product_id
              WHERE prod.id_param = '$post_id_param' AND prod.language_code = '$post_lang_code'
			 ";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}


function count_product_lang($post_id_param, $post_lang_code){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_product_lang WHERE id_param = '$post_id_param' AND language_code = '$post_lang_code'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function count_type_lang($post_id_param, $post_lang_code){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_product_type_lang WHERE `product_id` = '$post_id_param' AND language_code = '$post_lang_code'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function counting_type_lang($post_product_id, $post_id_param, $post_lang_code){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_product_type_lang WHERE `product_id` = '$post_product_id' AND `id_param` = '$post_id_param' AND language_code = '$post_lang_code'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function get_product_lang($post_id_param, $post_lang_code){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_product_lang  WHERE id_param = '$post_id_param' AND language_code = '$post_lang_code'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function get_type_lang($post_id_param, $post_lang_code){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_product_type_lang WHERE `id_param` = '$post_id_param' AND `language_code` = '$post_lang_code'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


# ----------------------------------------------------------------------
# HOW TO & TECHNICAL DATA
# ----------------------------------------------------------------------


function get_product_how($post_product_alias){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_product WHERE `product_alias` = '$post_product_alias'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}



function get_how($post_product_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_product_custom WHERE `product_id` = '$post_product_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}



function get_how_lang($post_product_id, $post_lang_code){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_product_custom_lang WHERE `product_id` = '$post_product_id' AND `language_code` = '$post_lang_code'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}



function check_how($post_product_id, $post_lang_code){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_product_custom_lang WHERE `product_id` = '$post_product_id' AND `language_code` = '$post_lang_code'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function insert_how($post_product_id, $post_how, $post_technical, $post_lang_code){
   $conn   = connDB();
   
   $sql    = "INSERT INTO tbl_product_custom_lang (`product_id`, `how`, `technical`, `language_code`) 
                                            VALUES('$post_product_id', '$post_how', '$post_technical', '$post_lang_code')";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
}


function update_how($post_how, $post_technical, $post_product_id){
   $conn   = connDB();
   
   $sql    = "UPDATE tbl_product_custom_lang SET `how` = '$post_how',
                                                 `technical` = '$post_technical'
              WHERE `product_id` = '$post_product_id'
             ";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
}

?>