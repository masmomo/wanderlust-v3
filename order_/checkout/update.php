<?php
/* -- UPDATE -- */

function insertOrder($post_order_number, $post_billing_fname, $post_billing_lname, $post_billing_fullname, $post_billing_email, $post_billing_phone, $post_shipping_fname, $post_shipping_lname, $post_shipping_phone, $post_shipping_address, $post_shipping_country, $post_shipping_province, $post_shipping_city, $post_shipping_postal, $post_shipping_method, $post_gift, $post_gift_message, $post_payment_method, $post_status, $post_payment_status, $post_fulfillment_status, $post_purchase_amount, $post_shipping_amount, $post_discount_amount, $post_voucher_value,$post_total_amount, $post_order_date, $post_open_date, $post_cancelled_date, $post_closed_date, $post_confirm_bank, $post_confirm_name, $post_confirm_amount){
   $conn  = connDB();
   
   $sql   = "INSERT INTO tbl_order (`order_number`, `order_billing_first_name`, `order_billing_last_name`, `order_billing_fullname`, `order_billing_email`, `order_billing_phone`, `order_shipping_first_name`, `order_shipping_last_name`, `order_shipping_phone`, `order_shipping_address`, `order_shipping_country`, `order_shipping_province`, `order_shipping_city`, `order_shipping_postal_code`, `shipping_method`, `order_gift_flag`, `order_gift_message`, `order_payment_method`, `order_status`, `payment_status`, `fulfillment_status`, `order_purchase_amount`, `order_shipping_amount`, `order_discount_amount`, `order_voucher_value`, `order_total_amount`, `order_date`, `order_open_date`, `order_cancelled_date`, `order_closed_date`, `order_confirm_bank`, `order_confirm_name`, `order_confirm_amount`) 
   
VALUES ('$post_order_number', '$post_billing_fname', '$post_billing_lname', '$post_billing_fullname', '$post_billing_email', '$post_billing_phone', '$post_shipping_fname', '$post_shipping_lname', '$post_shipping_phone', '$post_shipping_address', '$post_shipping_country', '$post_shipping_province', '$post_shipping_city', '$post_shipping_postal', '$post_shipping_method', '$post_gift', '$post_gift_message', '$post_payment_method', '$post_status', '$post_payment_status', '$post_fulfillment_status', '$post_purchase_amount', '$post_shipping_amount', '$post_discount_amount', '$post_voucher_value','$post_total_amount', '$post_order_date', '$post_open_date', '$post_cancelled_date', '$post_closed_date', '$post_confirm_bank', '$post_confirm_name', '$post_confirm_amount')";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}

// tbl_order_item

function insertOrderItem($post_order_id, $post_type_id, $post_stock_name, $post_quantity, $post_price, $post_discount, $post_fulfillment_date, $post_shipping_number, $post_item_gender){
   $conn  = connDB();

	
   
   $sql   = "INSERT INTO tbl_order_item (`order_id`, `type_id`, `stock_name`, `item_quantity`, `item_price`, `item_discount_price`, `fulfillment_date`, `shipping_number`, `item_gender`) VALUES ('$post_order_id', '$post_type_id', '$post_stock_name', '$post_quantity', '$post_price', '$post_discount', '$post_fulfillment_date', '$post_shipping_number', '$post_item_gender')";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}

//tbl_user_purchase
function insertUserPurchase($post_user_id, $post_order_id){
   $conn = connDB();
   
   $sql   = "INSERT INTO tbl_user_purchase (`user_id`, `order_id`) VALUES ('$post_user_id', '$post_order_id')";
   $query = mysql_query($sql, $conn); 
}


//tbl_user_purchase
function updateProduct($post_quantity, $post_stock_id){
   $conn = connDB();
   
   $sql   = "UPDATE tbl_product_stock SET `stock_quantity` = '$post_quantity' WHERE `stock_id` = '$post_stock_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error()); 
}


//tbl_user
function updateUser($post_user_phone, $post_user_address, $post_user_country, $post_user_province, $post_user_city, $post_user_postal_code, $post_user_id){
   $conn = connDB();
   
   $sql   = "UPDATE tbl_user SET `user_phone` = '$post_user_phone', 
                                 `user_address` = '$post_user_address',
								 `user_country` = '$post_user_country',
								 `user_province` = '$post_user_province',
								 `user_city` = '$post_user_city',
								 `user_postal_code` = '$post_user_postal_code'
             WHERE `user_id` = '$post_user_id'
			";
   $query = mysql_query($sql, $conn) or die(mysql_error()); 
}


//tbl_order (INSERT TOTAL DISCOUNT)
function update_discount($post_discount_amount, $post_voucher_amount, $post_order_number){
   $conn = connDB();
   
   $sql   = "UPDATE tbl_order SET `order_discount_amount` = '$post_discount_amount', 
                                  `order_voucher_value` = '$post_voucher_amount'
             WHERE `order_number` = '$post_order_number'
			";
   $query = mysql_query($sql, $conn) or die(mysql_error()); 
}


//tbl_order (INSERT ITEM DISCOUNT)
function update_discount_item($post_voucher_value, $post_order_id, $post_type_id, $post_stock_name){
   $conn = connDB();
   
   $sql   = "UPDATE tbl_order_item SET `item_discount_price` = '$post_voucher_value'
             WHERE `order_id` = '$post_order_id' AND `type_id` = '$post_type_id' AND `stock_name` = '$post_stock_name'
			";
   $query = mysql_query($sql, $conn) or die(mysql_error()); 
}

//SOLD OUT

function success_update_productsoldout($post_product_id){
   $conn   = connDB();
   
   $sql    = "UPDATE tbl_product SET `product_sold_out` = '1' WHERE `id` = '$post_product_id'";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
}

function success_update_typesoldout($post_type_id){
   $conn   = connDB();
   
   $sql    = "UPDATE tbl_product_type SET `type_sold_out` = '1' WHERE `type_id` = '$post_type_id'";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
	
}

//currency module
function updateOrderCurrency($currency,$currency_rate,$order_id){
	$conn = connDB();

	   $sql   = "UPDATE tbl_order SET `currency` = '$currency', `currency_rate` = '$currency_rate' WHERE `order_id` = '$order_id'";
	   $query = mysql_query($sql, $conn) or die(mysql_error());
}
?>