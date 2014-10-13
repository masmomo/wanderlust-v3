<?php
/* -- FUNCTION -- */
function count_category($post_relation_level, $post_parent_id, $search, $sort_by, $qpp){
   $conn  = connDB();
   
   $sql   = "SELECT * FROM tbl_tag AS cat INNER JOIN tbl_tag_relation AS rel ON cat.category_id = rel.category_child
			 WHERE $search  AND `category_parent` != 'top' AND `category_parent` = '$post_parent_id' AND `relation_level` = '$post_relation_level'
			 GROUP BY category_id
			 ORDER BY $sort_by 
			";
   $query = mysql_query($sql, $conn);
   
   $full_order['total_query'] = mysql_num_rows($query);
   $full_order['total_page']  = ceil($full_order['total_query'] / $qpp); 

   return $full_order;
}


function get_categories($post_relation_level, $post_parent_id, $search, $sort_by, $first_record, $qpp){
   $conn  = connDB();
   
   $sql   = "SELECT * FROM tbl_tag AS cat INNER JOIN tbl_tag_relation AS rel ON cat.category_id = rel.category_child
			 WHERE $search  AND `category_parent` != 'top' AND `category_parent` = '$post_parent_id' AND `relation_level` = '$post_relation_level'
			 GROUP BY category_id
			 ORDER BY $sort_by 
			 LIMIT  $first_record, $qpp
			";
   $query = mysql_query($sql, $conn);
   $row   = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}


function count_products($post_product_category){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_product WHERE `product_category`  = '$post_product_category'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function get_parent($post_category_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_tag WHERE `category_id`  = '$post_category_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}



function get_total_product($category_id){
   $conn   = connDB();
   
   $sql    = "SELECT IFNULL(total_product_main,0)+IFNULL(total_product_child,0) AS total_product
			 
			 FROM tbl_tag AS cat 
			 LEFT JOIN (SELECT product_category, COUNT(tbl_product.id) AS total_product_main FROM tbl_product
			 WHERE product_delete!='1'
			 GROUP BY product_category) AS prod
			 ON cat.category_id = prod.product_category
			 
			 LEFT JOIN (SELECT COUNT(x.id) AS total_product_child, category_parent FROM tbl_product AS x LEFT JOIN tbl_tag_relation AS y
			 ON x.product_category = y.category_child
			 WHERE product_delete!='1'
			 GROUP BY category_parent) AS prod2
			 ON cat.category_id = prod2.category_parent
			 
			 LEFT JOIN (SELECT * from tbl_tag_relation WHERE relation_level = '1') AS relation
			 ON cat.category_id = relation.category_child
			 WHERE (category_id = '$category_id')";
   
   $query  = mysql_query($sql, $conn);
   $row    = array();	 
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row[0]['total_product'];
}
?>