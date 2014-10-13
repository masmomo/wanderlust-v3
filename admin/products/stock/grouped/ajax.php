<?php
include('../../../custom/static/general.php');
include('../../../static/general.php');

/* -- FUNCTIONS -- */
function get($post_type_id){
   $conn   = conndB();
   
   $sql    = "SELECT * FROM tbl_product_stock WHERE `type_id` = '$post_type_id'";
   $query  = mysql_query($sql, $row);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}


function count_stock($post_type_id){

   $conn   = conndB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_product_stock WHERE `type_id` = '$post_type_id'";
   $query  = mysql_query($sql, $row);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function update($post_stock_quantity, $post_stock_id){

   $conn   = conndB();
   
   $sql    = "UPDATE tbl_product_stock SET `stock_quantity` = '$post_stock_quantity' WHERE `stock_id` = '$post_stock_id'";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
}


// DEFINED VARIABLE
$ajx_type_id   = $_POST['type'];
$ajx_stock_qty = $_POST['value'];
$ajx_stock_id  = $_POST['id'];

// CALL FUNCTION

foreach($ajx_stock_id as $key=>$stock_id){
   update($ajx_stock_qty[$key], $stock_id);
}
?>