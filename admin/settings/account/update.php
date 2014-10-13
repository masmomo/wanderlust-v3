<?php
/*--------------------*/
/*      ACCOUNTS      */
/*--------------------*/

function insert_admin($role, $username, $email, $password, $level){
   $conn  = connDB();
   
   $sql   = "INSERT INTO tbl_admin (`role`, `username`, `email`, `password`, `level`) VALUES ('$role', '$username', '$email', '$password', '$level')";
   $query = mysql_query($sql, $conn);
}

function validation_old_password($password){
   $conn = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_admin WHERE `password` = MD5('$password')";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
}

function update_admin($role, $username, $email, $password, $level, $admin_id){
   $conn  = connDB();
   
   $sql   = "UPDATE tbl_admin SET `role` = '$role', 
                                  `username` = '$username', 
								  `email` = '$email', 
								  `password` = MD5('$password'), 
								  `level` = '$level'
             WHERE `id` = '$admin_id'
			 ";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}

function update_admin_half($role, $username, $email, $level, $admin_id){
   $conn  = connDB();
   
   $sql   = "UPDATE tbl_admin SET `role` = '$role', 
                                  `username` = '$username', 
								  `email` = '$email',  
								  `level` = '$level'
             WHERE `id` = '$admin_id'
			 ";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}
?>