<?php
/*--------------------*/
/*        ABOUT       */
/*--------------------*/

function get_about($type){
   $conn = connDB();
	
   $sql    = "SELECT * FROM `tbl_about` WHERE `type` = '$type'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function check_about($type){
   $conn = connDB();
	
   $sql    = "SELECT COUNT(*) AS rows FROM `tbl_about` WHERE `type` = '$type'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}
?>