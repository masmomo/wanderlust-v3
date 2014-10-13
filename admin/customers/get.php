<?php
function getCustomers($search, $sort_by, $first_record, $query_per_page){
   $conn  = connDB();
   
   $sql   = "SELECT user.user_id, user.user_first_name, user.user_last_name, user.user_fullname, user.user_status, user.user_province, user.user_country, user.user_created_date, user.user_alias,
             SUM(ord.order_confirm_amount) AS total_spent, SUM(ord.order_total_amount) AS total_purchase, COUNT(ord.order_id) AS total_order, MAX(ord.order_date) AS last_order
			 
			 FROM tbl_user as user LEFT JOIN tbl_user_purchase AS pur ON user.user_id = pur.user_id
			                       LEFT JOIN tbl_order AS ord ON pur.order_id = ord.order_id
			 WHERE $search
			 GROUP BY user.user_id
			 ORDER BY $sort_by
			 LIMIT $first_record, $query_per_page ";
   $query = mysql_query($sql, $conn);
   $row   = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;   
}

function getFullCustomer($search, $sort_by, $first_record, $query_per_page){
   $conn  = connDB();
   
   $sql   = "SELECT user.user_fullname, user.user_status, user.user_province, user.user_country, user.user_created_date, 
             SUM(ord.order_confirm_amount) AS total_spent, COUNT(ord.order_id) AS total_order, MAX(ord.order_date) AS last_order
			 
			 FROM tbl_user as user LEFT JOIN tbl_user_purchase AS pur ON user.user_id = pur.user_id
			                       LEFT JOIN tbl_order AS ord ON pur.order_id = ord.order_id
			 WHERE $search
			 GROUP BY user.user_id
			 ORDER BY $sort_by";
   $query = mysql_query($sql, $conn);
   
   $full_user['total_query'] = mysql_num_rows($query);
   $full_user['total_page']  = ceil($full_user['total_query'] / $query_per_page); // 

   return $full_user;
}

function checkUserOrder($post_user_id){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_user_purchase WHERE `user_id` = '$post_user_id'
			 ";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

?>