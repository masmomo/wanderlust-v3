<?php
function insert(){
   $conn  = connDB();
   
   $sql   = "INSERT INTO  tbl_store_category (`category_name`, `visibility`) VALUES('$post_category_name', '$post_category_visibility')";
   $query = mysql_query($sql, $conn) or die(mysql_query());
}


function update(){
   $conn  = connDB();
   
   $sql   = "UPDATE  tbl_store_category SET `category_name` = 'post_category_name',
                                            `visibility`  = '$post_category_visibility'
			 WHERE `category_id` = '$post_category_id'
            ";
   $query = mysql_query($sql, $conn) or die(mysql_query());
}


function delete($category_id){
   $conn = connDB();
   
   $sql   = "DELETE FROM  tbl_store_category WHERE `category_id` = '$category_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}


function update_visibility($post_visibility, $category_id){
   $conn = connDB();
   
   $sql   = "UPDATE  tbl_store_category SET `visibility` = '$post_visibility' WHERE `category_id` = '$category_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}
?>