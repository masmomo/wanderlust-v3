<?php
include("../../../static/general.php");
include("../../../../static/general.php");

// DEFINED VARIABLE
$ajx_id = $_POST['bid'];

function get_inspiration($post_ins_id){
   $conn = connDB();
   
   $sql    = "SELECT * FROM tbl_inspiration_image WHERE `inspiration_image_id` = '$post_ins_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function delete_inspiration($post_ins_id){
   $conn = connDB();
   
   $sql    = "DELETE FROM tbl_inspiration_image WHERE `inspiration_image_id` = '$post_ins_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


// CALL FUNCTION
$get_inspiration = get_inspiration($ajx_id);

if(!empty($ajx_id)){
   unlink("../../../../../".$get_inspiration['image']);
   
   delete_inspiration($ajx_id);
}
?>