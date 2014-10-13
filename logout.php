<?php
session_start();

// get dir
function get_dirname($path){
   $current_dir = dirname($path);
   
   if($current_dir == "/" || $current_dir == "\\"){
      $current_dir = '';
   }

   return $current_dir;
}

unset($_SESSION['user_id']);

unset($_SESSION['cart_type_id']);
unset($_SESSION['cart_stock_id']);
unset($_SESSION['cart_qty']);
unset($_SESSION['amount_purchase']);
unset($_SESSION['amount_discount']);

header("Location: http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF']));
?>