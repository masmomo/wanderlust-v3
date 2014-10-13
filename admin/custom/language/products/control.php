<?php
// SESSION SETTING
if($_SESSION['lang_admin'] == "default"){
  $_SESSION['lang_admin'] = $_REQUEST['lang'];
}else if($_SESSION['lang_admin'] != "default" and !empty($_REQUEST['lang'])){
  $_SESSION['lang_admin'] = $_REQUEST['lang'];
}else{
  $_SESSION['lang_admin'] = "default";
}

echo "<input type=\"hidden\" id=\"custom_product_alias\" value=\"".$_REQUEST['product_alias']."\">";


/* -- DUAL CONTROL -- */
include("get.php");
include("update.php");


/* -- PREDEFINED -- */
$pre_product_alias  = $_REQUEST['product_alias'];

// CALL FUNCTION
$ct_default         = get_default_products($pre_product_alias);

$page_product       = page_get_product($pre_product_alias);
$page_type          = page_get_type($pre_product_alias);

$count_product_lang = count_product_lang($ct_default['id'], $_REQUEST['lang']);
$count_type_lang    = count_type_lang($ct_default['id'], $_REQUEST['lang']);

$product_lang       = get_product_lang($ct_default['id'], $_REQUEST['lang']);

if($count_product_lang['rows'] > 0){
   $page_product['product_name'] = $product_lang['product_name'];
}else{
   $page_product['product_name'] = $page_product['product_name'];
}


// DATA VALUE
$lang_code        = $_REQUEST['lang'];


// CALL FUNCTION
$data_product = get_product_how($_REQUEST['product_alias']);
$check_how    = check_how($ct_default['id'], $lang_code);


if($check_how['rows'] > 0){
   $how = get_how_lang($data_product['id'], $lang_code);
}else{
   $how = get_how($data_product['id']);
}

if(isset($_POST['btn_product_lang'])){

   //foreach($ct_default as $ct_default){
      /* -- DATA VALUE -- */
	  
	  // DEFAULT VALUE
	  
	  // PRODUCT
      $def_product_id               = $ct_default['id'];
      $def_product_name             = $ct_default['product_name'];
      $def_product_sold_out         = $ct_default['product_sold_out'];
      $def_product_category         = $ct_default['product_category'];
      $def_product_new_arrival      = $ct_default['product_new_arrival'];
      $def_product_order            = $ct_default['product_order'];
      $def_product_date_added       = $ct_default['product_date_added'];
      $def_product_size_type_id     = $ct_default['product_size_type_id'];
      $def_product_visibility       = $ct_default['product_visibility'];
      $def_product_delete           = $ct_default['product_delete'];
      $def_product_alias            = $ct_default['product_alias'];    
      $def_product_page_title       = $ct_default['page_title'];
      $def_product_page_description = $ct_default['page_description'];
	  
	  
	  // DATA VALUE
	  $lang_name        = $_POST['lang_product_name'];
	  $lang_type_id     = $_POST['type_id'];
	  
	  
	  // CALL FUNCTION
	  $check_dml        = count_products_lang($def_product_id, $lang_code);
	  
	  	  
	  if($check_dml['rows'] > 0){
		 
		 // PRODUCT
		 update_product_lang($lang_name, $def_product_id, $lang_code);
		 
		 // TYPE
		 foreach($lang_type_id as $lang_type_id){
		    
			/* -- PRODUCT TYPE -- */
			
			// DML
			$type_dml         = counting_type_lang($def_product_id, $lang_type_id, $lang_code);
			$ct_default_type  = page_get_default_type($lang_type_id);
			
			// DATA VALUE
			$lang_type_name   = $_POST['type_name_'.$lang_type_id];
			
			if(isset($_POST['custom_lang_default_description'])){
			   $lang_description = 'default';
			}else{
			   $lang_description = $_POST['type_description_'.$lang_type_id];
			}
			
			// DEFAULT VALUE
			$def_type_id               = $ct_default_type['type_id'];
			$def_type_code             = $ct_default_type['type_code'];
			$def_type_name			   = $ct_default_type['type_name'];
			$def_type_price            = $ct_default_type['type_price'];
			$def_type_color_id         = $ct_default_type['color_id'];
			$def_type_description      = $ct_default_type['type_description'];
			$def_type_weight           = $ct_default_type['type_weight'];
			$def_type_new_arrival      = $ct_default_type['type_new_arrival'];
			$def_type_image            = $ct_default_type['type_image'];
			$def_type_order            = $ct_default_type['type_order'];
			$def_type_sold_out         = $ct_default_type['type_sold_out'];
			$def_type_visibility       = $ct_default_type['type_visibility'];
			$def_type_delete           = $ct_default_type['type_delete'];
			$def_type_alias            = $ct_default_type['type_alias'];
			$def_type_page_title       = $ct_default_type['page_title'];
			$def_type_page_description = $ct_default_type['page_description'];
			
			
			if($type_dml['rows'] > 0){
			   update_product_type_lang($lang_type_name, $lang_description, $lang_type_id, $lang_code);
			}else{
			   insert_product_type_lang($lang_type_id, $def_product_id, $def_type_code, $lang_type_name, $def_type_price, $def_type_color_id, $lang_description, $def_type_weight, $def_type_new_arrival, $def_type_image, $def_type_order, $def_type_sold_out, $def_type_visibility, $def_type_delete, $def_type_alias, $def_type_page_title, $def_type_page_description, $lang_code);
			}
		 }
	     
	  }else{
		 
		 // PRODUCT
		 insert_product_lang($def_product_id, $lang_name, $def_product_sold_out, $def_product_category, $def_product_new_arrival, $def_product_order, $def_product_date_added, $def_product_size_type_id, $def_product_visibility, $def_product_delete, $def_product_alias, $def_product_page_title, $def_product_page_description, $lang_code);
		 
		 // TYPE
		 foreach($lang_type_id as $lang_type_id){
		    /* -- PRODUCT TYPE -- */
			
			// DATA VALUE
			$lang_type_name   = $_POST['type_name_'.$lang_type_id];
			$lang_description = $_POST['lang_type_description_'.$lang_type_id];
			
			// CALL FUNCTION 
			$ct_default_type           = page_get_default_type($lang_type_id);
			
			// DEFAULT VALUE
			$def_type_id               = $ct_default_type['type_id'];
			$def_type_code             = $ct_default_type['type_code'];
			$def_type_name			   = $ct_default_type['type_name'];
			$def_type_price            = $ct_default_type['type_price'];
			$def_type_color_id         = $ct_default_type['color_id'];
			$def_type_description      = $ct_default_type['type_description'];
			$def_type_weight           = $ct_default_type['type_weight'];
			$def_type_new_arrival      = $ct_default_type['type_new_arrival'];
			$def_type_image            = $ct_default_type['type_image'];
			$def_type_order            = $ct_default_type['type_order'];
			$def_type_sold_out         = $ct_default_type['type_sold_out'];
			$def_type_visibility       = $ct_default_type['type_visibility'];
			$def_type_delete           = $ct_default_type['type_delete'];
			$def_type_alias            = $ct_default_type['type_alias'];
			$def_type_page_title       = $ct_default_type['page_title'];
			$def_type_page_description = $ct_default_type['page_description'];
			
			// PRODUCT TYPE
	        insert_product_type_lang($lang_type_id, $def_product_id, $def_type_code, $lang_type_name, $def_type_price, $def_type_color_id, $lang_description, $def_type_weight, $def_type_new_arrival, $def_type_image, $def_type_order, $def_type_sold_out, $def_type_visibility, $def_type_delete, $def_type_alias, $def_type_page_title, $def_type_page_description, $lang_code);
		 }
	     
	  }// END CHECK DML
	  
   //}
   
   # ----------------------------------------------------------------------
   # HOW TO & TECHNICAL DATA
   # ----------------------------------------------------------------------
   
   // DEFINED VARIABLE
   if(isset($_POST['custom_lang_default_how'])){
      $val_how  = 'default'; 
   }else{
	  $val_how  = $_POST['how'];  
   }
   
   
   if(isset($_POST['custom_lang_default_technical'])){
      $val_tech  = 'default'; 
   }else{
	  $val_tech  = $_POST['technical'];  
   }
   
   
   // CHECK DML
   
   if($check_how['rows'] > 0){
	  update_how($val_how, $val_tech, $def_product_id);
   }else{
      insert_how($def_product_id, $val_how, $val_tech, $lang_code);
   }
   
   $_SESSION['alert'] = 'success';
   $_SESSION['msg']   = 'Changes successfully saved.';

}

?>