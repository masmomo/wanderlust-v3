<?php
/* -- PROMO -- */
function insert_promo($promo_id, $filename, $link, $order, $flag){
   $conn = connDB();
	
   $sql    = "INSERT INTO `tbl_promo_banner` (`id`, `filename`, `link`, `order`, `flag`) VALUES('$promo_id', '$filename', '$link', '$order', '$flag')";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
}

function update_promo($filename, $link, $order, $flag, $promo_id){
   $conn = connDB();
	
   $sql    = "UPDATE `tbl_promo_banner` SET `filename` = '$filename', `link` = '$link', `order` = '$order', `flag` = '$flag' WHERE `id` = '$promo_id'";
   $query  = mysql_query($sql, $conn);
}

function update_promo_link($link, $post_name, $promo_id){
   $conn = connDB();
	
   $sql    = "UPDATE `tbl_promo_banner` SET `link` = '$link', `name` = '$post_name' WHERE `id` = '$promo_id'";
   $query  = mysql_query($sql, $conn);
}

function update_order_promo($order, $promo_id){
   $conn = connDB();
	
   $sql    = "UPDATE `tbl_promo_banner` SET `order` = '$order' WHERE `id` = '$promo_id'";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
}

function delete_order_promo($promo_id){
   $conn = connDB();
	
   $sql    = "DELETE FROM `tbl_promo_banner` WHERE `id` = '$promo_id'";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
}
?>