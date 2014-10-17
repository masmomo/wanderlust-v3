<?php
/* -- DEFINED VARIABLE -- */

// REQUEST
$category_id   = $_REQUEST['cat_id'];


// CALL FUNCTION
$category = get_city($category_id);
$check    = count_job($category_id);
$city     = get_cities();


//$category_name = 


if(isset($_POST['btn_detail_store_job'])){
   
   // DEFINED VARIABLE
   $active     = '1';
   $visibility = $_POST['visibility_status'];
   $city_name  = escape_quote($_POST['category_name']);
   $cat_id     = $_POST['cat_id'];
   $category   = $_POST['category_department'];
   $desc       = escape_quote($_POST['career_description']);
   //$map        = escape_quote($_POST['category_maps']);
   $website    = $_POST['website'];
   $email      = $_POST['career_email'];
   
   /* --- LOGO --- */
   if(!empty($_FILES['color_image']['name'])){
      $image_name    = substr($_FILES['color_image']['name'],0,- 4);
      $image_type    = substr($_FILES['color_image']['name'],-4);
   
      $uploads_dir   = '../files/uploads/partners/';
      $userfile_name = cleanurl(str_replace(array('(',')',' '),'_',$image_name)).$image_type;
      $userfile_tmp  = $_FILES['color_image']['tmp_name'];
      $prefix        = 'partner-';
      $prod_img      = $uploads_dir.$prefix.$userfile_name;
   
      move_uploaded_file($userfile_tmp, $prod_img);
      //$logo          = 'files/common/'.$prefix.$userfile_name;
	  $map = 'files/uploads/partners/'.$prefix.$userfile_name;
	  
   }else{
      
	  /*
      if($_POST['logo_check_delete'] == 'yes'){
         $logo       = 'files/common/logo.png';
	     $asd = 'Bottom - Top';
	  }else{
	  */
         $map       = $_POST['hidden_logo'];
	     //$asd = 'Bottom - Bottom';
	  //}
	  
   }
   
   if($_POST['btn_detail_job'] == 'Delete'){
   
      delete($cat_id);
	  
	  $_SESSION['alert'] = 'success';
	  $_SESSION['msg']   = 'Item has been successfully deleted.';
   
   }else{
	   
	  update($city_name, $category, $desc, $map, $visibility, $cat_id, $website, $email);
	  
	  $_SESSION['alert'] = 'success';
	  $_SESSION['msg']   = 'Item has been successfully saved.';
   }
   
}
?>