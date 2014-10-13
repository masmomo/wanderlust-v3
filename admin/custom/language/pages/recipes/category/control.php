<?php
if(isset($_POST['btn_save_lang_recipe'])){
include("get.php");
include("update.php");
	
   // DEFINE VARIABLE
   $cat_recipes_id           = $_POST['category_id'];
   $cat_recipes_name         = $_POST['category_name_lang'];
   $cat_recipes_active       = $_POST['news-category-active-status'];
   $cat_recipes_visibility   = $_POST['news-category-visible-status'];
   $default_check            = $_POST['custom_default_value'];
   
   $post_cat_id              = $_POST['cat_id'];
   $post_action              = $_POST['category_listing_action'];
   $post_action_2            = $_POST['category_listing_option'];
   $lang_code                = $_POST['custom_lang_code'];
   $get_param 				 = lang_get_param($cat_recipes_id);
   $dml                      = check_action($get_param['category_id'], $lang_code);
   
   if($_POST['btn_save_lang_recipe'] == "Save Changes"){
      
	  if(isset($default_check)){
		  
	     if($dml['rows'] > 0){
		    update_category_lang("default", $get_param['category_active'], $get_param['category_visibility'], $cat_recipes_id, $lang_code);
		 
		    $_SESSION['alert'] = "success";
		    $_SESSION['msg']   = "Changes has been saved.";
	     }else{
	        insert_category_lang("default", $get_param['category_id'], $get_param['category_active'], $get_param['category_visibility'], $lang_code, $get_param['additional']);
		 
		    $_SESSION['alert'] = "success";
		    $_SESSION['msg']   = "Changes has been saved.";
	     }
	     
	  }else{
		  
	     if($dml['rows'] > 0){
		    update_category_lang($cat_recipes_name, $get_param['category_active'], $get_param['category_visibility'], $cat_recipes_id, $lang_code);
		 
		    $_SESSION['alert'] = "success";
		    $_SESSION['msg']   = "Changes has been saved.";
	     }else{
	        insert_category_lang($cat_recipes_name, $get_param['category_id'], $get_param['category_active'], $get_param['category_visibility'], $lang_code, $get_param['additional']);
		 
		    $_SESSION['alert'] = "success";
		    $_SESSION['msg']   = "Changes has been saved.";
	     }

	  }
	  	  
   }else if($_POST['btn_save_lang'] == "Delete"){
      delete_category_lang($cat_recipes_id);
   
   /*  
   }else if($_POST['btn_pop_category'] == "GO"){
      
	  if($post_action = "Delete" and !empty($post_cat_id)){
		  
	     foreach($post_cat_id as $post_cat_id){
			$newscategory_check_child = news_count_child($post_cat_id);
			
			if($newscategory_check_child['rows'] > 0){
			   $_SESSION['alert'] = "error";
			   $_SESSION['msg']   = "This item(s) contains related data";
			}else{
			   
			   delete_category($post_cat_id);
			   $_SESSION['alert'] = "success";
			   $_SESSION['msg']   = "Success delete item(s)";
			}
		 
		 }
		  
	  }
	  */
	  
   }
   
}
?>