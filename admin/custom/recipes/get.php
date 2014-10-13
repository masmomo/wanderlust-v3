<?php
function get_listing_recipes($search, $field, $cat, $sort_by, $first_record, $query_per_page){
   $conn = connDB();
   
   $sql   = "SELECT * FROM tbl_recipes
			 WHERE $search AND `$field` = '$cat'
			 ORDER BY $sort_by
			 LIMIT $first_record , $query_per_page";
   $query = mysql_query($sql, $conn);
   $row   = array();
   
   while($result = mysql_fetch_array($query)){
	   array_push($row, $result);
   }
   
   return $row;
}

function getAllCategory(){
   $conn = connDB();
   
   $sql   = "SELECT * FROM tbl_recipes_category ORDER BY category_name";
   $query = mysql_query($sql, $conn);
   $row   = array();
   
   while($result = mysql_fetch_array($query)){
	   array_push($row, $result);
   }
   
   return $row;
}


function getCategoryId($category_id){
   $conn = connDB();
   
   $sql   = "SELECT * FROM tbl_recipes_category WHERE `category_id` = '$category_id' ORDER BY category_name";
   $query = mysql_query($sql, $conn);
   $row   = array();
   
   while($result = mysql_fetch_array($query)){
	   array_push($row, $result);
   }
   
   return $row;
}

// SORTING
function get_full_recipes($search, $field, $cat, $sort_by, $first_record, $query_per_page){
$conn = connDB();

$sql    = "SELECT * FROM tbl_recipes
		   WHERE $search AND `$field` = '$cat'
		   ORDER BY $sort_by";
$query  = mysql_query($sql, $conn);

$full_product['total_query'] = mysql_num_rows($query);
$full_product['total_page']  = ceil($full_product['total_query'] / $query_per_page); // 

return $full_product;
}
?>