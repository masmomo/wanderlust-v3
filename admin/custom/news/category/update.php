<?php
function insert_category($category_name, $category_active, $category_visibility){
   $conn = connDB();
   
   $sql   = "INSERT INTO tbl_news_category (`category_name`, `category_active`, `category_visibility`) VALUES ('$category_name', '$category_active', '$category_visibility')";
   $query = mysql_query($sql, $conn);
}


function update_category($category_name, $category_active, $category_visibility, $category_id){
   $conn = connDB();
   
   $sql   = "UPDATE tbl_news_category SET `category_name` = '$category_name', `category_active` = '$category_active', `category_visibility` = '$category_visibility' WHERE `category_id` = '$category_id'";
   $query = mysql_query($sql, $conn);
}


function delete_category($category_id){
   $conn = connDB();
   
   $sql   = "DELETE FROM tbl_news_category WHERE `category_id` = '$category_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}

function update_visibility($category_visibility, $category_id){
   $conn = connDB();
   
   $sql   = "UPDATE tbl_news_category SET `category_visibility` = '$category_visibility' WHERE `category_id` = '$category_id'";
   $query = mysql_query($sql, $conn);
}
?>