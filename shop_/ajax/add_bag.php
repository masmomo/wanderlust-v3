<?php
include("../../admin/custom/static/general.php");
include("../../admin/static/general.php");


// FUNCTIONS
function get_product($post_type_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_product_type AS type_ LEFT JOIN tbl_product AS prod_ ON type_.product_id = prod_.id WHERE `type_id` = '$post_type_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function get_product_stock($post_stock_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_product_stock AS stock_ WHERE `stock_id` = '$post_stock_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


// DEFINED REQUEST
$ajx_type  = $_POST['type_id'];
$ajx_stock = $_POST['stock_id'];
$ajx_qty   = $_POST['qty'];


// CALL FUNCTION
$product = get_product($ajx_type);
$stock   = get_product_stock($ajx_stock);


// DEFINED VARIABLE
if(isset($_SESSION['cart_type_id'])){
   $key         = array_search($ajx_type, $_SESSION['cart_type_id']);
   $check_stock = array_search($ajx_stock, $_SESSION['cart_stock_id']);
}



/* -- CONTROL --*/
if(!isset($_SESSION['cart_type_id'])){
   
   $_SESSION['cart_type_id'][]  = $ajx_type;
   $_SESSION['cart_stock_id'][] = $ajx_stock;
   $_SESSION['cart_qty'][]      = $ajx_qty;
   
}else{
	
   // EXISTED
   if(is_numeric($key) and is_numeric($check_stock)){
   
      $_SESSION['cart_type_id'][$key]  = $ajx_type;
      $_SESSION['cart_stock_id'][$key] = $ajx_stock;
      $_SESSION['cart_qty'][$key]      = $_SESSION['cart_qty'][$key] + $ajx_qty;
	  
   }else{
   
      $_SESSION['cart_type_id'][]      = $ajx_type;
      $_SESSION['cart_stock_id'][]     = $ajx_stock;
      $_SESSION['cart_qty'][]          = $ajx_qty;
	  
   }
   
}

//echo "routed";

// DEFINED VARIABLE
$sess_qty = $_SESSION['cart_qty'];

foreach($sess_qty as $sess_qty){
   $total_qty += $sess_qty;
}

$total_cart = $total_qty;

echo $total_cart;
?>