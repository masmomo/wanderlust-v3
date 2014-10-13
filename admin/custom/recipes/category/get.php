<?php
function get_category($search, $sort_by, $first_record, $query_per_page){
   $conn = connDB();
   
   $sql   = "SELECT 
             cat.category_id, cat.category_name, cat.category_active, cat.category_visibility,
			 COUNT(recipes.recipe_id) AS total_recipes
			 FROM tbl_recipes_category AS cat LEFT JOIN tbl_recipes AS recipes ON cat.category_id = recipes.category_recipes 
			 WHERE $search 
			 GROUP BY cat.category_id
			 ORDER BY $sort_by
			 LIMIT $first_record , $query_per_page";
   $query = mysql_query($sql, $conn);
   $row   = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}

// SORTING
function get_full_category($search, $sort_by, $first_record, $query_per_page){
$conn = connDB();

$sql    = "SELECT 
           cat.category_id, cat.category_name, cat.category_active, cat.category_visibility,
		   COUNT(recipes.recipe_id) AS total_recipes
		   FROM tbl_recipes_category AS cat LEFT JOIN tbl_recipes AS recipes ON cat.category_id = recipes.category_recipes 
		   WHERE $search 
		   GROUP BY cat.category_id
		   ORDER BY $sort_by";
$query  = mysql_query($sql, $conn);

$full_product['total_query'] = mysql_num_rows($query);
$full_product['total_page']  = ceil($full_product['total_query'] / $query_per_page); // 

return $full_product;
}

function validateCategory($post_category_id){
   $conn = connDB();
   
   $sql   = "SELECT 
             cat.category_id, cat.category_name, cat.category_active, cat.category_visibility,
			 COUNT(rec.recipe_id) AS total_recipes
			 FROM tbl_recipes_category AS cat LEFT JOIN tbl_recipes AS rec ON cat.category_id = rec.category_recipes
			 WHERE cat.category_id = '$post_category_id' 
			 ORDER BY category_name";
   $query = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function validateCategoryNameCheck($post_category_name){
   $conn = connDB();
   
   $sql   = "SELECT COUNT(* ) AS rows FROM tbl_recipes_category WHERE `category_name` = '$post_category_name'";
   $query = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function validateCategoryName($post_category_name){
   $conn = connDB();
   
   $sql   = "SELECT * FROM tbl_recipes_category WHERE `category_name` = '$post_category_name'";
   $query = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function countCategory(){
   $conn   = connDB();
   $sql    = "SELECT 
              cat.category_id, cat.category_name, cat.category_active, cat.category_visibility,
			  COUNT(rec.recipe_id) AS total_recipes
			  FROM tbl_recipes_category AS cat LEFT JOIN tbl_recipes AS rec ON cat.category_id = rec.category_recipes ORDER BY category_name";
   $query  = mysql_query($sql, $conn);
   $result = mysql_num_rows($query);
   
   return $result;
}
?>