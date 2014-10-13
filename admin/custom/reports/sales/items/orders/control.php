<?php
include("get.php");
include("update.php");

if ($_GET['date_start']!=null){
	$date_start = $_GET['date_start'];
}
else{
	$date_start = '0000-00-00 00:00:00';
}

if ($_GET['date_end']!=null){
	$date_end = $_GET['date_end'];
}
else{
	$date_end = '9999-01-01 23:59:59';
}

if ($date_start!=null){
	$root_sales_detail=find_total_sales($date_start,$date_end);
	$sales_orders = find_sales($date_start,$date_end);
}
else{
	$root_sales_detail=find_total_sales();
	$sales_orders = find_sales();
}
?>

