<?php
include("../../admin/custom/static/general.php");
include("../../admin/static/general.php");

$ajx_filter  = $_POST['filter_id'];

if ($_SESSION['filters']==''){
	$_SESSION['filters'] = array();
}

$key         = array_search($ajx_filter, $_SESSION['filters']);

if ($key!==FALSE){
	unset($_SESSION['filters'][$key]);
}
else{
	array_push($_SESSION['filters'],$ajx_filter);
}

//print_r($_SESSION["filters"]);

echo 'success';
?>