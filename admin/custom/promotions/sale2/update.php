<?php
function updateSale($post_promo_id, $post_product_type_id, $post_promo_value, $post_promo_start_time, $post_promo_end_time){
   $conn  =  connDB();
   $sql   = "INSERT INTO tbl_promo_item (`promo_id`, `product_type_id`, `promo_value`, `promo_start_datetime`, `promo_end_datetime`) 
                                  VALUES('$post_promo_id', '$post_product_type_id', '$post_promo_value', '$post_promo_start_time', '$post_promo_end_time')
			";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}

function deleteSale($post_promo_item_id){
   $conn  =  connDB();
   $sql   = "DELETE FROM tbl_promo_item WHERE `promo_item_id` = '$post_promo_item_id'";
   $query = mysql_query($sql, $conn);
}

function deleteAllSale(){
   $conn  =  connDB();
   $sql   = "DELETE FROM tbl_promo_item";
   $query = mysql_query($sql, $conn);
}
?>