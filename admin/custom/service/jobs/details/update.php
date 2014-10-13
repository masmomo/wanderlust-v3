<?php
function update($post_name, $post_category, $post_description, $post_category_maps, $post_visibility, $post_career_id){
   $conn  = connDB();
   
   $sql   = "UPDATE tbl_service SET `career_name` = '$post_name',
                                   `category` = '$post_category',
                                   `description` = '$post_description',
								  `category_maps` = '$post_category_maps',
                                   `visibility` = '$post_visibility'
			 WHERE `career_id` = '$post_career_id'
            ";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}


function delete($post_career_id){
   $conn  = connDB();
   
   $sql   = "DELETE FROM tbl_service WHERE `career_id` = '$post_career_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}
?>