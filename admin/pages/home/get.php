<?php
/*--------------------*/
/*        HOME        */
/*--------------------*/

function get_slideshows(){
   $conn = connDB();
	
   $sql    = "SELECT * FROM `tbl_slideshow` ORDER BY `order_`";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}

function get_slideshow($slideshow_id){
   $conn = connDB();
	
   $sql    = "SELECT * FROM `tbl_slideshow` WHERE `id` = '$slideshow_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function count_slideshow(){
   $conn = connDB();
	
   $sql    = "SELECT COUNT(*) AS rows FROM `tbl_slideshow`";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function get_order_slideshow(){
   $conn = connDB();
	
   $sql    = "SELECT * FROM `tbl_slideshow` ORDER BY `order_` DESC LIMIT 1";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

// VALIDATE
function validate_slideshow($slideshow_id){
   $conn = connDB();
	
   $sql    = "SELECT COUNT(*) AS rows FROM `tbl_slideshow` WHERE `id` = '$slideshow_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


// MAX ID
function get_new_id(){
   $conn = connDB();
	
   $sql    = "SELECT MAX(id) AS new_id FROM `tbl_slideshow`";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function slideshow_get(){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_slideshow ORDER BY `order_` ASC";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
					 
   return $row;
}
?>