<?php
/*
--------------------------------------------------------------------------------
function connDB($host="localhost:3306", $user="['username']", $pass="['password']"){
   $conn = @mysql_pconnect($host, $user, $pass) or die (mysql_error());
   
   if($conn){
	  return $conn;
   }
   
}      
--------------------------------------------------------------------------------
*/
function connDB($host="localhost:3306", $user="root", $pass=""){
   $conn = @mysql_pconnect($host, $user, $pass) or die (mysql_error());
   
   if($conn){
	  return $conn;
   }
   
}

$conn = connDB();

/*
--------------------------------------------------------------------------------
mysql_select_db("[database_name]",$conn);     
--------------------------------------------------------------------------------
*/
mysql_select_db("anti_demo",$conn);


// FUNCTIONS
function promo_get_banner($post_banner_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_promo_banner WHERE `id` = '$post_banner_id'";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
   $result = mysql_fetch_array($query);
   
   return $result;
}

function delete_banner($post_banner_id){
   $conn  = connDB();
   $sql   = "DELETE FROM tbl_promo_banner WHERE `id` = '$post_banner_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}


// DATA FEEDER
$ajx_id = $_POST['pid'];


// CONTROL
$file_banner = promo_get_banner($ajx_id);

unlink("../../../../../../".$file_banner['filename']);

delete_banner($ajx_id);
?>