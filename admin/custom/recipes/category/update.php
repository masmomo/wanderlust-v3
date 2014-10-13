<?php
function AddCategory($post_category_name, $post_category_active, $post_category_visibility){
   $conn  = connDB();
   $sql   = "INSERT INTO tbl_recipes_category (`category_name`, `category_active`, `category_visibility`) VALUES ('$post_category_name', '$post_category_active', '$post_category_visibility')";
   $query = mysql_query($sql, $conn) or die("Error : ".mysql_error());
}

function UpdateCategory($post_category_name, $post_category_active, $post_category_visibility, $post_category_id){
   $conn  = connDB();
   $sql   = "UPDATE tbl_recipes_category SET `category_name` = '$post_category_name', 
                                             `category_active`= '$post_category_active', 
											 `category_visibility` = '$post_category_visibility'
			 WHERE category_id = '$post_category_id'";
   $query = mysql_query($sql, $conn) or die("Error : ".mysql_error());
}

function deleteCategory($post_category_id){
   $conn  = connDB();
   $sql   = "DELETE FROM tbl_recipes_category WHERE `category_id` = '$post_category_id'";
   $query = mysql_query($sql, $conn) or die("Error : ".mysql_error());
}
?>

