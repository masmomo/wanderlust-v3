<?php
$department = get_category();

if(isset($_POST['btn_add_store_job'])){
   
   // DEFINED VARIABLE
   $active       = '1';
   $visibility   = $_POST['visibility_status'];
   $department   = $_POST['category_department'];
   $career_name  = escape_quote($_POST['category_name']);                    // STORE NAME
   $description  = escape_quote($_POST['career_description']);               // ADDRESS
   $website      = 'http://www.'.escape_quote($_POST['category_maps']);      // WEBSITE
   $email        = escape_quote($_POST['career_email']);                     // EMAIL  
   
   
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
         $map       = 'files/common/logo.png';
	     //$asd = 'Bottom - Bottom';
	  //}
	  
   }
   
   insert($career_name, $department, $active, $visibility, $description, $map, $website, $email);
   
   $_SESSION['alert'] = 'success';
   $_SESSION['msg']   = 'Item has been successfully saved.';
   
}
?>