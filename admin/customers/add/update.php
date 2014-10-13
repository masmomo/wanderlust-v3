<?php
function update_all($one, $two, $phone,  $three, $four, $five, $six, $seven, $eight, $nine, $ten, $post_user_created_date, $post_user_alias){
   $conn  = connDB();
   
   $sql   = "INSERT INTO tbl_user 
             (`user_first_name`, `user_last_name`, `user_phone`, `user_email`, `user_password`, `user_address`, `user_city`, `user_province`, `user_country`, `user_postal_code`, `user_status`, `user_fullname`, `user_created_date`, `user_alias`) 
			 VALUES 
			 ('$one', '$two', '$phone', '$three', MD5('$four'), '$five', '$six', '$seven', '$eight', '$nine', 'normal', '$ten', '$post_user_created_date', '$post_user_alias')";
   $query = mysql_query($sql, $conn); //or die("Query failed : ".mysql_error());
}
?>