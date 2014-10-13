<?php
/*--------------------*/
/*        ABOUT       */
/*--------------------*/


/* -- CONACT -- */
function insert_about($fill, $post_id_param, $type, $post_lang){
   $conn = connDB();
	
   $sql    = "INSERT INTO `tbl_about_lang` (`fill`, `id_param`, `type`, `language_code`) VALUES ('$fill', '$type', '$post_id_param', '$post_lang')";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
}

function update_about($fill, $type, $post_lang){
   $conn = connDB();
	
   $sql    = "UPDATE `tbl_about_lang` SET `fill` = '$fill' WHERE `type` = '$type' AND `language_code` = '$post_lang'";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
}

function aboutInsert($fill, $type){
   $conn = connDB();
   
   insert_about($fill, $type);
}
?>