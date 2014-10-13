<?php
function insert($post_filter_name, $post_desc, $post_image, $post_visibility){
   $conn  = connDB();
   
   $sql   = "INSERT INTO tbl_filter_sub (`filter_name`, `filter_description`, `image`, `visibility`) 
                              VALUES('$post_filter_name', '$post_desc', '$post_image', '$post_visibility')
	        ";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}
?>