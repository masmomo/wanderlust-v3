<?php


function get_listing_size_manage($search, $sort_by, $first_record, $query_per_page){
   $conn = connDB();
   
   $sql   = "
            SELECT 
            type.size_type_id, type.size_type_name AS size_group_name, type.size_type_order, type.size_type_active AS active_status, type.size_type_visibility AS visibility_status, 
			size.size_id, size.size_type_id, 
			(SELECT GROUP_CONCAT( size_name ) FROM tbl_size WHERE size_type_id = type.size_type_id ORDER BY size.size_order) AS size_name, size.size_order, 
			(SELECT GROUP_CONCAT( size_sku ) FROM tbl_size WHERE size_type_id = type.size_type_id ORDER BY size.size_order) AS size_sku, 
			prod.id, prod.product_name, COUNT( ptype.type_id ) AS total_product, 
			ptype.type_name
			
			FROM tbl_size_type AS type INNER JOIN tbl_size AS size ON type.size_type_id = size.size_type_id
                                       LEFT JOIN tbl_product AS prod ON type.size_type_id = prod.product_size_type_id
									   LEFT JOIN tbl_product_type AS ptype ON prod.id = ptype.product_id
            WHERE $search
			GROUP BY type.size_type_id
			ORDER BY $sort_by
			LIMIT $first_record , $query_per_page";
   $query = mysql_query($sql, $conn);
   $row   = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
   
}

function get_full_size_manage($search, $sort_by, $first_record, $query_per_page){
   $conn = connDB();
   
   $sql   = "
            SELECT 
            type.size_type_id, type.size_type_name AS size_group_name, type.size_type_order, type.size_type_active AS active_status, type.size_type_visibility AS visibility_status, 
			size.size_id, size.size_type_id, 
			(SELECT GROUP_CONCAT( size_name ) FROM tbl_size WHERE size_type_id = type.size_type_id ORDER BY size.size_order) AS size_name, size.size_order, 
			(SELECT GROUP_CONCAT( size_sku ) FROM tbl_size WHERE size_type_id = type.size_type_id ORDER BY size.size_order) AS size_sku, 
			prod.id, prod.product_name, COUNT( ptype.type_id ) AS total_product, 
			ptype.type_name
			
			FROM tbl_size_type AS type INNER JOIN tbl_size AS size ON type.size_type_id = size.size_type_id
                                       LEFT JOIN tbl_product AS prod ON type.size_type_id = prod.product_size_type_id
									   LEFT JOIN tbl_product_type AS ptype ON prod.id = ptype.product_id
            WHERE $search 
			GROUP BY type.size_type_id
			ORDER BY $sort_by
			LIMIT $first_record , $query_per_page
			";
   $query = mysql_query($sql, $conn);
   
   $full_order['total_query'] = mysql_num_rows($query);
   $full_order['total_page']  = ceil($full_order['total_query'] / $query_per_page); 

   return $full_order;
   
}

function get_latest_order(){
   $conn   = connDB();
   $sql    = "SELECT * FROM tbl_size_type ORDER BY size_type_order DESC LIMIT 1";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function get_latest_id(){
   $conn   = connDB();
   $sql    = "SELECT * FROM tbl_size_type ORDER BY size_type_id DESC LIMIT 1";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function checkDelete($post_size_type_id){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(type_id) AS total_product FROM tbl_product_type AS type LEFT JOIN tbl_product AS prod ON type.product_id = prod.id
                                                                                   INNER JOIN tbl_size_type AS stype ON prod.product_size_type_id = stype.size_type_id

              WHERE size_type_id = '$post_size_type_id'
			 ";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function totalSize($post_size_type_id){
   
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(type_id) AS total_product FROM tbl_product_type AS type LEFT JOIN tbl_product AS prod ON type.product_id = prod.id
                                                                                   INNER JOIN tbl_size_type AS stype ON prod.product_size_type_id = stype.size_type_id

              WHERE size_type_id = '$post_size_type_id' AND type_delete =  '0'
			 ";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}
?>