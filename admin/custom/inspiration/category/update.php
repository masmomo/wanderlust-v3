<?php
function insert_category($post_category_name, $post_category_desc, $post_visibility, $post_order){
   $conn = connDB();
   
   $sql   = "INSERT INTO tbl_inspiration_category (`name`, `description`, `visibility`, `order`) 
                                           VALUES ('$post_category_name', '$post_category_desc', '$post_visibility', '$post_order')
			";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}


function update_category($category_name, $category_active, $category_visibility, $category_id){
   $conn = connDB();
   
   $sql   = "UPDATE tbl_inspiration_category SET `name` = '$category_name', 
                                                 `description` = '$category_active', 
												 `visibility` = '$category_visibility' ,
												 `order` = '$category_visibility' 
             WHERE `category_id` = '$category_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}


function delete_category($category_id){
   $conn = connDB();
   
   $sql   = "DELETE FROM tbl_inspiration_category WHERE `category_id` = '$category_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}


function update_category_visibility($category_visibility, $category_id){
   $conn = connDB();
   
   $sql   = "UPDATE tbl_inspiration_category SET `visibility` = '$category_visibility' WHERE `category_id` = '$category_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}
?>