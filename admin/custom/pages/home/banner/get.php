<?php

/*
# ----------------------------------------------------------------------
# PAGES BANNER
# ----------------------------------------------------------------------
*/

function count_page_banner(){
   $conn = connDB();
	
   $sql    = "SELECT COUNT(*) AS rows FROM `tbl_page_banner`";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function count_page_banner_page($id){
   $conn = connDB();
	
   $sql    = "SELECT COUNT(*) AS rows FROM `tbl_page_banner` WHERE `banner_name` = '$id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function get_page_banner(){
   $conn = connDB();
	
   $sql    = "SELECT * FROM `tbl_page_banner` ORDER BY `id`";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}
?>