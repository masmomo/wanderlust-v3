<?php
// SESSION SETTING
if($_SESSION['lang_admin'] == "default"){
  $_SESSION['lang_admin'] = $_REQUEST['lang'];
}else if($_SESSION['lang_admin'] != "default" and !empty($_REQUEST['lang'])){
  $_SESSION['lang_admin'] = $_REQUEST['lang'];
}else{
  $_SESSION['lang_admin'] = "default";
}

include("get.php");
include("update.php");


$recipe_alias = $_REQUEST['rname'];
$clean        = preg_replace("/[\/_|+ -]+/", ' ', $request_recipe_name);
$recipe_name  = ucwords(strtolower($clean));


// DEFINE VARIABLE
$recipe_id          = $_POST['recipe_id'];
$category_recipe    = $_POST['category_recipes'];
$recipe_name        = addslashes($_POST['recipe_name']);
$recipe_date        = $_POST['recipe_date'];
$recipe_ingredients = addslashes($_POST['recipe_ingredients']);
$recipe_sauce       = addslashes($_POST['recipe_sauce']);
$recipe_method      = addslashes($_POST['recipe_method']);
$recipe_additional  = 'top';
$lang_code          = $_REQUEST['lang']; 


// DEFAULT VALUE
$default = get_default_recipe($recipe_alias);

$def_id          = $default['recipe_id'];
$def_cat_id      = $default['category_recipes'];
$def_name        = $default['recipe_name'];
$def_image       = $default['recipe_image'];
$def_date        = $default['recipe_date'];
$def_ingredients = $default['recipe_ingredients'];
$def_sauce       = $default['recipe_sauce'];
$def_method      = $default['method'];
$def_alias       = $default['alias'];
$def_visibility  = $default['visibility_status'];
$def_additional  = $default['additional'];

$check_cat_lang = count_category_lang($def_cat_id, $_REQUEST['lang']);
$check_lang     = check_recipe_lang($def_id, $_REQUEST['lang']);


// CALL FUNCTION

// CATEGORY
if($check_cat_lang['rows'] > 0){
   $recipe_category   = get_category_lang($def_cat_id, $_REQUEST['lang']);
}else{
   $recipe_category   = get_default_category($def_cat_id);
}


if($check_lang['rows'] > 0){
   $value = getDetails_lang($def_id, $lang_code);
}else{
   $value = get_default_recipe($recipe_alias);
}


// CONNECT DEFAULT

// RECIPE NAME
if($value['recipe_name'] === "default"){
   $default_name = $def_name;
}else{
   $default_name = $value['recipe_name'];
}

// RECIPE INGREDIENTS
if($value['recipe_ingredients'] == "default"){
   $default_ingredients = $def_ingredients;
}else{
   $default_ingredients = $value['recipe_ingredients'];
}

// RECIPE SAUCE
if($value['recipe_sauce'] == "default"){
   $default_sauce = $def_sauce;
}else{
   $default_sauce = $value['recipe_sauce'];
}

// RECIPE METHOD
if($value['method'] == "default"){
   $default_method = $def_ingredients;
}else{
   $default_method = $value['recipe_ingredients'];
}


if(isset($_POST['custom_btn_edit_recipes'])){
   
   // CREATE ALIAS
   $check_name = count_name_lang($recipe_name);
   
   if($check_name['rows'] > 0 ){
		  
      $get_name = get_name_lang($recipe_id);
		 
      if($get_name['id_param'] == $recipe_id){
	     $recipe_alias = $get_name['alias'];
      }else{
	     $recipe_alias = cleanurl($recipe_name." ".$check_name['rows']);
	  }
		 
	  $recipe_name     = $recipe_name;
   
   }else{
      $recipe_name     = $recipe_name;
	  $recipe_alias    = cleanurl($recipe_name);
   }
   
   if($check_lang['rows'] > 0){
      updateRecipes_lang($def_id, $def_cat_id, $recipe_name, $def_image, $def_date, $recipe_ingredients, $recipe_sauce, $recipe_method, $def_alias, $def_visibility, $def_additional, $def_id, $lang_code);
   }else{
      insert_recipes_lang($def_id, $def_cat_id, $recipe_name, $def_image, $def_date, $recipe_ingredients, $recipe_sauce, $recipe_method, $def_alias, $def_visibility, $def_additional, $lang_code);
   }
   
}

echo "<input type=\"hidden\" id=\"custom_recipes_detail_rname\" value=\"".$_REQUEST['rname']."\">";
?>