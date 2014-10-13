<?php
function insert_inspiration($post_name, $post_description, $post_date_created, $post_active, $post_visibility){
   $conn  = connDB();
   
   $sql   = "INSERT INTO tbl_inspiration (`name`, `description`, `date_created`, `active`, `visibility`)
                                   VALUES('$post_name', '$post_description', '$post_date_created', '$post_active', '$post_visibility')
			";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}


function update_inspiration($post_name, $post_category, $post_inspiration_id){
   $conn  = connDB();
   
   $sql   = "UPDATE tbl_inspiration SET `name` = '$post_name', `category` = '$post_category' WHERE `inspiration_id` = '$post_inspiration_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}




/* INSPIRATION IMAGE */

function check_image($post_image_id){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_inspiration_image WHERE `inspiration_image_id` = '$post_image_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function insert_inspiration_image($post_param_inspiration_id, $post_image, $post_active, $post_visibility){
   $conn  = connDB();
   
   $sql   = "INSERT INTO tbl_inspiration_image (`param_inspiration_id`, `image`, `active`, `visibility`)
                                         VALUES('$post_param_inspiration_id', '$post_image', '$post_active', '$post_visibility')
			";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}


function update_inspiration_image($post_image, $post_image_id){

   $conn  = connDB();
   
   $sql   = "UPDATE tbl_inspiration_image SET `image` = '$post_image' WHERE `inspiration_image_id` = '$post_image_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}

function update_order($order, $post_image_id){
   $conn = connDB();
	
   $sql    = "UPDATE `tbl_inspiration_image` SET `order` = '$order' WHERE `inspiration_image_id` = '$post_image_id'";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
}



/* INSPIRATION FEATURED */

function check_featured($post_feat_id){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_inspiration_featured WHERE `inspiration_featured_id` = '$post_feat_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function insert_inspiration_featured($post_param_inspiration_id, $post_product_type_id, $post_active, $post_visibility){
   $conn  = connDB();
   
   $sql   = "INSERT INTO tbl_inspiration_featured (`param_inspiration_id`, `product_type_id`, `active`, `visibility`)
                                            VALUES('$post_param_inspiration_id', '$post_product_type_id', '$post_active', '$post_visibility')
			";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}


function update_inspiration_featured($post_type_id, $post_feat_id){

   $conn  = connDB();
   
   $sql   = "UPDATE tbl_inspiration_featured SET `product_type_id` = '$post_type_id' WHERE `inspiration_featured_id` = '$post_feat_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}


function delete_inspiration_featured($post_inspiration_id){

   $conn  = connDB();
   
   $sql   = "DELETE FROM tbl_inspiration_featured WHERE `param_inspiration_id` = '$post_inspiration_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}
?>