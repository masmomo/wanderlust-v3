<?php
/*--------------------*/
/*        ABOUT       */
/*--------------------*/


/* -- CONACT -- */
function insert_about($fill, $type){
   $conn = connDB();
	
   $sql    = "INSERT INTO `tbl_about` (`fill`, `type`) VALUES ('$fill', '$type')";
   $query  = mysql_query($sql, $conn);
}

function update_about($fill, $type){
   $conn = connDB();
	
   $sql    = "UPDATE `tbl_about` SET `fill` = '$fill' WHERE `type` = '$type'";
   $query  = mysql_query($sql, $conn);
}

function aboutInsert($fill, $type){
   $conn = connDB();
   
   insert_about($fill, $type);
}
?>