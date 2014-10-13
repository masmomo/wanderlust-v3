<?php
function insert_inspiration($post_name, $post_description, $post_date_created, $post_active, $post_visibility, $post_category){
   $conn  = connDB();
   
   $sql   = "INSERT INTO tbl_inspiration (`name`, `description`, `date_created`, `active`, `inspiration_visibility`, `category`)
                                   VALUES('$post_name', '$post_description', '$post_date_created', '$post_active', '$post_visibility', '$post_category')
			";
   $query = mysql_query($sql, $conn);
}



/* INSPIRATION IMAGE */

function insert_inspiration_image($post_param_inspiration_id, $post_image, $post_order, $post_active, $post_visibility){
   $conn  = connDB();
   
   $sql   = "INSERT INTO tbl_inspiration_image (`param_inspiration_id`, `image`, `order`, `active`, `visibility`)
                                         VALUES('$post_param_inspiration_id', '$post_image', '$post_order', '$post_active', '$post_visibility')
			";
   $query = mysql_query($sql, $conn);
}



/* INSPIRATION FEATURED */

function insert_inspiration_featured($post_param_inspiration_id, $post_product_type_id, $post_active, $post_visibility){
   $conn  = connDB();
   
   $sql   = "INSERT INTO tbl_inspiration_featured (`param_inspiration_id`, `product_type_id`, `active`, `visibility`)
                                            VALUES('$post_param_inspiration_id', '$post_product_type_id', '$post_active', '$post_visibility')
			";
   $query = mysql_query($sql, $conn);
}
?>