<?php
/* -- CALL FUNCTIONS -- */
$category = get_category();

if(isset($_POST['btn_add_inspiration'])){
   
   /* -- INSPIRATION -- */
   
   // PREDEFINED VALUE
   $name         = addslashes($_POST['inspiration_name']);
   $description  = '';
   $date_created = current_date_sql();
   $active       = 1;
   $visibility   = 1;
   $order        = $_POST['order_banner'];
   $category     = $_POST['inspiration_category'];
   
   // DATABASE
   insert_inspiration($name, $description, $date_created, $active, $visibility, $category);
   
   
   
   /* -- INSPIRATION IMAGE -- */
   
   // CALL FUNCTION
   $get_max  = get_inspiration_latest_id();
   
   
   // PREDEFINED VALUE
   $max_id   = $get_max['latest_inspiration_id']; // IMAGE & FEATURED
   $arr_img  = $_POST['check_banner'];
   
   foreach($arr_img as $key=>$arr_img){
	  
	  $image_name    = substr($_FILES['upload_news_'.$arr_img]['name'],0,- 4);
	  $image_type    = substr($_FILES['upload_news_'.$arr_img]['name'],-4);
	  
	  $uploads_dir   = '../files/uploads/inspiration_image/';
	  $userfile_name = cleanurl(str_replace(array('(',')',' '),'_',$image_name)).$image_type;
	  $userfile_tmp  = $_FILES['upload_news_'.$arr_img]['tmp_name'];
	  $prefix        = 'inspiration-'.$arr_img."-";
	  $prod_img      = $uploads_dir.$prefix.$userfile_name;
	  
	  move_uploaded_file($userfile_tmp, $prod_img);
	  $slider_image  = $prefix.$userfile_name;
	  
	  
      // PREDEFINED VALUE
	  $param      = $max_id;
	  $image      = 'files/uploads/inspiration_image/'.$prefix.$userfile_name;
	  $active     = 1;
	  $visibility = 1;
	  
	  
	  // DATABASE
	  insert_inspiration_image($param, $image, $order[$key], $active, $visibility);
	  
   }
   
   
   
   /* -- INSPIRATION FETURED -- */
   
   // PREDEFINED VALUE
   $param    = $max_id;
   $arr_help = $_POST['product_featured'];
   
   foreach($arr_help as $help){
      // PREDEFINED VALUE
	  $active         = 1;
	  $visibility     = 1;
	  
      // DATABASE
	  insert_inspiration_featured($param, $help, $active, $visibility);
   }
   
   
   // ALERT
   $_SESSION['alert'] = "success";
   $_SESSION['msg']   = "Item has been successfully added.";
   
}

// CALL FUNCTION
$products = get_products();
?>