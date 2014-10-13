<?php
/*--------------------*/
/*       CONTACT      */
/*--------------------*/


/* -- CONTACT -- */
function insert_contact($email, $email_display, $phone, $fax, $handphone){
   $conn = connDB();
	
   $sql    = "INSERT INTO `tbl_infos` (`email`, `email_display`, `telephone`, `fax`, `handphone`) VALUES ('$email', '$email_display', '$phone', '$fax', '$handphone')";
   $query  = mysql_query($sql, $conn);
}

function update_contact($email, $email_display, $phone, $fax, $handphone){
   $conn = connDB();
	
   $sql    = "UPDATE `tbl_infos` SET `email` = '$email', `email_display` = '$email_display', `telephone` = '$phone', `fax` = '$fax', `handphone` = '$handphone' WHERE `info_id` = '1'";
   $query  = mysql_query($sql, $conn);
}
?>