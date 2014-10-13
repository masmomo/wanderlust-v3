<?php
function checkName($recipe_name){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) FROM tbl_recipes WHERE recipe_name = '$recipe_name'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
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

function getCategory(){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_recipes_category ORDER BY category_name";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}
?>