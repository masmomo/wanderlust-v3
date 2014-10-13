<?php
function insertSizeType($size_type_name, $size_type_order, $size_type_active, $size_type_visibility){
   $conn  = connDB();
   
   $sql   = "INSERT INTO tbl_size_type 
             (`size_type_name`, `size_type_order`, `size_type_active`, `size_type_visibility` ) VALUES ('$size_type_name', '$size_type_order', '$size_type_active', '$size_type_visibility')
			";
   $query = mysql_query($sql, $conn);
}


function insertSize($size_type_id, $size_name, $size_sku, $size_order){
   $conn  = connDB();
   
   $sql   = "INSERT INTO tbl_size
             (`size_type_id`, `size_name`, `size_sku`, `size_order`) VALUES ('$size_type_id', '$size_name', '$size_sku', '$size_order')
			";
   $query = mysql_query($sql, $conn);
}



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


function updateSize($size_type_id, $size_name, $size_sku){
   $conn  = connDB();
   
   $sql   = "UPDATE tbl_size SET
			 `size_name` = '$size_name', 
			 `size_sku` = '$size_sku'
			 
			 WHERE `size_type_id` = '$size_type_id', 
			";
   $query = mysql_query($sql, $conn);
}

function deleteSizeType($size_type_id){
   $conn  = connDB();
   
   $sql   = "DELETE FROM tbl_size_type WHERE `size_type_id` = '$size_type_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}

function deleteSize($size_type_id){
   $conn  = connDB();
   
   $sql   = "DELETE FROM tbl_size WHERE `size_type_id` = '$size_type_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}



// DEFINING VARIABLE
$size_type_name       = $_POST['size_type_name'];

$max_type_order       = get_latest_order();
$size_type_order      = ($max_type_order['size_type_order'] * 1 + 1);

$size_type_active     = $_POST['size_active'];
$size_type_visibility = $_POST['size_visibility'];

$size_name_array      = $_POST['size_group_name'];
$size_name            = array();
$size_name            = explode(",",$size_name_array);

$size_sku_array       = $_POST['size_sku'];
$size_sku             = array();
$size_sku             = explode(",",$size_sku_array);

function insert($size_type_name, $size_type_order, $size_type_active, $size_type_visibility, $size_sku, $size_type_id, $size_name){
   $conn = connDB();
   
   insertSizeType($size_type_name, $size_type_order, $size_type_active, $size_type_visibility);
   
   
   $max_size_type_id = get_latest_id();
   $size_type_id     = $max_size_type_id['size_type_id'];
   
   $size_order = 0;
   foreach(array_combine($size_sku, $size_name) as $size_sku => $size_name){
      $size_order++;
	  
	  insertSize($size_type_id, $size_name, $size_sku, $size_order);
   
   }
   
}


$edit_size_type_id    = $_POST['edit_size_type_id'];

$edit_size_name_array      = $_POST['size_group_name'];
$edit_size_name            = array();
$edit_size_name            = explode(",",$size_name_array);

$edit_size_sku_array       = $_POST['size_sku'];
$edit_size_sku             = array();
$edit_size_sku             = explode(",",$size_sku_array);

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

function delete($edit_size_type_id){
   $conn = connDB();
   
   deleteSizeType($edit_size_type_id);
   deleteSize($edit_size_type_id);
   
}


function update_visibility($post_size_type_visibility, $post_size_type_id){
   $conn  = connDB();
   
   $sql   = "UPDATE tbl_size_type SET `size_type_visibility` = '$post_size_type_visibility' WHERE `size_type_id` = '$post_size_type_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}
?>