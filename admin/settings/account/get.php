<?php
/*
# ----------------------------------------------------------------------
# ACCOUNTS
# ----------------------------------------------------------------------
*/


// GET ALL FROM tbl_general
function get_admin($id){
   $conn = connDB();
   
   $sql    = "SELECT * FROM tbl_admin WHERE `id` = '$id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

// INSERT / UPDATE VALIDATION
function get_admin_validation($admin_id, $post_user_name, $post_password){
   $conn = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_admin WHERE `id` = '$admin_id' AND `username` = '$post_user_name' AND `password` = MD5('$post_password')";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

// INSERT / UPDATE VALIDATION
function get_admin_password_validation($password, $admin_id){
   $conn = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_admin WHERE password = '$password' AND id = '$admin_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}
?>