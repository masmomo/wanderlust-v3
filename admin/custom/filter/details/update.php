<?php
function update($post_name, $post_desc, $post_image, $post_visibility, $post_filter_id){
   $conn  = connDB();
   
   $sql   = "UPDATE tbl_filter SET `filter_name` = '$post_name' ,
                                   `filter_description` = '$post_desc',
								   `image` = '$post_image',
								   `visibility` = '$post_visibility'
             WHERE `filter_id` = '$post_filter_id'
			";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}


function delete($post_filter_id){
   $conn  = connDB();
   
   $sql   = "DELETE FROM tbl_filter WHERE `filter_id` = '$post_filter_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}
?>