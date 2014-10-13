<?php
$department = get_category();

if(isset($_POST['btn_add_filter'])){
   
   // DEFINED VARIABLE
   $career_name  = clean_alphabet($_POST['category_name']);
   $desc         = $_POST['career_description'];
   $visibility   = $_POST['visibility_status'];
   
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
   
   insert($career_name, $desc, $image, $visibility);
   
   $_SESSION['alert'] = 'success';
   $_SESSION['msg']   = 'Item has been successfully saved.';
   
}
?>