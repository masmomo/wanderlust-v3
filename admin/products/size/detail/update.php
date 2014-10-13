<?php
function updateSizeType($size_type_name, $size_type_order, $size_type_active, $size_type_visibility, $size_type_id){
   $conn  = connDB();
   
   $sql   = "UPDATE tbl_size_type SET
             `size_type_name` = '$size_type_name', 
			 `size_type_order` = '$size_type_order', 
			 `size_type_active` = '$size_type_active', 
			 `size_type_visibility` = '$size_type_visibility' 
			 
			 WHERE `size_type_id` = '$size_type_id'
			";
   $query = mysql_query($sql, $conn);
}


function deleteSize($size_type_id){
   $conn  = connDB();
   
   $sql   = "DELETE FROM tbl_size WHERE `size_type_id` = '$size_type_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}


function deleteSizeType($size_type_id){
   $conn  = connDB();
   
   $sql   = "DELETE FROM tbl_size_type WHERE `size_type_id` = '$size_type_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}


function insertSize($size_type_id, $size_name, $size_sku, $size_order){
   $conn  = connDB();
   
   $sql   = "INSERT INTO tbl_size
             (`size_type_id`, `size_name`, `size_sku`, `size_order`) VALUES ('$size_type_id', '$size_name', '$size_sku', '$size_order')
			";
   $query = mysql_query($sql, $conn);
}


function update($size_type_name, $size_type_order, $size_type_active, $size_type_visibility, $edit_size_sku, $edit_size_type_id, $edit_size_name){
   $conn = connDB();
   
   updateSizeType($size_type_name, $size_type_order, $size_type_active, $size_type_visibility, $edit_size_type_id);
   deleteSize($edit_size_type_id);
   
   $size_order = 0;
   foreach(array_combine($edit_size_sku, $edit_size_name) as $edit_size_sku => $edit_size_name){
      $size_order++;
	  
	  insertSize($edit_size_type_id, $edit_size_name, $edit_size_sku, $size_order);
   
   }
   
}
?>