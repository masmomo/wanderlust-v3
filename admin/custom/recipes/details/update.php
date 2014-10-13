<?php
function updateRecipes($post_category_recipes, $post_recipe_name, $post_recipe_image, $post_recipe_date, $post_recipe_ingredients, $post_recipe_sauce, $post_recipe_method, $post_recipe_alias, $post_recipe_visibility, $post_recipe_additional, $post_recipe_id){
   $conn  = connDB();
   
   $sql   = "UPDATE tbl_recipes SET `category_recipes` = '$post_category_recipes',
                                    `recipe_name` = '$post_recipe_name',
									`recipe_image` = '$post_recipe_image',
									`recipe_date` = '$post_recipe_date',
									`recipe_ingredients` = '$post_recipe_ingredients',
									`recipe_sauce` = '$post_recipe_sauce',
									`method` = '$post_recipe_method',
									`alias` = '$post_recipe_alias',
									`visibility_status` = '$post_recipe_visibility',
									`additional` = '$post_recipe_additional'
			 WHERE `recipe_id` = '$post_recipe_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}


function deleteRecipes($post_recipe_id){
   $conn  = connDB();
   
   $sql   = "DELETE FROM tbl_recipes WHERE `recipe_id` = '$post_recipe_id' ";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}
?>