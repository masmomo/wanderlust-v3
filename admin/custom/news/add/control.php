<?php
// Call Function
$latest_news_id = get_news_id();


// DEFINE VARIABLE
$post_news_id  = $latest_news_id['news_id'] + 1;//$_POST['news_id'];
$post_category = $_POST['category'];
$post_title    = $_POST['news_title'];
$post_date     = $_POST['news_date'];
$post_content  = $_POST['news_content'];
$get_date      = date('Y-m-d H:i:s');


// Call function
$category    = add_news_category();
$check_title = check_news_title($post_title);

if(isset($_POST['btn-add-news'])){
   if($_POST['btn-add-news'] == "Save Changes" || $_POST['btn-add-news'] == "Save Changes & Exit"){
	   
	   if($check_title['rows'] > 0){
	      $post_check = $post_title."-1";
	   }else{
	      $post_check = $post_title;
	   }
	   
	   // ADD FOR ANTICIPATED CROWDED IMAGE NAME @ 4 November 2013
	   $file_name = substr($_FILES['upload_news_1']['name'],0,-4);
	   $file_type = substr($_FILES['upload_news_1']['name'],-4);
	   
	   $uploads_dir   = '../files/uploads/news_image/';
       //$userfile_name = str_replace(array('(',')',' '),'_',$_FILES['upload_news_1']['name']);
	   $userfile_name = cleanurl($file_name).$file_type;
       $userfile_tmp  = $_FILES['upload_news_1']['tmp_name'];
       $prefix        = 'news_image-';
       $prod_img      = $uploads_dir.$prefix.$userfile_name;
		
       move_uploaded_file($userfile_tmp, $prod_img);
       $slider_image  = $prefix.$userfile_name;
	   
	   $filename      = "files/uploads/news_image/".$slider_image;
	   
	   insertNews($post_news_id, $post_category, $post_check, $post_date, $filename, $post_content, $get_date, 'yes');
	   
	   $_SESSION['alert'] = 'success';
	   $_SESSION['msg']   = 'Item(s) successfully saved';
         
   }
   
}
?>