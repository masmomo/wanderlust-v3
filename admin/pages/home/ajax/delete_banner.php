<?php
include("../../../custom/static/general.php");
include("../../../static/general.php");

// FUNCTIONS
function delete_banner($post_banner_id){
   $conn  = connDB();
   
   echo $sql   = "DELETE FROM tbl_slideshow WHERE `id` = '$post_banner_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}

function get_banner($post_banner_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_slideshow WHERE `id` = '$post_banner_id'";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
   $result = mysql_fetch_array($query);
   
   return $result;
}


// DATA FEEDER
$ajx_id = $_POST['bid'];
$banner_file = get_banner($ajx_id);


unlink("../../../../".$banner_file['filename']);


// CONTROL
delete_banner($ajx_id);

//echo $ajx_id;

?>