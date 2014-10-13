<?php
include("../../../static/general.php");

function get_languages(){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_language";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}


// CALL FUNCTION
$language = get_languages();


// FEEDER VARIABLE
$session_lang = $language['id_language'];


// DEFINED VARIABLE
$ajx_lang = $_POST['lang'];

if($ajx_lang == "default"){
   
}else{
   $_SESSION['lang'] = $session_lang;
}

?>

