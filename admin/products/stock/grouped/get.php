<?php
function get_size_group(){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_size_type ORDER BY `size_type_name`";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}

function get_size_grouping(){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_size_type ORDER BY `size_type_name` LIMIT 0,1";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function get_size_name($post_size_type_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_size WHERE `size_type_id` = '$post_size_type_id' ORDER BY `size_id`";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}

function get_stock($post_type_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_product_stock WHERE `type_id` = '$post_type_id' ORDER BY `stock_id`";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}


// GET RECORD
function count_product($static_src, $src, $sort_by ,$qpp){
   $conn  = connDB();
   
   $sql   = "SELECT * FROM tbl_product AS prod_ LEFT JOIN tbl_product_type AS type_ ON prod_.id = type_.product_id
                                                LEFT JOIN tbl_product_image AS img_ ON type_.type_id = img_.type_id
			 WHERE `product_size_type_id` = '$static_src' AND $src AND `type_delete` = '0'
			 GROUP BY `id`
			 ORDER BY $sort_by
			";
   $query = mysql_query($sql, $conn);

   $full_order['total_query'] = mysql_num_rows($query);
   $full_order['total_page']  = ceil($full_order['total_query'] / $qpp); // 
   
   return $full_order;
}


// GET
function get_product($static_src, $src, $sort_by ,$first, $qpp){
   $conn   = connDB();
   
   $sql    =  "SELECT * FROM tbl_product AS prod_ LEFT JOIN tbl_product_type AS type_ ON prod_.id = type_.product_id
                                                LEFT JOIN tbl_product_image AS img_ ON type_.type_id = img_.type_id
			  WHERE `product_size_type_id` = '$static_src' AND $src AND `type_delete` = '0'
			  GROUP BY `id`
			  ORDER BY $sort_by
			  LIMIT $first, $qpp
			 ";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}
?>