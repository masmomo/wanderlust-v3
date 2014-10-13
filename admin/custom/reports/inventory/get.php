<?php

function get_cat_id($name){
	$conn=connDB();
	
	
	
	$sql = "SELECT category_id from tbl_category
	WHERE category_name='$name'
	ORDER BY category_id DESC";
	
	$get = mysql_query($sql,$conn);
	
	if (mysql_num_rows($get)!=null){
		
			$get_array = mysql_fetch_array($get);
			return $get_array["category_id"];
			
		
	}
	
}

function iterate_category($parent,$child){
	$conn=connDB();
	
	
	
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
	
	
	$sql = "SELECT SUM(stock_quantity) AS quantity, SUM(stock_quantity*type_price) AS subtotal from tbl_product_stock AS stock INNER JOIN tbl_product_type AS type
		ON stock.type_id = type.type_id
		INNER JOIN tbl_product AS product
		ON type.product_id = product.id
		INNER JOIN tbl_category_relation AS rel
		ON product.product_category = rel.category_child
		WHERE type_delete != '1' AND type_sold_out !='1' AND (product_category ='$id' OR category_parent = '$id')";
	
	$check = mysql_query($sql,$conn);
	
	if (mysql_num_rows($check)!=null){
		
			$check_array = mysql_fetch_array($check);
			
			return $check_array;
	
	}
}

function find_sales_items($id){
	$conn = connDB();
	
	
	$sql="SELECT type.type_id AS type_id, stock_name, SUM(stock_quantity) AS quantity, type_price, SUM(stock_quantity*type_price) AS subtotal, product_name, type_name, type_code from tbl_product_stock AS stock INNER JOIN  tbl_product_type AS type
		ON stock.type_id = type.type_id
		INNER JOIN tbl_product AS product
		ON type.product_id = product.id
		WHERE type_delete != '1' AND (product_category ='$id') AND type_sold_out !='1' 
	GROUP BY type.type_id,stock_name";
	
	
	return db($sql);
}

?>