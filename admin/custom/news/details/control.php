<?php
// Get value
$news_id    = $_REQUEST['nid'];
//$news_title = $_REQUEST['nn'];

$clean      = $_REQUEST['nn'];
$news_title = preg_replace("/[\/_|+ -]+/", ' ', $clean);

// DEFINED VARIABLE
$post_news_id  = $_POST['hidden_id'];
$post_category = $_POST['category'];
$post_title    = $_POST['news_title'];
$post_date     = $_POST['news_date'];
$post_content  = addslashes($_POST['news_content']);
$get_date      = date('Y-m-d H:i:s');

$news_detail       = get_news_detail($news_id);
$all_news_category = getAllCategory();
$check_title       = check_news_title($post_title, $post_news_id);

if(isset($_POST['btn-edit-news'])){
   if($_POST['btn-edit-news'] == "Save Changes" || $_POST['btn-edit-news'] == "Save Changes & Exit"){
      
	  // Validate News Title
	  if($check_title['rows'] > 0){
	      $post_check = $post_title."-1";
	  }else{
	      $post_check = $post_title;
	  }
	   
	   // CHECK UPLOAD
	   if(empty($_POST['check_image'])){
	      
		  $img_name      = substr($_FILES['upload_news_1']['name'], 0, -4);
		  $img_type      = substr($_FILES['upload_news_1']['name'], -4);
		  
	      $uploads_dir   = '../files/uploads/news_image/';
          $userfile_name = str_replace(array('(',')',' '),'_',$_FILES['upload_news_1']['name']);
          $userfile_tmp  = $_FILES['upload_news_1']['tmp_name'];
          $prefix        = 'news_image-';
          $prod_img      = $uploads_dir.$prefix.$userfile_name;
			
	      move_uploaded_file($userfile_tmp, $prod_img);
		  $slider_image  = $prefix.$userfile_name;
			
	      $post_news_image = "files/uploads/news_image/".$slider_image;
		  
		  if($_POST['check_image'] != $_POST['unlink_image']){
		     unlink("../".$_POST['unlink_image']);
		  }
		  
	   }else{
	      $post_news_image = $news_detail['news_image'];
	   }
	   
	   updateNews($post_category, $post_title, $post_date, $post_news_image, $post_content, $post_news_id);
	   
   }
   
}// END ISSET



if(isset($_POST['btn-edited-news'])){
   if($_POST['btn-edited-news'] == "Save Changes"){
      
	  //Delete Image
	  if($_POST['check_image'] != $_POST['unlink_image']){
	     unlink("../".$_POST['unlink_image']);
	  }
	   
	  // Validate News Title
	  if($check_title['rows'] > 0){
		 
		 if($news_detail['news_title'] == $post_title){
	        $post_check = $post_title;
		 }else{
	        $post_check = $post_title."-1";
		 }
		 
	  }else{
	     $post_check = $post_title;
	  }
	  
	  // Uploading New Image
	  if(!empty($_FILES['upload_news_1']['name'])){
         $uploads_dir   = '../files/uploads/news_image/';
         $userfile_name = str_replace(array('(',')',' '),'_',$_FILES['upload_news_1']['name']);
         $userfile_tmp  = $_FILES['upload_news_1']['tmp_name'];
         $prefix        = 'news_image-';
         $prod_img      = $uploads_dir.$prefix.$userfile_name;
			
	     move_uploaded_file($userfile_tmp, $prod_img);
		 $slider_image  = $prefix.$userfile_name;
		 
		 $post_news_image = "files/uploads/news_image/".$slider_image;
      }else{
	     $post_news_image = $news_detail['news_image'];
	  }
	  
	  updateNews($post_category, $post_check, $post_date, $post_news_image, $post_content, $post_news_id);
	  
	  //$_POST['msg'] = "Success edited news";
   
   }else if($_POST['btn-edited-news'] == "Save Changes & Exit"){
      
   }
   
   if($_POST['hidden_image'] == 'delete'){
      delete_image('', $post_news_id);
	  
	  unlink("../".$_POST['hidden_image_value']);
   }
   
   $_SESSION['alert'] = 'success';
   $_SESSION['msg']   = 'Item successfully changed';
   
}
?>