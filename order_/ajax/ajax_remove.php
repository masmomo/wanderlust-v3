<?php
session_start();
$ajx_key = $_POST['key'];

unset($_SESSION['cart_type_id'][$ajx_key]);
unset($_SESSION['cart_stock_id'][$ajx_key]);
unset($_SESSION['cart_qty'][$ajx_key]);
//unset($_SESSION['voucher'][$ajx_key]);
//unset($_SESSION['amount'][$ajx_key]);
?>