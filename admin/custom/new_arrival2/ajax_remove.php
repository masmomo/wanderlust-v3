<?php
include("../../custom/static/general.php");
include("../../static/general.php");

$item_id = $_POST['itemID'];

function get_type_id($post_product_id){
   $conn   = connDB();
    
   $sql    = "SELECT * FROM tbl_product_type WHERE `product_id` = '$post_product_id'";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
	  array_push($row, $result);
   }
   
   return $row;
}

function delete_new_arrival($post_new_arrival, $post_id){
   $conn  =  connDB();
   $sql   = "UPDATE tbl_product_type SET `type_new_arrival` = '$post_new_arrival' WHERE `type_id` = '$post_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}

function delete_new_arrivals($post_new_type_id){
   $conn  =  connDB();
   $sql   = "DELETE FROM tbl_new_arrival WHERE `new_type_id` = '$post_new_type_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}

if(!empty($item_id)){
	
   $product = get_type_id($item_id);
   
   foreach($product as $product){
      delete_new_arrival(0, $product['type_id']);
      delete_new_arrivals($product['type_id']);
   }
   
}

?>