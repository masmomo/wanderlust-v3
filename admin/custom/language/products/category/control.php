<?php
include("get.php");
include("update.php");

// DEFINE VALUE
$req_cat_id = $_POST['cat_id'];
$lang_code  = $_POST['custom_option_lang'];


// CALL FUNCTION
$default_value = get_default_lang($req_cat_id);
$check_dml     = count_category_lang($req_cat_id, $lang_code);


/* -- DATA VARIABLE  -- */

// DEFAULT VALUE
$def_id         = $default_value['catgoery_id'];
$def_name       = $default_value['category_name'];
$def_desc       = $default_value['category_description'];
$def_level      = $default_value['category_level'];
$def_order      = $default_value['category_order'];
$def_active     = $default_value['category_active_status'];
$def_visibility = $default_value['category_visibility_status'];


// DUAL VALUE
$dual_param      = $_POST['cat_id'];
$dual_name       = addslashes($_POST['category_name']);
$dual_desc       = $def_desc;
$dual_level      = $def_level;
$dual_order      = $def_order;
$dual_active     = $def_active;
$dual_visibility = $def_visibility;


if(isset($_POST['btn_save_cat_lang'])){
   
   if($check_dml['rows'] > 0){
      update_category_lang($dual_name, $dual_param, $lang_code);
   }else{
	  insert_category_lang($dual_param, $dual_name, $def_desc, $def_level, $def_order, $def_active, $def_visibility, $lang_code);
   }
   
}
?>