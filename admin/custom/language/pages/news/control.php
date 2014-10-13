<?php
// SESSION SETTING
if($_SESSION['lang_admin'] == "default"){
  $_SESSION['lang_admin'] = $_REQUEST['lang'];
}else if($_SESSION['lang_admin'] != "default" and !empty($_REQUEST['lang'])){
  $_SESSION['lang_admin'] = $_REQUEST['lang'];
}else{
  $_SESSION['lang_admin'] = "default";
}

// Get value
$news_id    = $_REQUEST['nid'];
$clean      = $_REQUEST['nn'];
$news_title = preg_replace("/[\/_|+ -]+/", ' ', $clean);


// DEFINED VARIABLE
$post_news_id  = $_POST['news_id'];
$post_category = $_POST['category'];
$post_title    = strtolower($_POST['news_title']);
$post_date     = $_POST['news_date'];
$post_content  = $_POST['news_content'];
$get_date      = date('Y-m-d H:i:s');

// CALL FUNCTION
$check_lang    = check_news_lang($news_id, $_SESSION['lang_admin']);

if($check_lang['rows'] > 0){
   $news_detail       = get_news_detail_lang($news_id, $_SESSION['lang_admin']);
}else{
   $news_detail       = get_news_detail_check($news_id);
}


// CALL FUNCTION
$ct_db          = get_news_detail_check($news_id);

$def_title      = $ct_db['news_title'];
$def_content    = $ct_db['news_content'];


// PREDEFINED VALUE
if($news_detail['news_title'] == "default"){
   $default_title = $def_title;
}else{
   $default_title = $news_detail['news_title'];
}

if($news_detail['news_content'] == "default"){
   $default_content = $def_content;
}else{
   $default_content = $news_detail['news_content'];
}

$get_param_id = get_new_param($news_detail['news_id']);



$all_news_category = getAllCategory_lang();
$check_title       = check_news_title_lang($post_title);

if(isset($_POST['btn_custom_news_lang'])){
   
   // DATA FEEDER
   $ct_news_cat       = $ct_db['news_category'];
   $ct_news_param     = $ct_db['news_id'];
   $ct_news_title     = addslashes($_POST['ct_post_news_title']);
   $ct_news_date      = $ct_db['news_date'];
   $ct_news_image     = $ct_db['news_image'];
   
   if(!empty($_POST['custom_lang_default_content'])){
      $ct_news_content   = 'default';
   }else{
      $ct_news_content   = $_POST['ct_post_news_content'];
   }
   
   $ct_created_date   = $ct_db['news_created_date'];
   $ct_lang_code      = $_REQUEST['lang'];
   $ct_visibility     = $ct_db['news_visibility'];

   if($check_lang['rows'] > 0){
      updateNews_lang($ct_news_cat, $ct_news_title, $ct_news_date, $ct_news_image, $ct_news_content, $ct_created_date, $ct_news_param, $ct_lang_code, $ct_visibility);
   }else{
      insert_news_lang($ct_news_title, $ct_news_param, $ct_news_cat, $ct_news_date, $ct_news_image, $ct_news_content, $ct_created_date, $ct_visibility, $ct_lang_code);
   }
   
   $_SESSION['alert'] = 'success';
   $_SESSION['msg']   = 'Changes success saved'; 
}
?>