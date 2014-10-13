<?php
function updateCollection($collection_name, $collection_active_status, $collection_visibility_status, $collection_id){
   $conn  = connDB();
   
   $sql   = "UPDATE tbl_collection SET
             `collection_name` = '$collection_name', 
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



function update($collection_name, $collection_active_status, $collection_visibility_status, $edit_collection_id){
   $conn = connDB();
   
   updateCollection($collection_name, $collection_active_status, $collection_visibility_status, $edit_collection_id);
}
?>