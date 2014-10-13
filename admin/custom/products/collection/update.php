<?php
function insertCollection($collection_name, $collection_order, $collection_active_status, $collection_visibility_status){
   $conn  = connDB();
   
   $sql   = "INSERT INTO tbl_collection 
             (`collection_name`, `collection_order`, `collection_active_status`, `collection_visibility_status` ) VALUES ('$collection_name', '$collection_order', '$collection_active_status', '$collection_visibility_status')
			";
   $query = mysql_query($sql, $conn);
}





function updateCollection($collection_name, $collection_order, $collection_active_status, $collection_visibility_status, $collection_id){
   $conn  = connDB();
   
   $sql   = "UPDATE tbl_collection SET
             `collection_name` = '$collection_name', 
			 `collection_order` = '$collection_order', 
			 `collection_active_status` = '$collection_active_status', 
			 `collection_visibility_status` = '$collection_visibility_status' 
			 
			 WHERE `collection_id` = '$collection_id'
			";
   $query = mysql_query($sql, $conn);
}




function deleteCollection($collection_id){
   $conn  = connDB();
   
   $sql   = "DELETE FROM tbl_collection WHERE `collection_id` = '$collection_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}


// DEFINING VARIABLE
$collection_name       = $_POST['collection_name'];

$max_type_order       = get_latest_order();
$collection_order      = ($max_type_order['collection_order'] * 1 + 1);

$collection_active_status     = $_POST['collection_active_status'];
$collection_visibility_status = $_POST['collection_visibility_status'];




function insert($collection_name, $collection_order, $collection_active_status, $collection_visibility_status){
   $conn = connDB();
   
   insertCollection($collection_name, $collection_order, $collection_active_status, $collection_visibility_status);
   
   
   $max_collection_id = get_latest_id();
   $collection_id     = $max_collection_id['collection_id'];
}


$edit_collection_id    = $_POST['edit_collection_id'];



function update($collection_name, $collection_order, $collection_active_status, $collection_visibility_status,  $edit_collection_id){
   $conn = connDB();
   
   updateCollection($collection_name, $collection_order, $collection_active_status, $collection_visibility_status, $edit_collection_id);
   
}

function delete($edit_collection_id){
   $conn = connDB();
   
   deleteCollection($edit_collection_id);
   
}


function update_visibility($post_collection_visibility_status, $post_collection_id){
   $conn  = connDB();
   
   $sql   = "UPDATE tbl_collection SET `collection_visibility_status` = '$post_collection_visibility_status' WHERE `collection_id` = '$post_collection_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}

// ORDER
function update_order($post_order, $post_product_id){
   $conn = connDB();
   
   $sql    = "UPDATE tbl_collection SET `collection_order` = '$post_order' WHERE `collection_id` = '$post_product_id'";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
}
?>