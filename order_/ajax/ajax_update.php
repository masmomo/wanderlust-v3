<?php
include("../../admin/custom/static/general.php");
include("../../admin/static/general.php");

function get_stock($post_stock_id){
  $conn   = connDB();
  
  $sql    = "SELECT * FROM tbl_product_stock WHERE `stock_id` = '$post_stock_id'";
  $query  = mysql_query($sql, $conn);
  $result = mysql_fetch_array($query);
  
  return $result;
}

// DEFINED VARIABLE
$ajx_key   = $_POST['key'];
$ajx_qty   = $_POST['qty'];
$ajx_stock = $_POST['stock'];

// CALL FUNCTION
$check = get_stock($ajx_stock);

if($check['stock_quantity'] >= $ajx_qty){
  $_SESSION['cart_qty'][$ajx_key] = $ajx_qty;
  
  $return = $_SESSION['cart_qty'][$ajx_key];
}else{
  $return = "Quantity available is ".$check['stock_quantity'].", you tried to add ".$ajx_qty.".";
}

echo $return;

?>