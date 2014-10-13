<?php
function get_category_id($category_name){
	$conn = connDB();
   
   $sql   = "SELECT * FROM tbl_category WHERE category_name = '$category_name'";
   $query = mysql_query($sql, $conn);
   
   if (mysql_num_rows($query)!=null){
	   $result = mysql_fetch_array($query);
	   return $result['category_id'];
   }
}

function get_all_product($search, $cat, $sort_by, $first_record, $query_per_page){
   $conn  = connDB();
   
   $sql   = "SELECT * FROM tbl_product AS prod INNER JOIN tbl_product_type AS ptype ON prod.id = ptype.product_id
                                               INNER JOIN tbl_product_stock AS pstock ON ptype.type_id = pstock.type_id
											   INNER JOIN tbl_category AS pcat ON prod.product_category = pcat.category_id
											   INNER JOIN tbl_category_relation AS prel ON pcat.category_id = prel.category_child
											   LEFT JOIN tbl_product_image AS img_ ON ptype.type_id = img_.type_id
		     WHERE ($search) AND type_delete != '1' AND (category_parent = '$cat' OR category_id = '$cat')
			 GROUP BY stock_id
			 ORDER BY $sort_by
			 LIMIT $first_record , $query_per_page
			";
   $query = mysql_query($sql, $conn);
   $row   = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}

function get_full_product($search, $cat, $sort_by, $query_per_page){
   $conn  = connDB();
   
   $sql   = "SELECT * FROM tbl_product AS prod INNER JOIN tbl_product_type AS ptype ON prod.id = ptype.product_id
                                               INNER JOIN tbl_product_stock AS pstock ON ptype.type_id = pstock.type_id
											   INNER JOIN tbl_category AS pcat ON prod.product_category = pcat.category_id
											   INNER JOIN tbl_category_relation AS prel ON pcat.category_id = prel.category_child
											   LEFT JOIN tbl_product_image AS img_ ON ptype.type_id = img_.type_id
		     WHERE ($search) AND type_delete != '1' AND (category_parent = '$cat' OR category_id = '$cat')
			 GROUP BY stock_id
			 ORDER BY $sort_by
			";
   $query = mysql_query($sql, $conn);
   
   $full_product['total_query'] = mysql_num_rows($query);
   $full_product['total_page']  = ceil($full_product['total_query'] / $query_per_page); // 
   
   return $full_product;
}
?>