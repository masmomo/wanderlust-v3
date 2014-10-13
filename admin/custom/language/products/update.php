<?php
/* -- UPDATE LANGUAGE -- */
function insert_product_lang($post_id_param, $post_product_name, $post_product_sold_out, $post_product_category, $post_product_new_arrival, $post_product_order, $post_product_date_added, $post_product_size_type_id, $post_product_visibility, $post_product_delete, $post_product_alias, $post_page_title, $post_page_description, $post_lang_code){
   $conn  = connDB();
   $sql   = "INSERT INTO tbl_product_lang (`id_param`, `product_name`, `product_sold_out`, `product_category`, `product_new_arrival`, `product_order`, `product_date_added`, `product_size_type_id`, `product_visibility`, `product_delete`, `product_alias`, `page_title`, `page_description`, `language_code`) VALUES('$post_id_param', '$post_product_name', '$post_product_sold_out', '$post_product_category', '$post_product_new_arrival', '$post_product_order', '$post_product_date_added', '$post_product_size_type_id', '$post_product_visibility', '$post_product_delete', '$post_product_alias', '$post_page_title', '$post_page_description', '$post_lang_code')";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}


function update_product_lang($post_product_name, $post_id_param, $post_lang_code){
   $conn  = connDB();
   $sql   = "UPDATE tbl_product_lang SET `product_name` = '$post_product_name'
             WHERE `id_param` = '$post_id_param' AND `language_code` = '$post_lang_code'
			";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}


function insert_product_type_lang($post_id_param, $post_product_id, $post_type_code, $post_type_name, $post_type_price, $post_color_id, $post_type_description, $post_type_weight, $post_type_new_arrival, $post_type_image, $post_type_order, $post_type_sold_out, $post_type_visibility, $post_type_delete, $post_type_alias, $post_page_title, $post_page_description, $post_lang_code){
   $conn  = connDB();
   $sql   = "INSERT INTO tbl_product_type_lang (`id_param`, `product_id`, `type_code`, `type_name`, `type_price`, `color_id`, `type_description`, `type_weight`, `type_new_arrival`, `type_image`, `type_order`, `type_sold_out`, `type_visibility`, `type_delete`, `type_alias`, `page_title`, `page_description`, `language_code`) VALUES('$post_id_param', '$post_product_id', '$post_type_code', '$post_type_name', '$post_type_price', '$post_color_id', '$post_type_description', '$post_type_weight', '$post_type_new_arrival', '$post_type_image', '$post_type_order', '$post_type_sold_out', '$post_type_visibility', '$post_type_delete', '$post_type_alias', '$post_page_title', '$post_page_description', '$post_lang_code')";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}


function update_product_type_lang($post_product_name, $post_type_description, $post_id_param, $post_lang_code){
   $conn  = connDB();
   $sql   = "UPDATE tbl_product_type_lang SET `type_name` = '$post_product_name',
                                              `type_description` = '$post_type_description'
             WHERE `id_param` = '$post_id_param' AND `language_code` = '$post_lang_code'
			";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}
?>