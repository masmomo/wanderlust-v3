<?php
// get dir
function get_dirname($path){
   $current_dir = dirname($path);
   
   if($current_dir == "/" || $current_dir == "\\"){
      $current_dir = '';
   }
   
   return $current_dir;
}


function connDB($host="localhost:3306", $user="root", $pass=""){
   $conn = @mysql_pconnect($host, $user, $pass)
			     Or die ("Database Error : ".mysql_error());
   
   if($conn){
	  return $conn;
   }
   
}


function disconnect() {
   $conn = @mysql_pconnect($host, $user, $pass)
           Or die ("Database Error : ".mysql_error());
   mysql_close($conn);
}


$conn = connDB();
mysql_select_db("antikode_demo",$conn);
function admin_login($one, $two){
   $conn = connDB();
   
   $sql    = "SELECT count(*) as rows FROM tbl_admin where username = '$one' and password = MD5('admin')";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;

}
?>