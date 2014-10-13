<?php
include("../../admin/custom/static/general.php");
include("../../admin/static/general.php");

$wishlist_id = $_POST['key'];

$conn   = connDB();
   
   $sql    = "DELETE FROM tbl_wishlist WHERE `wishlist_id` = '$wishlist_id'";
   $query  = mysql_query($sql, $conn);


?>