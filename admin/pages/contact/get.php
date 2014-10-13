<?php
/*--------------------*/
/*       CONTACT      */
/*--------------------*/
/*
function get_infos(){
   $conn = connDB();
	
   $sql    = "SELECT * FROM `tbl_info`";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}
*/

function get_infos(){
   $conn = connDB();
	
   $sql    = "SELECT * FROM `tbl_infos`";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function check_info(){
   $conn = connDB();
	
   $sql    = "SELECT COUNT(*) AS rows FROM `tbl_infos` where `info_id` = '1'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}
?>