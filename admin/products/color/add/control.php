<?php

if(isset($_POST['btn_add_color'])){

   // CALL FUNCTION
   $check     = count_products($_POST['color_name']);
   $max_order = get_order();
   
   if($check['rows'] > 0){
      $_SESSION['alert'] = 'error';
      $_SESSION['msg']   = $_POST['color_name'].' has already existed, please choose another color name';
   }else{
	  // DEFINED VARIABLE
	  $active     = 'active';
	  $visibility = $_POST['visibility_status'];
	  $name       = clean_alphanum($_POST['color_name']);
	  $order      = (int) $max_order['max_order'] + 1;
	  
	  if(!empty($_FILES['color_image']['name'])){
	     $image_name    = substr($_FILES['color_image']['name'],0,- 4);
	     $image_type    = substr($_FILES['color_image']['name'],-4);
	  
	     $uploads_dir   = '../files/uploads/color_image/';
	     $userfile_name = cleanurl(str_replace(array('(',')',' '),'_',$image_name)).$image_type;
	     $userfile_tmp  = $_FILES['color_image']['tmp_name'];
	     $prefix        = 'color-';
	     $prod_img      = $uploads_dir.$prefix.$userfile_name;
	  
	     move_uploaded_file($userfile_tmp, $prod_img);
	     $color_image  = 'files/uploads/color_image/'.$prefix.$userfile_name;
	  }else{
	     $color_image  = 'files/uploads/color_image/no-color.png';
	  }
	  
	  
	  insert($name, $color_image, $order, $active, $visibility);
	  //insert($post_color_name, $post_color_image, $post_order, $post_active, $post_color_visibility_status)
      $_SESSION['alert'] = 'success';
      $_SESSION['msg']   = 'Item(s) has been successfully added.';
   }
   
}
?>