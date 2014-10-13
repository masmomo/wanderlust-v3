<?php

/*
# ----------------------------------------------------------------------
# PAGES BANNER
# ----------------------------------------------------------------------
*/

function insert_page_banner($post_banner_id, $filename, $order){
   $conn = connDB();
	
   $sql    = "INSERT INTO `tbl_page_banner` (`banner_name`, `filename`, `order_`) VALUES ('$post_banner_id', '$filename', '$order')";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
}

function update_page_banner($filename, $slideshow_id){
   $conn = connDB();
	
   $sql    = "UPDATE `tbl_page_banner` SET `filename` = '$filename' WHERE `banner_name` = '$slideshow_id'";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
}

function insertLinkPageBanner($post_banner_link, $post_banner_id){
   $conn  = connDB();
   
   $sql   = "UPDATE `tbl_page_banner` SET `link` = '$post_banner_link' WHERE `banner_name` = '$post_banner_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}
?>