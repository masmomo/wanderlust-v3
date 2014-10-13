<?php
function insert_inspiration($post_name, $post_description, $post_date_created, $post_active, $post_visibility){
   $conn  = connDB();
   
   $sql   = "INSERT INTO tbl_inspiration (`name`, `description`, `date_created`, `active`, `visibility`)
                                   VALUES('$post_name', '$post_description', '$post_date_created', '$post_active', '$post_visibility')
			";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}


function edit_inspiration($post_name, $post_description, $post_date_created, $post_active, $post_visibility, $post_inspiration_id){
   $conn  = connDB();
   
   $sql   = "UPDATE tbl_inspiration SET `name` = '$post_name',
                                        `description` = '$post_description',
										`active` = '$post_active',
										`visibility` = '$post_visibility'
             WHERE `inspiration_id` = '$post_inspiration_id'
			";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}


function update_inspirations($post_visibility, $post_inspiration_id){
   $conn  = connDB();
   
   $sql   = "UPDATE tbl_inspiration SET `inspiration_visibility` = '$post_visibility' WHERE `inspiration_id` = '$post_inspiration_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}


function delete_inspiration($post_inspiration_id){
   $conn  = connDB();
   
   $sql   = "DELETE FROM tbl_inspiration WHERE `inspiration_id` = '$post_inspiration_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}



/* INSPIRATION IMAGE */

function insert_inspiration_image($post_param_inspiration_id, $post_image, $post_active, $post_visibility){
   $conn  = connDB();
   
   $sql   = "INSERT INTO tbl_inspiration_image (`param_inspiration_id`, `image`, `active`, `visibility`)
                                         VALUES('$post_param_inspiration_id', '$post_image', '$post_active', '$post_visibility')
			";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}


function edit_inspiration_image($post_param_inspiration_id, $post_image, $post_active, $post_visibility, $post_inspiration_image_id){
   $conn  = connDB();
   
   $sql   = "UPDATE tbl_inspiration_image SET `param_inspiration_id` = '$post_param_inspiration_id',
                                              `image` = '$post_image',
											  `active` = '$post_active',
											  `visibility` = '$post_visibility'
             WHERE `inspiration_id` = '$post_inspiration_image_id'
			";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}


function delete_inspiration_image($post_inspiration_id){
   $conn  = connDB();
   
   $sql   = "DELETE FROM tbl_inspiration_image WHERE `param_inspiration_id` = '$post_inspiration_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}


/* INSPIRATION FETURED */

function insert_inspiration_featured($post_param_inspiration_id, $post_product_type_id, $post_active, $post_visibility){
   $conn  = connDB();
   
   $sql   = "INSERT INTO tbl_inspiration_featured (`param_inspiration_id`, `product_type_id`, `active`, `visibility`)
                                            VALUES('$post_param_inspiration_id', '$post_product_type_id', '$post_active', '$post_visibility')
			";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}


function edit_inspiration_featured($post_param_inspiration_id, $post_product_type_id, $post_active, $post_visibility, $post_inspiration_featured_id){
   $conn  = connDB();
   
   $sql   = "UPDATE tbl_inspiration_featured SET `param_inspiration_id` = '$post_param_inspiration_id',
                                                 `product_type_id` = '$post_product_type_id',
												 `active` = '$post_active',
												 `visibility` = '$post_visibility'
             WHERE `inspiration_id` = '$post_inspiration_featured_id'
			";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}


function delete_inspiration_featured($post_inspiration_id){
   $conn  = connDB();
   
   $sql   = "DELETE FROM tbl_inspiration_featured WHERE `param_inspiration_id` = '$post_inspiration_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}
?>