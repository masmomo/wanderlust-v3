<?php
function insert_notification($post_id, $post_order, $post_warehouse){
   $conn   = connDB();
   
   $sql    = "INSERT INTO tbl_notification (`notification_id`, `email_order`, `email_warehouse`) VALUES('$post_id', '$post_order', '$post_warehouse')";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
}


function update_notification($post_id, $post_order, $post_warehouse){
   $conn   = connDB();
   
   $sql    = "UPDATE tbl_notification SET `email_order` = '$post_order',
                                         `email_warehouse` = '$post_warehouse'
              WHERE `notification_id` = '$post_id'
			 ";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
}
?>