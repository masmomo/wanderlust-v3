<?php
function update($post_color_name, $post_color_image, $post_color_visibility_status, $post_color_id){
   $conn   = connDB();
    
   $sql    = "UPDATE tbl_color SET `color_name` = '$post_color_name', 
                                   `color_image` = '$post_color_image', 
								   `color_visibility_status`  = '$post_color_visibility_status' 
			  WHERE `color_id` = '$post_color_id'
			 ";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
}


function delete($post_color_id){
   $conn   = connDB();
    
   $sql    = "DELETE FROM tbl_color WHERE `color_id` = '$post_color_id'";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
}
?>