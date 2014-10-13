<?php
include("../../static/general.php");

$promo_item_id = $_POST['itemID'];

function remove_promo($post_promo_item_id){
   $conn  = connDB();
   
   $sql   = "DELETE FROM tbl_promo_item WHERE `promo_item_id` = '$post_promo_item_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}

if(!empty($promo_item_id)){
   remove_promo($promo_item_id);
}

?>