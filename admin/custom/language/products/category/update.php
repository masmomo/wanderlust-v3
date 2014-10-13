<?php
function insert_category_lang($post_id_param, $post_category_name, $post_catgeory_desc, $post_category_level, $post_category_order, $post_category_active, $post_category_visibility, $post_lang_code){
   $conn  = connDB();
   
   $sql   = "INSERT INTO tbl_category_lang (`id_param`, `category_name`, `category_description`, `category_level`, `category_order`, `active`, `visibility`, `language_code`)
                                    VALUES('$post_id_param', '$post_category_name', '$post_catgeory_desc', '$post_category_level', '$post_category_order', '$post_category_active', '$post_category_visibility', '$post_lang_code')
			";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}

function update_category_lang($post_category_name, $post_id_param, $post_lang_code){
   $conn  = connDB();
   
   $sql   = "UPDATE tbl_category_lang SET `category_name` = '$post_category_name'
             WHERE `id_param` = '$post_id_param' AND `language_code` = '$post_lang_code'
            ";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}
?>