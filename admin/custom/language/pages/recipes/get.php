<?php
// GET FROM DEFAULT
function get_default_recipe($post_recipe_alias){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_recipes AS recipe INNER JOIN tbl_recipes_category AS cat ON recipe.category_recipes = cat.category_id
              WHERE `alias` = '$post_recipe_alias'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function get_default_categories(){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_recipes_category";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
           
   return $row;
}


function get_default_category($post_id_param){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_recipes_category WHERE `category_id` = '$post_id_param'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}



// CHECK LANGUAGE
function check_recipe_lang($post_recipe_id, $post_lang_code){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_recipes_lang WHERE `id_param` = '$post_recipe_id' AND `language_code` = '$post_lang_code'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function getDetails_lang($post_recipe_id, $post_lang_code){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_recipes_lang WHERE `id_param` = '$post_recipe_id' AND `language_code` = '$post_lang_code'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}



// LANGUAGE

// COUNT CATEGORY
function count_category_lang($post_id_param, $post_lang_code){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_recipes_category_lang WHERE `id_param` = '$post_id_param' AND `language_code` = '$post_lang_code'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

// GET CATEGORY
function get_category_lang($post_id_param, $post_lang_code){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_recipes_category_lang WHERE `id_param` = '$post_id_param' AND `language_code` = '$post_lang_code'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
           
   return $result;
}

function count_name_lang($recipe_name){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_recipes_lang WHERE recipe_name = '$recipe_name'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function get_name_lang($post_id_param){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_recipes_lang WHERE `id_param` = '$post_id_param'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function getRecords_lang($post_recipe_name){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_recipes_lang WHERE recipe_name LIKE '%$post_recipe_name%'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function getRecipe_lang($post_recipe_name, $post_recipe_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_recipes_lang WHERE `recipe_name` = '$post_recipe_name' AND `recipe_id` = '$post_recipe_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}
?>