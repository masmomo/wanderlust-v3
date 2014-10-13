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

function insert_wishlist($ajx_user,$date,$ajx_type,$ajx_stock,$ajx_qty){
   $conn   = connDB();
   
   $sql    = "INSERT INTO tbl_wishlist(user_id,wishlist_date,type_id,stock_name,item_quantity)
			  VALUES ('$ajx_user','$date','$ajx_type','$ajx_stock','$ajx_qty')";
   $query  = mysql_query($sql, $conn);
   
}


// DEFINED REQUEST
$ajx_type  = $_POST['type_id'];
$ajx_stock = $_POST['stock_id'];
$ajx_qty   = $_POST['qty'];

if($_SESSION['user_id']==null){
	$_SESSION['wishlist_tmp'] = '1';
	$_SESSION['wishlist_tmp_type'] = $ajx_type;
	$_SESSION['wishlist_tmp_stock'] = $ajx_stock;
	$_SESSION['wishlist_tmp_qty'] = $ajx_qty;
	
	echo 'user_notok';
}
else{
	$date = date('Y-m-d H:i:s');
	$ajx_user = $_SESSION['user_id'];
	
	insert_wishlist($ajx_user,$date,$ajx_type,$ajx_stock,$ajx_qty);
	
	echo 'user_ok';
}


?>