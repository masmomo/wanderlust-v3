<?php
	include('../../custom/static/general.php');
	include('../../static/general.php');
	
	$product_alias = $_POST["product_alias"];
	$product_id = $_POST["product_id"];
	
	$conn = connDB();
	$check = mysql_query("SELECT * from tbl_product WHERE product_alias='$product_alias'" AND id != '$product_id',$conn);
	

	if (mysql_num_rows($check)!=null){
		echo 'existed';
	}
	else{
		echo 'ok';
	}
?>