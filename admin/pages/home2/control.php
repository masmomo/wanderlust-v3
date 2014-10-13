<?php
include("get.php");
include("update.php");

/*--------------------*/
/*        HOME        */
/*--------------------*/

$get_slideshows      = get_slideshows();
$count_slideshow     = count_slideshow();
$get_order_slideshow = get_order_slideshow();
$new_id              = get_new_id();
$slideshow_get       = slideshow_get();

// Banner
$id      = $_POST['slideshow_id'];
$link    = addslashes($_POST['name_link']);
$link_id = $_POST['link_id'];
$sort    = $_POST['order_image'];


if(isset($_POST['btn-link-banner'])){
   
   if($_POST['btn-link-banner'] == "Save Changes"){
      insertLinkBanner($link, $link_id);
	  
	  // ALERT
	  $_SESSION['alert'] = "success";
	  $_SESSION['msg']   = "Changes have been successfully saved.";
	  
   }else if($_POST['btn-link-banner'] == "Delete"){
      insertLinkBanner('', $link_id);  
	  
	  // ALERT
	  $_SESSION['alert'] = "success";
	  $_SESSION['msg']   = "Changes have been successfully saved.";
	  
   }
   
}


if(isset($_POST['btn-pages-home'])){
   
   if($_POST['btn-pages-home'] == "Save Changes" || $_POST['btn-pages-home'] == "Save Changes & Exit"){
	  
	  /* -- BANNER -- */
	  foreach($id as $id){
		 
		 $get_slideshow = get_slideshow($id);
		 $validate = validate_slideshow($id);
		 
		 $files_len  = strlen($_FILES['upload_slider_'.$id]['name']);
		 $files_name = substr($_FILES['upload_slider_'.$id]['name'],0,((int) $files_len - 4));
		 
		 $file_type  = substr($_FILES['upload_slider_'.$id]['name'],-4);
		 
		 $uploads_dir   = '../files/uploads/slideshow/';
		 $userfile_name = cleanurl(str_replace(array('(',')',' '),'_',$files_name)).$file_type;
		 $userfile_tmp  = $_FILES['upload_slider_'.$id]['tmp_name'];
		 $prefix = 'slider-'.$id."-";
		 $prod_img = $uploads_dir.$prefix.$userfile_name;
		 
		 move_uploaded_file($userfile_tmp, $prod_img);
		 $slider_image = $prefix.$userfile_name;
		 
		 $filename = 'files/uploads/slideshow/'.$prefix.$userfile_name;
		 
		 if($validate['rows'] > 0){
			unlink("../".$get_slideshow['filename']);
		    update_slideshow($filename, $id);
		 }else{
		    insert_slideshow($id, $filename, $id);
		 }
		 
	  }// END FOR
	  
	  // ORDER DRAGABLE
	  foreach($sort as $key=>$order){
		  $slide_id = (int) $key + 1;
	     update_order($slide_id, $order);
	  }
	  
	  
	  /* -- END BANNER -- */
   
   }
   
   $_SESSION['alert'] = "success";
   $_SESSION['msg']   = "Changes have been successfully saved.";
   
   
} // END ISSET
?>