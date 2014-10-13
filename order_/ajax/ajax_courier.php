<?php
include("../../admin/custom/static/general.php");
include("../../admin/static/general.php");


// FUNCTIONS
function get_rate($post_courier_city){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_courier_rate WHERE `courier_city` = '$post_courier_city' AND `courier_rate` != '0' ORDER BY courier_rate_id";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}


function get_courier($post_courier_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_courier WHERE `courier_id` = '$post_courier_id' ORDER BY courier_id";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function get_cart($post_type_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_product_type WHERE `type_id` = '$post_type_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


// DEFINED VARIABLE

$ajx_city     = $_POST['city'];
$session_type = $_SESSION['cart_type_id'];
$session_qty  = $_SESSION['cart_qty'];


// CALL FUNCTION

$courier = get_rate($ajx_city);


foreach($session_type as $key=>$type){
   $weight = get_cart($type);
   
   $total += $weight['type_weight'] * $_SESSION['cart_qty'][$key];
   $total_weight = $total;
}



//$total_weights = ceil($total_weight / $courier['courier_weight'])*$courier['courier_rate'];


// DATA

echo "<select class=\"form-control\" id=\"id_checkout_user_shipping\" onChange=\"setRate()\"> \n";
//echo "<option></option>";
foreach($courier as $courier){
   $name       = get_courier($courier['courier_name']);
   $ship_price = ceil($total_weight/$courier['courier_weight']);
   $ship_price = $ship_price * $courier['courier_rate'];
   echo "<option value=\"".$courier['courier_rate_id']."\" rate=\"".$ship_price."\">".$name['courier_name']." - ".price($ship_price)."</option> \n";
}
echo "</select>";
?>