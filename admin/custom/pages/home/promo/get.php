<?php
/* -- PROMO -- */

include("../../../static/general.php");
include("../../../../static/general.php");

function get_promos(){
   $conn = connDB();
	
   $sql    = "SELECT * FROM `tbl_promo_banner` ORDER BY `order`";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}

function count_promos(){
   $conn = connDB();
	
   $sql    = "SELECT COUNT(*) AS rows FROM `tbl_promo_banner`";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function check_promos($post_promo_id){
   $conn = connDB();
	
   $sql    = "SELECT COUNT(*) AS rows FROM `tbl_promo_banner` WHERE `id` = '$post_promo_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function get_promo($promo_id){
   $conn = connDB();
	
   $sql    = "SELECT * FROM `tbl_promo_banner` WHERE `id` = '$promo_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function count_promo(){
   $conn = connDB();
	
   $sql    = "SELECT COUNT(*) FROM `tbl_promo_banner`";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function get_order_promo(){
   $conn = connDB();
	
   $sql    = "SELECT * FROM `tbl_promo_banner` ORDER BY `order` DESC LIMIT 1";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function promo_get_maxid(){
   $conn = connDB();
	
   $sql    = "SELECT MAX(id) AS max_id FROM `tbl_promo_banner`";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}
?>