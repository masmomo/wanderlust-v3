<?php
// DELETE CUSTOMER
function delete_user($one){
   $conn = connDB();
   
   $sql    = "DELETE FROM `tbl_user` WHERE `user_id` = '$one'";
   $query  = mysql_query($sql, $conn);
}



/* -- EDIT CUSTOMER -- */
function edit_customer($post_user_first_name, $post_last_name, $name, $status, $post_user_email, $post_user_phone, $address, $city, $province, $country, $postal_code, $post_alias, $uid){
   $conn = connDB();
   
   $sql   = "UPDATE tbl_user
             SET 
			 `user_first_name` = '$post_user_first_name',
			 `user_last_name` = '$post_last_name',
			 `user_fullname` = '$name', 
			 `user_status` = '$status',
			 `user_email` = '$post_user_email',
			 `user_phone` = '$post_user_phone', 
			 `user_address` = '$address', 
			 `user_city` = '$city', 
			 `user_province` = '$province', 
			 `user_country` = '$country', 
			 `user_postal_code` = '$postal_code',
			 `user_alias` = '$post_alias'
			 WHERE user_id = '$uid'";
   $query = mysql_query($sql, $conn) or die("Query Failed ".mysql_error());
}
?>