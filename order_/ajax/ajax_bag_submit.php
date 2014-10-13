<?php
include("../../admin/custom/static/general.php");
include("../../admin/static/general.php");

$_SESSION['order_amount']   = $_POST['subtotal'];

echo 'success';

?>