<?php
// DEFINED VARIABLE
$req_color_id = clean_number($_REQUEST['color_id']);


// CALL FUNCTION
$color_detail = get_color($req_color_id);

if($color_detail['color_image'] == '' || empty($color_detail['color_image'])){
   $color_image = $prefix_url.'static/thimthumb.php?src=../files/uploads/color_image/no-color.png&h=23&w=23&q=80';
}else{
   $color_image = $prefix_url.'static/thimthumb.php?src=../'.$color_detail['color_image'].'&h=23&w=23&q=80';
}

if(isset($_POST['btn_detail_color'])){
   
   // DEFINED VARIABLE
   $color_id   = $_POST['hidden_color_id'];
   $visibility = $_POST['visibility_status'];
   $name       = clean_alphanum($_POST['color_name']);
   
   if($_POST['btn_detail_color'] == 'Save Changes'){
   
      if(!empty($_FILES['color_image']['name'])){
	     $image_name    = substr($_FILES['color_image']['name'],0,- 4);
	     $image_type    = substr($_FILES['color_image']['name'],-4);
	  
	     $uploads_dir   = '../files/uploads/color_image/';
	     $userfile_name = cleanurl(str_replace(array('(',')',' '),'_',$image_name)).$image_type;
	     $userfile_tmp  = $_FILES['color_image']['tmp_name'];
	     $prefix        = 'color-';
	     $prod_img      = $uploads_dir.$prefix.$userfile_name;
	  
	     move_uploaded_file($userfile_tmp, $prod_img);
	     $images  = 'files/uploads/color_image/'.$prefix.$userfile_name;
		 
	  }else{
	     $images = $color_detail['color_image'];
	  }
	  
	  update($name, $images, $visibility, $color_id);
	  
	  $_SESSION['alert'] = 'success';
	  $_SESSION['msg']   = "Changes have been successfully saved.";
	     
   }else if($_POST['btn_detail_color'] == 'Delete'){
      
	  // CALL FUNCTION
	  $check = count_products($color_id);
	  
	  if($check['rows'] > 0){
	     $_SESSION['alert'] = 'error';
		 $_SESSION['msg']   = "Can't delete because it contains one or more items.";
	  }else{
		 
		 // UNLINK IMAGE
		 unlink('../../../../'.$color_detail['color_image']);
		 
		 // CALL FUNCTION
		 delete($color_id);
		 
	     $_SESSION['alert'] = 'success';
		 $_SESSION['msg']   = "Item(s) has been successfully deleted.";
	  }
	  
   }
   
}
?>