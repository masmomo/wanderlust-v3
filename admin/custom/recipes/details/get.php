<?php
$request_recipe_name = $_REQUEST['rname'];
$clean               = preg_replace("/[\/_|+ -]+/", ' ', $request_recipe_name);
$recipe_name         = ucwords(strtolower($clean));

function getDetails($recipe_name){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_recipes AS recipe INNER JOIN tbl_recipes_category AS cat ON recipe.category_recipes = cat.category_id
              WHERE `alias` = '$recipe_name'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function getCategory(){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_recipes_category";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
           
   return $row;
}

function getName($recipe_name){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_recipes WHERE recipe_name = '$recipe_name'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function getRecords($post_recipe_name){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_recipes WHERE recipe_name LIKE '%$post_recipe_name%'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function getRecipe($post_recipe_name, $post_recipe_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_recipes WHERE `recipe_name` = '$post_recipe_name' AND `recipe_id` = '$post_recipe_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

$recipeDetails = getDetails($request_recipe_name);
?>