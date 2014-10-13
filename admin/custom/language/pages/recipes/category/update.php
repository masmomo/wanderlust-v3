<?php
function insert_category_lang($category_name, $post_id_param, $category_active, $category_visibility, $post_lang_code, $post_additional){
   $conn = connDB();
   
   $sql   = "INSERT INTO tbl_recipes_category_lang (`category_name`, `id_param`, `category_active`, `category_visibility`, `language_code`, `additional`) 
                                            VALUES ('$category_name', '$post_id_param', '$category_active', '$category_visibility', '$post_lang_code', '$post_additional')";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}



function update_category_lang($category_name, $category_active, $category_visibility, $category_id, $post_lang_code){
   $conn = connDB();
   
   $sql   = "UPDATE tbl_recipes_category_lang SET `category_name` = '$category_name', 
                                                  `category_active` = '$category_active', 
											      `category_visibility` = '$category_visibility'
			 WHERE `id_param` = '$category_id' AND `language_code` = '$post_lang_code'
			";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}



function delete_category_lang($category_id){
   $conn = connDB();
   
   $sql   = "DELETE FROM tbl_recipes_category_lang WHERE `category_id` = '$category_id'";
   $query = mysql_query($sql, $conn);
}
?>