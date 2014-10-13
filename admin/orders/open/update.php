<?php
/*
# ----------------------------------------------------------------------
# UPDATE FOR OPEN ORDER PAGE
# ----------------------------------------------------------------------
*/

function update_open_order($order_id, $column, $value){
   $conn  = connDB();
   $sql   = "UPDATE tbl_order SET `$column` = '$value' WHERE `order_id` = '$order_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}

function update_quantity($stock_id, $column, $value){
   $conn  = connDB();
   $sql   = "UPDATE tbl_product_stock SET `$column` = '$value' WHERE `stock_id` = '$stock_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());

}

function delete_open_order($order_id, $column, $value){
   $conn  = connDB();
   $sql   = "DELETE FROM tbl_order WHERE `order_id` = '$order_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}


function delete_user_purchase($post_order_id){
   $conn  = connDB();
   
   $sql   = "DELETE FROM tbl_user_purchase WHERE `order_id` = '$post_order_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}


function delete_order_item($post_order_id){
   $conn  = connDB();
   
   $sql   = "DELETE FROM tbl_order_item WHERE `order_id` = '$post_order_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}

?>