<?php
// Action btn-order-detail Mark As Paid
function db_update_mark_as_paid($order_id, $amount, $confirm_name, $confirm_bank){
   $conn = connDB();
   
   $sql    = "UPDATE tbl_order SET payment_status = 'Paid', 
                                   fulfillment_status = 'In Process', 
								   order_confirm_amount = '$amount',
								   order_confirm_name = '$confirm_name',
								   order_confirm_bank = '$confirm_bank' 
		      WHERE order_id = '$order_id'
			 ";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
}
 

// Updating fulfillment_status = Delivered
function db_update_deliver_1($order_id){
   $conn = connDB();
   
   $sql    = "UPDATE tbl_order SET fulfillment_status = 'Delivered'  WHERE order_id = '$order_id'";
   $query  = mysql_query($sql, $conn);
}

// Updating tbl_order_item
function db_update_deliver_2($fulfillment_date, $order_id){
   $conn = connDB();
   
   $sql    = "UPDATE tbl_order_item SET fulfillment_date = '$fulfillment_date'  WHERE order_id = '$order_id'";
   $query  = mysql_query($sql, $conn);
}


// Updating 
function update_order_detail_1($one, $two, $three, $order_id){
   $conn = connDB();
   
   $sql    = "UPDATE tbl_order SET order_confirm_bank = '$one', order_confirm_name = '$two', order_confirm_amount = '$three'  WHERE order_id = '$order_id'";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
}


function update_order_detail_2($one,$two){
   $conn = connDB();

   $two_ = current($two);
   foreach ($one as $one_){
  		$sql    = "UPDATE tbl_order_item SET item_quantity = '$one_' WHERE item_id = '$two_'";
   		$query  = mysql_query($sql, $conn) or die(mysql_error());
		$two_ = next($two);
   }
}

function updateShippingNumber($post_order_id, $post_order_item, $post_shipping_number, $post_fulfillment_date, $post_service){
   $conn  = connDB();
   
   $sql   = "UPDATE tbl_order_item SET `fulfillment_date` = '$post_fulfillment_date', `shipping_number` = '$post_shipping_number', `services` = '$post_service' WHERE `order_id` = '$post_order_id' AND `type_id` = '$post_order_item'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}

function updateFulfillment_status($post_order_id, $post_fulfillment_status){
   $conn  = connDB();
   
   $sql   = "UPDATE tbl_order SET `fulfillment_status` = '$post_fulfillment_status' WHERE `order_id` = '$post_order_id'";
   $query = mysql_query($sql, $conn);
}


function delete_user_purchase($post_order_id){
   $conn  = connDB();
   
   $sql   = "DELETE FROM tbl_user_purchase WHERE `order_id` = '$post_order_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}


function delete_order_item($post_order_id){
   $conn  = connDB();
   
   $sql   = "DELETE FROM tbl_order_item WHERE `order_id` = '$post_order_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}

/* --- EDIT ORDER --- */
function update_order_header($confirm_method, $confirm_name, $confirm_amount, $purchase_amount, $total_amount, $shipping_amount, $shipping_address, $shipping_country, $shipping_province, $shipping_city, $order_id){
   $conn  = connDB();
   $sql   = "UPDATE tbl_order SET `order_confirm_bank` = '$confirm_method',
                                  `order_confirm_name` = '$confirm_name',
								  `order_confirm_amount` = '$confirm_amount',
								  `order_purchase_amount` = '$purchase_amount',
								  `order_total_amount` = '$total_amount',
								  `order_shipping_amount` = '$shipping_amount',
								  `order_shipping_address` = '$shipping_address',
								  `order_shipping_country` = '$shipping_country',
								  `order_shipping_province` = '$shipping_province',
								  `order_shipping_city` = '$shipping_city'
             WHERE `order_id` = '$order_id'
			";
   $query = mysql_query($sql,$conn) or die(mysql_error());
}


function update_order_qty($qty, $item_id){
   $conn  = connDB();
   $sql   = "UPDATE tbl_order_item SET `item_quantity` = '$qty' WHERE `item_id` = '$item_id'";
   $query = mysql_query($sql, $conn);
}


/* DECREMENT STOCK*/


/* --- ADD PRODUCT --- */
function update_add_header($order_amount, $order_shipping, $total_order, $order_id){
   $conn  = connDB();
   $sql   = "UPDATE tbl_order SET `order_purchase_amount` = '$order_amount',
                                  `order_shipping_amount` = '$order_shipping',
								  `order_total_amount` = '$total_order'
             WHERE `order_id` = '$order_id'
			";
   $query = mysql_query($sql, $conn);
}


function update_add_detail($order_id, $type_id, $stock_name, $item_quantity, $item_price, $item_discount_price){
   $conn  = connDB();
   $sql   = "INSERT INTO tbl_order_item (`order_id`, `type_id`, `stock_name`, `item_quantity`, `item_price`, `item_discount_price`) 
                                  VALUES('$order_id', '$type_id', '$stock_name', '$item_quantity', '$item_price', '$item_discount_price')";
   $query = mysql_query($sql, $conn);
}

?>