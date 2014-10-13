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

$iteration = iterate_category('top');

$root_sales_detail=find_sales('top');


?>

