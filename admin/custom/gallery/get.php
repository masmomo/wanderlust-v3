<?php
/*--------------------*/
/*      GALLERY       */
/*--------------------*/

function get_galleries(){
   $conn = connDB();
	
   $sql    = "SELECT * FROM `tbl_gallery`";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}

function get_gallery($gallery_id){
   $conn = connDB();
	
   $sql    = "SELECT * FROM `tbl_gallery` WHERE `id` = '$gallery_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function count_gallery(){
   $conn = connDB();
	
   $sql    = "SELECT COUNT(*) AS rows FROM `tbl_gallery`";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function get_order_gallery(){
   $conn = connDB();
	
   $sql    = "SELECT * FROM `tbl_gallery` ORDER BY `order` DESC LIMIT 1";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}
?>