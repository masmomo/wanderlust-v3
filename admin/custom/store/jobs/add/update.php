<?php
function insert($post_career_name, $post_category, $post_active, $post_category_visibility, $post_description, $post_category_map){
   $conn  = connDB();
   
   $sql   = "INSERT INTO tbl_store (`career_name`, `category`, `active`, `visibility`, `description`, `category_maps`) 
                              VALUES('$post_career_name', '$post_category', '$post_active', '$post_category_visibility', '$post_description', '$post_category_map')";
   $query = mysql_query($sql, $conn) or die(mysql_query());
}


function update($post_career_name, $post_category, $post_category_visibility, $post_description, $post_career_id){
   $conn  = connDB();
   
   $sql   = "UPDATE tbl_store SET `career_name` = 'post_career_name',
								   `category`    = '$post_category',
								   `visibility`  = '$post_category_visibility',
								   `description` = 'post_description'
			 WHERE `career_id` = '$post_career_id'
            ";
   $query = mysql_query($sql, $conn) or die(mysql_query());
}


function delete($post_career_id){
   $conn  = connDB();
   
   $sql   = "DELETE FROM tbl_store WHERE `career_id` = '$post_career_id'";
   $query = mysql_query($sql, $conn) or die(mysql_query());
}
?>