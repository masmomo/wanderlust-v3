<?php
function updateSale($post_filter_id, $post_product_id){
   $conn  =  connDB();
   $sql   = "INSERT INTO tbl_filter_sub_item (`filter_id`, `product_id`) 
                                       VALUES('$post_filter_id', '$post_product_id')
			";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}

function deleteSale($post_sub_id){
   $conn  =  connDB();
   $sql   = "DELETE FROM tbl_filter_sub_item WHERE `sub_id` = '$post_sub_id'";
   $query = mysql_query($sql, $conn);
}

function deleteAllSale(){
   $conn  =  connDB();
   $sql   = "DELETE FROM tbl_filter_sub_item";
   $query = mysql_query($sql, $conn);
}
?>