<?php
/*--------------------*/
/*      GALLERY       */
/*--------------------*/


/* -- GALLERY -- */
function insert_gallery($filename, $link, $order, $flag){
   $conn = connDB();
	
   $sql    = "INSERT INTO `tbl_gallery` (`filename`, `link`, `order`, `flag`) VALUES ('$filename', '$link', '$order', '$flag')";
   $query  = mysql_query($sql, $conn);
}

function update_gallery($filename, $link, $order, $flag, $gallery_id){
   $conn = connDB();
	
   $sql    = "UPDATE `tbl_gallery` SET `filename` = '$filename', `link` = '$link', `order` = '$order', `flag` = '$flag' WHERE `id` = '$gallery_id'";
   $query  = mysql_query($sql, $conn);
}
?>