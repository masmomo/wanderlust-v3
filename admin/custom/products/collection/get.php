<?php


function get_listing_collection_manage($search, $sort_by, $first_record, $query_per_page){
   $conn = connDB();
   
   $sql   = "
            SELECT 
            type.collection_id, type.collection_name, type.collection_order, type.collection_active_status AS active_status, type.collection_visibility_status AS visibility_status, 
			prod.id, prod.product_name, COUNT( ptype.type_id ) AS total_product, 
			ptype.type_name
			
			FROM tbl_collection AS type LEFT JOIN tbl_product AS prod ON type.collection_id = prod.product_collection
									   LEFT JOIN tbl_product_type AS ptype ON prod.id = ptype.product_id
            WHERE $search
			GROUP BY type.collection_id
			ORDER BY $sort_by
			LIMIT $first_record , $query_per_page";
   $query = mysql_query($sql, $conn);
   $row   = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
   
}

function get_full_collection_manage($search, $sort_by, $first_record, $query_per_page){
   $conn = connDB();
   
   $sql   = "
            SELECT 
            type.collection_id, type.collection_name, type.collection_order, type.collection_active_status AS active_status, type.collection_visibility_status AS visibility_status, 
			prod.id, prod.product_name, COUNT( ptype.type_id ) AS total_product, 
			ptype.type_name
			
			FROM tbl_collection AS type LEFT JOIN tbl_product AS prod ON type.collection_id = prod.product_collection
									   LEFT JOIN tbl_product_type AS ptype ON prod.id = ptype.product_id
            WHERE $search
			GROUP BY type.collection_id
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
   $sql    = "SELECT * FROM tbl_collection ORDER BY collection_order DESC LIMIT 1";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function get_latest_id(){
   $conn   = connDB();
   $sql    = "SELECT * FROM tbl_collection ORDER BY collection_id DESC LIMIT 1";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function checkDelete($post_collection_id){
   $conn   = connDB();
   
   echo $sql    = "SELECT COUNT(type_id) AS total_product FROM tbl_product_type AS type LEFT JOIN tbl_product AS prod ON type.product_id = prod.id
                                                                                   INNER JOIN tbl_collection AS stype ON prod.product_collection = stype.collection_id

              WHERE collection_id = '$post_collection_id'
			 ";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function totalCollection($post_collection_id){
   
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(type_id) AS total_product FROM tbl_product_type AS type LEFT JOIN tbl_product AS prod ON type.product_id = prod.id
                                                                                   INNER JOIN tbl_collection AS stype ON prod.product_collection = stype.collection_id

              WHERE collection_id = '$post_collection_id' AND type_delete =  '0'
			 ";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}
?>