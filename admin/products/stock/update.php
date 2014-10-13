<?php
function yeast($one, $two){
   $conn  = connDB();
   
   $sql   = "UPDATE tbl_product_stock SET stock_quantity = '$one' WHERE `stock_id` =  '$two'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}


function delete_stock($post_type_id){
   $conn  = connDB();
   
   $sql   = "DELETE FROM tbl_product_stock WHERE `stock_id` = '$post_type_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}

function delete_type($post_type_id){
   $conn  = connDB();
   
   $sql   = "UPDATE tbl_product_type SET `type_delete` = '1' WHERE `type_id` = '$post_type_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}
?>