<?php
/*
* ----------------------------------------------------------------------
* DATABASE
* ----------------------------------------------------------------------
*/

/* --- DATABASE VARIABLE --- */
define('DB_HOST', 'localhost');                // DATABASE HOST
define('DB_NAME', 'anti_wanderlust');      // DATABASE NAME
define('DB_USER', 'root');          // DATABASE USERNAME
define('DB_PASS', '');       // DATABASE PASSWORD



/* --- CONNECT FUNCTION --- */
function connDB($host=DB_HOST, $user=DB_USER, $pass=DB_PASS){
   $conn = @mysql_pconnect($host, $user, $pass) or die (mysql_error());
   
   if($conn){
	  return $conn;
   }
   
}


/* --- DISCONNECT FUNCTION --- */
function disconnect() {
   $conn = @mysql_pconnect($host, $user, $pass) or die (mysql_error());
   mysql_close($conn);
}


/* --- CALL CONNECT FUNCTION --- */
$conn = connDB();


/* --- DATABASE NAME --- */
mysql_select_db(DB_NAME,$conn);



/*
* ----------------------------------------------------------------------
* SETTINGS
* ----------------------------------------------------------------------
*/


/* --- TIMEZONE --- */
date_default_timezone_set('Asia/Jakarta');


/* --- DISPLAY ERROR --- */
ini_set("display_errors", 0); 
?>