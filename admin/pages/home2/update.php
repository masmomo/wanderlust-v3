<?php
/*--------------------*/
/*        HOME        */
/*--------------------*/

function insert_slideshow($post_banner_id, $filename, $order){
   $conn = connDB();
	
   $sql    = "INSERT INTO `tbl_slideshow` (`id`, `filename`, `order_`) VALUES ('$post_banner_id', '$filename', '$order')";
   $query  = mysql_query($sql, $conn);
}

function update_slideshow($filename, $slideshow_id){
   $conn = connDB();
	
   $sql    = "UPDATE `tbl_slideshow` SET `filename` = '$filename' WHERE `id` = '$slideshow_id'";
   $query  = mysql_query($sql, $conn);
}

function insertLinkBanner($post_banner_link, $post_banner_id){
   $conn  = connDB();
   
   $sql   = "UPDATE `tbl_slideshow` SET `link` = '$post_banner_link' WHERE `id` = '$post_banner_id'";
   $query = mysql_query($sql, $conn);
}

function update_order($order, $slideshow_id){
   $conn = connDB();
	
   $sql    = "UPDATE `tbl_slideshow` SET `order_` = '$order' WHERE `id` = '$slideshow_id'";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
}
?>