<?php
/*
# ----------------------------------------------------------------------
# AJAX STOCK
# ----------------------------------------------------------------------
*/


/*
# ----------------------------------------------------------------------
# INCLUDING GENERAL
# ----------------------------------------------------------------------
*/

include("../../admin/custom/static/general.php");
include("../../admin/static/general.php");



/*
# ----------------------------------------------------------------------
# FUNCTIONS
# ----------------------------------------------------------------------
*/

function count_stock($stock_id){
   $conn   = connDB();
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_product_stock WHERE `stock_id`= '$stock_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function get_stock($stock_id){
   $conn   = connDB();
   $sql    = "SELECT * FROM tbl_product_stock WHERE `stock_id`= '$stock_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}



/*
# ----------------------------------------------------------------------
# DEFINED VARIABLE
# ----------------------------------------------------------------------
*/

$stock_id = $_POST['ajax_stock_id'];



/*
# ----------------------------------------------------------------------
# CALL FUNCTIONS
# ----------------------------------------------------------------------
*/

$count_stock = count_stock($stock_id);
$data_stock  = get_stock($stock_id);



/*
# ----------------------------------------------------------------------
# CONTROL
# ----------------------------------------------------------------------
*/

if($count_stock['rows'] > 0){
   
   $stock_qty = $data_stock['stock_quantity'];
   
   if($stock_qty > 9){
      $stock_qty = 9;
   }else{
      $stock_qty = $stock_qty;
   }
   
   
   for($i=1;$i<=$stock_qty;$i++){
      echo '<option value="'.$i.'">'.$i.'</option>';;
   }
   
}
?>