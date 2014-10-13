<?php
function deleteCustomers($post_user_id){
   $conn  = connDB();
   
   $sql   = "DELETE FROM tbl_user WHERE `user_id` = '$post_user_id' ";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}

function deletePurchase($post_user_id){
   $conn  = connDB();
   
   $sql   = "DELETE FROM tbl_user_purchase WHERE `user_id` = '$post_user_id' ";
   $query = mysql_query($sql, $conn);
}
?>