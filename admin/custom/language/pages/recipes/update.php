<?php

function insert_recipes_lang($post_id_param, $post_category_recipes, $post_recipe_name, $post_recipe_image, $post_recipe_date, $post_recipe_ingredients, $post_recipe_sauce, $post_recipe_method, $post_recipe_alias, $post_recipe_visibility, $post_recipe_additional, $post_lang_code){
   $conn  = connDB();
   
   $sql   = "INSERT INTO tbl_recipes_lang (`id_param`, `category_recipes`, `recipe_name`, `recipe_image`, `recipe_date`, `recipe_ingredients`, `recipe_sauce`, `method`, `alias`, `visibility_status`, `additional`, `language_code`)
             VALUES('$post_id_param','$post_category_recipes', '$post_recipe_name', '$post_recipe_image', '$post_recipe_date', '$post_recipe_ingredients', '$post_recipe_sauce', '$post_recipe_method', '$post_recipe_alias', '$post_recipe_visibility', '$post_recipe_additional', '$post_lang_code')";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}

function updateRecipes_lang($post_id_param, $post_category_recipes, $post_recipe_name, $post_recipe_image, $post_recipe_date, $post_recipe_ingredients, $post_recipe_sauce, $post_recipe_method, $post_recipe_alias, $post_recipe_visibility, $post_recipe_additional, $post_recipe_id, $post_lang_code){
   $conn  = connDB();
   
   $sql   = "UPDATE tbl_recipes_lang SET `id_param` = '$post_id_param', 
                                         `category_recipes` = '$post_category_recipes',
                                         `recipe_name` = '$post_recipe_name',
										 `recipe_image` = '$post_recipe_image',
										 `recipe_date` = '$post_recipe_date',
										 `recipe_ingredients` = '$post_recipe_ingredients',
										 `recipe_sauce` = '$post_recipe_sauce',
										 `method` = '$post_recipe_method',
										 `alias` = '$post_recipe_alias',
										 `visibility_status` = '$post_recipe_visibility',
										 `additional` = '$post_recipe_additional',
										 `language_code` = '$post_lang_code'
			 WHERE `id_param` = '$post_recipe_id' AND `language_code` = '$post_lang_code'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}

/*
function deleteRecipes_lang($post_recipe_id){
   $conn  = connDB();
   
   $sql   = "DELETE FROM tbl_recipes WHERE `recipe_id` = '$post_recipe_id' ";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}
*/
?>