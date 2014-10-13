<?php
function getCountry(){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM countries ORDER BY country_name ASC";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}


// Get user_id
function detail_get_user_id($one){
   $conn = connDB();
   
   $sql    = "SELECT * FROM tbl_user WHERE `user_alias` = '$one'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function get_detail_customer($one){
   $conn = connDB();
   
   $sql    = "SELECT user.user_id, user.user_first_name, user.user_last_name, user.user_fullname, user.user_email, user.user_status, user.user_address,
              COUNT(purchase.order_id) AS total_order, user.user_province, user.user_city, user.user_country, user.user_postal_code, user.user_alias, user.user_phone,
			  order_.order_id,  SUM( order_.order_total_amount ) AS total_spent, SUM(order_.order_total_amount) AS total_purchase, MAX(order_.order_date) AS order_date, COUNT(order_.order_id) AS total_record
			  
			  FROM tbl_user AS user LEFT JOIN tbl_user_purchase AS purchase ON user.user_id = purchase.user_id
			                        LEFT JOIN tbl_order as order_ ON order_.order_id = purchase.order_id
			  WHERE user.user_id = '$one'
			  
			 ";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function orderUser($get_user, $search_query, $sort_by, $first_record, $query_per_page){
   $conn  = connDB();
   
   $sql   = "SELECT ord.order_id, ord.order_number, ord.order_billing_first_name, ord.order_billing_last_name, ord.order_confirm_bank, ord.payment_status, ord.fulfillment_status,
                    ord.order_confirm_amount, ord.order_date, ord.order_confirm_name, ord.order_billing_fullname, ord.order_payment_method, order_purchase_amount, order_total_amount,
					item.item_id, SUM(item.item_price) AS total_sell, SUM(item.item_discount_price) AS total_disc
			 FROM tbl_order AS ord INNER JOIN tbl_order_item AS item ON ord.order_id = item.order_id
			                       INNER JOIN tbl_user_purchase AS pur ON ord.order_id = pur.order_id
								   INNER JOIN tbl_user AS user ON pur.user_id = user.user_id
			 WHERE `user_fullname` = '$get_user' AND $search_query
			 GROUP BY ord.order_id
			 ORDER BY $sort_by
			 LIMIT $first_record, $query_per_page";
   $query = mysql_query($sql, $conn);
   $row   = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}


function fullOrderUser($get_user, $search_query, $sort_by, $first_record ,$query_per_page){
   $conn  = connDB();
   
   $sql   = "SELECT ord.order_id, ord.order_number, ord.order_billing_first_name, ord.order_billing_last_name, ord.order_confirm_bank, ord.payment_status, ord.fulfillment_status,
                    ord.order_confirm_amount, ord.order_date, ord.order_confirm_name, ord.order_billing_fullname, ord.order_payment_method,
					item.item_id, SUM(item.item_price) AS total_sell, SUM(item.item_discount_price) AS total_disc
			 FROM tbl_order AS ord INNER JOIN tbl_order_item AS item ON ord.order_id = item.order_id
			                       INNER JOIN tbl_user_purchase AS pur ON ord.order_id = pur.order_id
								   INNER JOIN tbl_user AS user ON pur.user_id = user.user_id
			 WHERE `user_fullname` = '$get_user' AND $search_query
			 GROUP BY ord.order_id
			 ORDER BY $sort_by";
   $query  = mysql_query($sql, $conn);

   $full_order['total_query'] = mysql_num_rows($query);
   $full_order['total_page']  = ceil($full_order['total_query'] / $query_per_page); // 

   return $full_order;
}



// Get all record user
function order_user_detail($one, $src, $sort, $first, $list){
   $conn = connDB();
   
   $sql    = "SELECT *, DATE(order_date) AS date from tbl_order
              WHERE (order_status!='expired') AND order_id = '$one' AND ('$src') ORDER BY $sort LIMIT $first, $list";
   $query  = mysql_query($sql, $conn);
   $row = array();
   
   while ($result = mysql_fetch_array($query)) {
      array_push($row, $result);
   }
   
   return $row;
   
}

function detailCustomer($post_user_fullname){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_user where `user_fullname` = '$post_user_fullname'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


/* ALIASING */
function checkAlias($post_user_alias){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows from tbl_user where `user_alias` = '$post_user_alias'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function checkAliasing($post_user_alias){
   $conn   = connDB();
   
   $sql    = "SELECT * from tbl_user where `user_alias` = '$post_user_alias'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function countUser($post_user_fullname){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_user WHERE `user_fullname` = '$post_user_fullname'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function checkUserOrder($post_user_id){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_user_purchase WHERE `user_id` = '$post_user_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function getProvince(){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM province WHERE `country_id` = 'Indonesia'";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}

function get_city($post_province){
   $conn  = connDB();
   
   $sql   = "SELECT * FROM tbl_courier_rate WHERE `courier_province` = '$post_province'";
   $query = mysql_query($sql, $conn);
   $row   = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}

function edit_get_user($post_user_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_user WHERE `user_id` = '$post_user_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function edit_get_email($post_user_email, $post_user_id){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_user WHERE `user_email` = '$post_user_email' AND `user_id` != '$post_user_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}
?>