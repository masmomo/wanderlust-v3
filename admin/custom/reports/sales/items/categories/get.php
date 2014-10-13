<?php

function iterate_category($parent,$child){
	$conn = connDB();
	
	
	
	$sql = "SELECT category_child,category_name from tbl_category_relation AS rel INNER JOIN tbl_category AS cat
	ON rel.category_child = cat.category_id
	WHERE category_parent='$parent' AND relation_level='1' ";
	
	$iterate = mysql_query($sql,$conn);
	
	if (mysql_num_rows($iterate)!=null){
		for ($i=0;$i<mysql_num_rows($iterate);$i++){
			$iterate_array = mysql_fetch_array($iterate);
			$child[$parent][$i]["id"]=$iterate_array["category_child"];
			$child[$parent][$i]["name"]=$iterate_array["category_name"];
			
			$child = iterate_category($iterate_array["category_child"],$child);
		}
	}
	
	
	return $child;
}

function find_sales($id){
	$conn = connDB();
	
	GLOBAL $date_start;
	GLOBAL $date_end;
	
	$sql = "SELECT SUM(item_quantity) AS quantity, SUM(item_quantity*item_price) AS subtotal, SUM(item_quantity*item_discount_price) AS discount from tbl_order_item AS item INNER JOIN tbl_order AS order_
	ON item.order_id = order_.order_id
	INNER JOIN tbl_product_type AS type
	ON item.type_id = type.type_id
	INNER JOIN tbl_product AS product
	ON type.product_id = product.id
	INNER JOIN tbl_category_relation AS rel
	ON product.product_category = rel.category_child
	WHERE payment_status = 'Paid' AND (product_category ='$id' OR category_parent = '$id') AND (order_open_date>='$date_start' AND order_open_date<='$date_end')";
	
	$check = mysql_query($sql,$conn);
	
	if (mysql_num_rows($check)!=null){
		
			$check_array = mysql_fetch_array($check);
			
			return $check_array;
	
	}
}

function find_sales_items($id){
	$conn = connDB();
	
	GLOBAL $date_start;
	GLOBAL $date_end;
	
	$sql="SELECT type.type_id AS type_id, stock_name, SUM(item_quantity) AS quantity, item_price, SUM(item_quantity*item_price) AS subtotal, SUM(item_quantity*item_discount_price) AS discount, product_name, type_name, type_code from tbl_order_item AS item INNER JOIN tbl_order AS order_
		ON item.order_id = order_.order_id
		INNER JOIN tbl_product_type AS type
		ON item.type_id = type.type_id
		INNER JOIN tbl_product AS product
		ON type.product_id = product.id
		WHERE payment_status = 'Paid' AND (product_category ='$id') AND (order_open_date>='$date_start' AND order_open_date<='$date_end')
	GROUP BY type.type_id,stock_name";
	
	return db($sql);
}

?>