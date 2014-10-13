<?php
function insert($post_category_name, $post_active, $post_category_visibility){
   $conn  = connDB();
   
   $sql   = "INSERT INTO tbl_career_category (`category_name`, `active`, `visibility`) VALUES('$post_category_name', '$post_active', '$post_category_visibility')";
   $query = mysql_query($sql, $conn) or die(mysql_query());
}


function update($post_category_name, $post_category_visibility, $post_category_id){
   $conn  = connDB();
   
   $sql   = "UPDATE tbl_career_category SET `category_name` = '$post_category_name',
                                            `visibility`  = '$post_category_visibility'
			 WHERE `category_id` = '$post_category_id'
            ";
   $query = mysql_query($sql, $conn) or die(mysql_query());
}


function delete($post_category_id){
   $conn  = connDB();
   
   $sql   = "DELETE FROM tbl_career_category WHERE `category_id` = '$post_category_id'";
   $query = mysql_query($sql, $conn) or die(mysql_query());
}
?>