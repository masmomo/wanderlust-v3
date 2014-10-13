<?php
function insertType($post_size_type_name, $post_size_type_order, $post_size_type_active, $post_size_type_visibility){
   $conn   = connDB();
    
   $sql    = "INSERT INTO tbl_size_type (`size_type_name`, `size_type_order`, `size_type_active`, `size_type_visibility`)
                                  VALUES('$post_size_type_name', '$post_size_type_order', '$post_size_type_active', '$post_size_type_visibility')
			 ";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
}


function insertSize($size_type_id, $size_name, $size_sku, $size_order){
   $conn  = connDB();
   
   $sql   = "INSERT INTO tbl_size (`size_type_id`, `size_name`, `size_sku`, `size_order`) 
                           VALUES ('$size_type_id', '$size_name', '$size_sku', '$size_order')
			";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}


function insert($size_type_name, $size_type_order, $size_type_active, $size_type_visibility, $size_sku, $size_type_id, $size_name){
   $conn = connDB();
   
   insertType($size_type_name, $size_type_order, $size_type_active, $size_type_visibility);
   
   $max_size_type_id = get_latest_id();
   $size_type_id     = $max_size_type_id['size_type_id'];
   
   $size_order = 0;
   
   foreach(array_combine($size_sku, $size_name) as $size_sku => $size_name){
      $size_order++;
      insertSize($size_type_id, $size_name, $size_sku, $size_order);
   }
   
}
?>