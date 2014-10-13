<?php
function find_total_sales(){
	$conn = connDB();
	
	GLOBAL $date_start;
	GLOBAL $date_end;
	
	
	
	$sql = "SELECT SUM(item_quantity) AS quantity, SUM(item_quantity*item_price) AS subtotal, SUM(item_quantity*item_discount_price) AS discount from tbl_order_item AS item INNER JOIN tbl_order AS order_
	ON item.order_id = order_.order_id
	
	WHERE payment_status = 'Paid' AND (order_open_date>='$date_start' AND order_open_date<='$date_end')";
	
	
	
	$check = mysql_query($sql,$conn);
	
	if (mysql_num_rows($check)!=null){
		
			$check_array = mysql_fetch_array($check);
			
			return $check_array;
	
	}
}


function find_sales(){
	GLOBAL $date_start;
	GLOBAL $date_end;
	$conn = connDB();
	$sql = "SELECT order_number,SUM(item_quantity) AS quantity, SUM(item_quantity*item_price) AS subtotal, SUM(item_quantity*item_discount_price) AS discount, order_open_date AS order_date, order_billing_fullname from tbl_order_item AS item INNER JOIN tbl_order AS order_
	ON item.order_id = order_.order_id
	WHERE payment_status = 'Paid' AND (order_open_date>='$date_start' AND order_open_date<='$date_end')
	GROUP BY order_.order_id
	ORDER BY order_open_date DESC
	";
	
	return db($sql);
}

function find_sales_items($order_num){
	$conn = connDB();
	$sql="SELECT type.type_id AS type_id, stock_name, SUM(item_quantity) AS quantity, item_price, SUM(item_quantity*item_price) AS subtotal, SUM(item_quantity*item_discount_price) AS discount, product_name, type_name, type_code from tbl_order_item AS item INNER JOIN tbl_order AS order_
		ON item.order_id = order_.order_id
		INNER JOIN tbl_product_type AS type
		ON item.type_id = type.type_id
		INNER JOIN tbl_product AS product
		ON type.product_id = product.id
		WHERE payment_status = 'Paid' AND (order_number ='$order_num')
	GROUP BY type.type_id,stock_name";
	
	
	return db($sql);
}

?>