<?php

/*
==============================
|							 |
|        DETAIL ORDER 	     |
|							 |
==============================

*/


/* --- DETAILS --- */


// Get order detail
function get_order_detail_by_number($order_number){
   $conn = connDB();
   
   $sql    = "SELECT * FROM tbl_order WHERE order_number = '$order_number' ";
   $query  = mysql_query($sql, $conn) or die('Query failed: ' . mysql_error());
   $result = mysql_fetch_array($query);
   
   return $result;
}

function detail_order($post_order_number){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_order AS ord INNER JOIN tbl_order_item AS item ON ord.order_id = item.order_id
                                             INNER JOIN tbl_user_purchase AS pur ON ord.order_id = pur.order_id
											 INNER JOIN tbl_user AS user ON pur.user_id = user.user_id
              WHERE `order_number` = '$post_order_number'
			 ";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function detail_order_item($post_order_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_order AS ord INNER JOIN tbl_order_item AS item ON ord.order_id = item.order_id
                                             INNER JOIN tbl_user_purchase AS pur ON ord.order_id = pur.order_id
											 INNER JOIN tbl_user AS user ON pur.user_id = user.user_id
              WHERE item.order_id = '$post_order_id'
			 ";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}

function detail_order_item_product($post_type_id, $post_order_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_product AS prod INNER JOIN tbl_product_type AS type ON prod.id = type.product_id
                                                INNER JOIN tbl_product_image AS img ON type.type_id = img.type_id
												INNER JOIN tbl_product_stock AS stock ON type.type_id = stock.type_id
												INNER JOIN tbl_order_item AS orditem ON type.type_id = orditem.type_id
												INNER JOIN tbl_order AS ord ON orditem.order_id = ord.order_id
												LEFT JOIN tbl_promo_item AS disc ON type.type_id = disc.product_type_id
												LEFT JOIN tbl_promo AS promo ON disc.promo_id = promo.promo_id
              WHERE type.type_id = '$post_type_id' AND orditem.order_id = '$post_order_id'
			  GROUP BY type.type_id
			 ";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}


// Get order detail
function get_order_detail($order_id){
   $conn = connDB();
   
   $sql    = "SELECT
              ord.order_confirm_amount, ord.order_confirm_bank, ord.order_confirm_name, ord.order_shipping_address, ord.payment_status, ord.order_number, ord.order_total_amount, ord.order_id,
			  ord.fulfillment_status, ord.shipping_method, ord.order_shipping_amount, ord.order_billing_fullname, ord.order_payment_method,
			  usr.user_email
			  FROM tbl_order AS ord INNER JOIN tbl_user_purchase AS userp ON ord.order_id = userp.order_id
		                            INNER JOIN tbl_user AS usr ON userp.user_id = usr.user_id
              WHERE ord.order_id = '$order_id' ";
   $query  = mysql_query($sql, $conn) or die('Query failed: ' . mysql_error());
   $result = mysql_fetch_array($query);
   
   return $result;
}


// Get record tbl_order_item
function order_item($order_id){	
	
   $conn = connDB();
   
   $sql    = "SELECT 
              product.product_name, type.type_name, item.stock_name, item.fulfillment_date, item.shipping_number,
			  item.item_price, item.item_discount_price, item.item_quantity, item.item_id, item.fulfillment_date,
			  image.img_src, 
			  order_.order_shipping_amount, order_.order_id, order_.shipping_method, order_.fulfillment_status 
			  
			  FROM tbl_order AS order_ INNER JOIN tbl_order_item AS item ON order_.order_id = item.order_id 
									   INNER JOIN tbl_product_type AS type ON item.type_id = type.type_id 
									   INNER JOIN tbl_product AS product ON type.product_id = product.id 
									   INNER JOIN tbl_product_image AS image ON type.type_id = image.type_id
									   
			  WHERE item.order_id = '$order_id' AND image_order='1'";
   $query  = mysql_query($sql, $conn) or die('Query failed: ' . mysql_error());
   $row = array();
   
   while ($result = mysql_fetch_array($query)) {
      array_push($row, $result);
   }
   
   return $row;
   
}

function orderdetail_get_courier(){
	
   $conn = connDB();
   
   $sql    = "SELECT * FROM tbl_courier";
   $query  = mysql_query($sql, $conn) or die('Query failed: ' . mysql_error());
   $row = array();
   
   while ($result = mysql_fetch_array($query)) {
      array_push($row, $result);
   }
   
   return $row;
}
?>