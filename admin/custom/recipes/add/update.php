<?php
function addNews($post_castegory_recipe, $post_recipe_name, $post_recipes_image, $post_recipe_date, $post_recipe_ingredients, $post_recipe_sauce, $post_recipe_method, $post_alias, $visibility, $additional){
   $conn  = connDB();
   $sql   = "INSERT INTO tbl_recipes 
                    (`category_recipes`, `recipe_name`, `recipe_image`, `recipe_date`, `recipe_ingredients`, `recipe_sauce`, `method`, `alias`, `visibility_status`, `additional`) 
			 VALUES ('$post_castegory_recipe', '$post_recipe_name', '$post_recipes_image', '$post_recipe_date', '$post_recipe_ingredients', '$post_recipe_sauce', '$post_recipe_method', '$post_alias', '$visibility', '$additional')";
   $query = mysql_query($sql, $conn) or die("Error : ".mysql_error());
}

function updateNews($post_castegory_recipe, $post_recipe_name, $post_recipe_ingredients, $post_recipe_sauce, $post_recipe_method, $post_recipe_id){
   $conn  = connDB();
   $sql   = "UPDATE tbl_recipes SET `category_recipe` = '$post_castegory_recipe', 
                                    `recipe_name` = '$post_recipe_name',
									`recipe_ingredients` = '$post_recipe_ingredients', 
									`recipe_sauce` = '$post_recipe_sauce', 
									`recipe_method` = '$post_recipe_method'
			 WHERE category_id = '$post_recipe_id'";
   $query = mysql_query($sql, $conn) or die("Error : ".mysql_error());
}

function deleteNews($post_recipe_id){
   $conn  = connDB();
   $sql   = "DELETE FROM tbl_recipes WHERE `recipe_id` = '$post_recipe_id'";
   $query = mysql_query($sql, $conn) or die("Error : ".mysql_error());
}
?>