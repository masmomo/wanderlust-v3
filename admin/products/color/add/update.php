<?php
function insert($post_color_name, $post_color_image, $post_order, $post_active, $post_color_visibility){
   $conn   = connDB();
    
   $sql    = "INSERT INTO tbl_color (`color_name`, `color_image`, `color_order`, `color_active_status`, `color_visibility_status`)
                              VALUES('$post_color_name', '$post_color_image', '$post_order', '$post_active', '$post_color_visibility')
			 ";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
}
?>