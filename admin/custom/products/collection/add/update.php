<?php
function insertType($post_collection_name, $post_collection_order, $post_collection_active_status, $post_collection_visibility_status){
   $conn   = connDB();
    
   $sql    = "INSERT INTO tbl_collection (`collection_name`, `collection_order`, `collection_active_status`, `collection_visibility_status`)
                                  VALUES('$post_collection_name', '$post_collection_order', '$post_collection_active_status', '$post_collection_visibility_status')
			 ";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
}




function insert($collection_name, $collection_order, $collection_active_status, $collection_visibility_status){
   $conn = connDB();
   
   insertType($collection_name, $collection_order, $collection_active_status, $collection_visibility_status);
   
   $max_collection_id = get_latest_id();
   $collection_id     = $max_collection_id['collection_id'];
   
   
   
}
?>