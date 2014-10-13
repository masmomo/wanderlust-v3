<?php

// Get all category
function get_all_category(){

$sql    = "SELECT 
           category.category_name, category.category_level, category.category_order,
		   relation.category_parent, relation.relation_level, category_id
		   FROM tbl_category AS category  LEFT JOIN tbl_category_relation AS relation ON category.category_id = relation.category_child
		   
		   ORDER BY category.category_order";
		   
		return db($sql);		   
}



function get_all_size_group(){
	$sql   = "SELECT * FROM tbl_size_type ORDER BY size_type_order ASC";	
	return db($sql);
}


function get_all_color_group(){
	$sql   = "SELECT * FROM tbl_color ORDER BY color_order ASC";
	return db($sql);
}

function get_category_id($category_name){
	$conn = connDB();
   
   $sql   = "SELECT * FROM tbl_category WHERE category_name = '$category_name'";
   $query = mysql_query($sql, $conn);
   
   if (mysql_num_rows($query)!=null){
	   $result = mysql_fetch_array($query);
	   return $result['category_id'];
   }
}

// Query index
function get_full_product($search, $sort_by, $first_record, $query_per_page, $cat){
$conn = connDB();

$sql    = "SELECT 
           cat.category_id, cat.category_name, cat.category_level, 
		   car.relation_level, car.relation_id, 
		   prod.id, prod.product_category, prod.product_name, prod.product_visibility, prod.product_delete, prod.product_order,
		   prot.type_id, type_name, type_price, type_visibility, type_delete, product_alias
		   
		   FROM tbl_category AS cat LEFT JOIN tbl_category_relation AS car ON cat.category_id = car.category_child
		                            LEFT JOIN tbl_product AS prod ON cat.category_id = prod.product_category
									LEFT JOIN tbl_product_type AS prot ON prod.id = prot.product_id
		   WHERE ($search) AND type_delete != '1' AND (category_parent = '$cat' OR category_id = '$cat')
		   GROUP BY prot.type_id
		   ORDER BY $sort_by
		   ";
		  
$query  = mysql_query($sql, $conn);

$full_product['total_query'] = mysql_num_rows($query);
$full_product['total_page']  = ceil($full_product['total_query'] / $query_per_page); // 

return $full_product;
}

function get_all_product($search, $sort_by, $first_record, $query_per_page,$cat){


$sql    = "SELECT 
           cat.category_id, cat.category_name, cat.category_level, 
		   car.relation_level, car.relation_id, 
		   prod.id, prod.product_category, prod.product_name, prod.product_visibility, prod.product_delete, prod.product_order,
		   prot.type_id, type_name, type_price, type_visibility, type_delete, product_alias, img_src
		   
		   FROM tbl_category AS cat LEFT JOIN tbl_category_relation AS car ON cat.category_id = car.category_child
		                            LEFT JOIN tbl_product AS prod ON cat.category_id = prod.product_category
									LEFT JOIN tbl_product_type AS prot ON prod.id = prot.product_id
									LEFT JOIN tbl_product_image AS img_ ON prot.type_id = img_.type_id
		   WHERE ($search) AND type_delete != '1'  AND (category_parent = '$cat' OR category_id = '$cat')
		   GROUP BY prot.type_id
		   ORDER BY $sort_by
		   LIMIT $first_record , $query_per_page";		  

return db($sql);
}

// Query search category_name
$category_name               = (strlen($search) - 13);
$get_category_name_search    = substr($search, 0, 13);
$get_last_char_category_name = substr($search,13,$category_name);


?>