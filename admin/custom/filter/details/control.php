<?php
/* -- DEFINED VARIABLE -- */

// REQUEST
$category_id   = $_REQUEST['cat_id'];


// CALL FUNCTION
$category = get_city($category_id);
$check    = count_job($category_id);

//$category_name = 


if(isset($_POST['btn_detail_filter'])){
   
   // DEFINED VARIABLE
   $city_name  = clean_alphabet($_POST['category_name']);
   $cat_id     = $_POST['cat_id'];
   $visibility = $_POST['visibility_status'];
   
   if($_POST['btn_detail_filter'] == 'Delete'){
   
      delete($cat_id);
	  
	  $_SESSION['alert'] = 'success';
	  $_SESSION['msg']   = 'Item has been successfully deleted.';
   
   }else{
	   
      if(!empty($_FILES['upload_news_1']['name'])){
	     
		 unlink('../'.$category['image']);
         
		 // ADD FOR ANTICIPATED CROWDED IMAGE NAME @ 4 November 2013
	     $file_name = substr($_FILES['upload_news_1']['name'],0,-4);
	     $file_type = substr($_FILES['upload_news_1']['name'],-4);
	  
	     $uploads_dir   = '../files/uploads/filter_image/';
	     $userfile_name = cleanurl($file_name).$file_type;
	     $userfile_tmp  = $_FILES['upload_news_1']['tmp_name'];
	     $prefix        = 'filter-image-';
	     $prod_img      = $uploads_dir.$prefix.$userfile_name;
	  
	     move_uploaded_file($userfile_tmp, $prod_img);
	     $slider_image  = $prefix.$userfile_name;
	  
	     $image         = "files/uploads/filter_image/".$slider_image;
		 
	  }else{
	     $image         = $category['image'];
	  }
	  
	  update($city_name, '', $image, $visibility, $cat_id);
	  
	  $_SESSION['alert'] = 'success';
	  $_SESSION['msg']   = 'Item has been successfully saved.';
   }
   
}
?>