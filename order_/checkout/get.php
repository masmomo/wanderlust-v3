<?php
function get_country(){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM countries ORDER BY country_name ASC";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}

function get_province(){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM province ORDER BY `province_name`";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
   
}

function setCity($post_province){
      $conn   = connDB();

	  $sql    = "SELECT * FROM cities WHERE `province` = '$post_province' ORDER BY `city_name`";
	  $query  = mysql_query($sql, $conn);
	  $row    = array();

	  while($result = mysql_fetch_array($query)){
	     array_push($row, $result);
	  }

	  return $row;
}


function get_cart($post_type_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_product_type WHERE `type_id` = '$post_type_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


// tbl_order_item
function get_cart_item($post_type_id, $post_stock_id){
   $conn  = connDB();

	//promo
	$custom_join .= 'LEFT JOIN tbl_promo_item AS discount ON type.type_id = discount.product_type_id
	   LEFT JOIN tbl_promo AS promo ON discount.promo_id = promo.promo_id';
   
    $sql   = "SELECT * FROM tbl_product AS prod INNER JOIN tbl_product_type AS type ON prod.id = type.product_id
                                               INNER JOIN tbl_product_image AS img ON type.type_id = img.type_id
											   INNER JOIN tbl_product_stock AS stock ON type.type_id = stock.type_id
											   INNER JOIN tbl_size_type AS sizet ON prod.product_size_type_id = sizet.size_type_id
											   INNER JOIN tbl_size AS size ON sizet.size_type_id = size.size_type_id ".$custom_join." 
											   
			  WHERE type.type_id = '$post_type_id' AND `stock_id` = '$post_stock_id' ".$custom_where."
			  GROUP BY type.type_id";
   $query = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}



function get_stock($post_stock_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_product_stock WHERE `stock_id` = '$post_stock_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function get_voucher($post_voucher_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_voucher WHERE `voucher_id` = '$post_voucher_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function get_courier($post_courier_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_courier_rate WHERE `courier_rate_id` = '$post_courier_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function get_courier_name($post_courier_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_courier WHERE `courier_id` = '$post_courier_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


// GENERATE ORDER NUMBER
function generate_order_number($post_current_date){
   $conn   = connDB();
   
   $sql    = "SELECT RIGHT(order_number,3) AS digits FROM tbl_order WHERE order_id =
              (
			  SELECT MAX(order_id) AS latest_order FROM tbl_order WHERE order_date = '$post_current_date'
			  )
			 ";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function get_latest_order(){
   $conn   = connDB();
   
   $sql    = "SELECT MAX(order_id) AS latest_order_id FROM tbl_order";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

// GET PRODUCT ID
function success_get_productid($post_type_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_product_type AS type_ INNER JOIN tbl_product AS prod ON type_.product_id = prod.id WHERE `type_id` = '$post_type_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


// CHECK SOLD OUT

function success_check_productsoldout($post_product_id){
   $conn   = connDB();
   
   $sql    = "SELECT SUM(stock_quantity) AS stock FROM tbl_product_stock AS stock_ INNER JOIN tbl_product_type AS type_ ON stock_.type_id = type_.type_id
                                                                                   INNER JOIN tbl_product AS prod ON type_.product_id = prod.id

              WHERE `id` = '$post_product_id'
			 ";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function success_check_typesoldout($post_type_id){
   $conn   = connDB();
   
   $sql    = "SELECT SUM(stock_quantity) AS stock FROM tbl_product_stock WHERE `type_id` = '$post_type_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

//BANK
function get_bank_info(){
	$conn   = connDB();
	
	$sql    = "SELECT * FROM tbl_account";
	$query  = mysql_query($sql, $conn);
	$row    = array();
	
	while($result = mysql_fetch_array($query)){
	   array_push($row, $result);
	}
	
	return $row;
}
?>