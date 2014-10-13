<?php
include("get.php");
include("update.php");


/* --- CALL FUNCTION PAGE BANNER--- */
$page_banner       = get_page_banner();
$count_page_banner = count_page_banner();



if(isset($_POST['btn-link-banner'])){
   
   /* --- PAGES BANNER --- */
   if($link_id=='page-banner-1'||$link_id=='page-banner-2'||$link_id=='page-banner-3'||$link_id=='page-banner-4'){
      if($_POST['btn-link-banner'] == "Save Changes"){

	     insertLinkPageBanner($link, $link_id);

	     // ALERT
		 $_SESSION['alert'] = "success";
		 $_SESSION['msg']   = "Changes have been successfully saved.";

	  }else if($_POST['btn-link-banner'] == "Delete"){
	     insertLinkPageBanner('', $link_id);  

		 // ALERT
		 $_SESSION['alert'] = "success";
		 $_SESSION['msg']   = "Changes have been successfully saved.";

	  }
   }
   /* --- END PAGES BANNER --- */
   
}


if(isset($_POST['btn-pages-home'])){
   
   if($_POST['btn-pages-home'] == "Save Changes" || $_POST['btn-pages-home'] == "Save Changes & Exit"){
	
	/* --- PAGES BANNER --- */
      $id_array = array('page-banner-1','page-banner-2','page-banner-3','page-banner-4');
      foreach($id_array as $id){
	     
		 /* -- BANNER -- */
	     if($_FILES['upload_slider_'.$id]['name']!=null){
	     
		 /* --- CALL FUNCTION --- */
	     $check_page_banner = count_page_banner_page($id);
		 
		    if($check_page_banner['rows'] > 0){
		       $files_len     = strlen($_FILES['upload_slider_'.$id]['name']);
		       $files_name    = substr($_FILES['upload_slider_'.$id]['name'],0,((int) $files_len - 4));
		       $file_type     = substr($_FILES['upload_slider_'.$id]['name'],-4);
		 
		       $uploads_dir   = '../files/uploads/page_banner/';
		       $userfile_name = cleanurl(str_replace(array('(',')',' '),'_',$files_name)).$file_type;
		       $userfile_tmp  = $_FILES['upload_slider_'.$id]['tmp_name'];
		       $prefix        = 'page-banner-'.$id."-";
		       $prod_img      = $uploads_dir.$prefix.$userfile_name;
		 
		       move_uploaded_file($userfile_tmp, $prod_img);
		       $slider_image  = $prefix.$userfile_name;
		 
		       $filename = 'files/uploads/page_banner/'.$prefix.$userfile_name;
		 
		       update_page_banner($filename, $id);
			}else{
		       $files_len     = strlen($_FILES['upload_slider_'.$id]['name']);
		       $files_name    = substr($_FILES['upload_slider_'.$id]['name'],0,((int) $files_len - 4));
		       $file_type     = substr($_FILES['upload_slider_'.$id]['name'],-4);
		 
		       $uploads_dir   = '../files/uploads/page_banner/';
		       $userfile_name = cleanurl(str_replace(array('(',')',' '),'_',$files_name)).$file_type;
		       $userfile_tmp  = $_FILES['upload_slider_'.$id]['tmp_name'];
		       $prefix        = 'page-banner-'.$id."-";
		       $prod_img      = $uploads_dir.$prefix.$userfile_name;
		 
		       move_uploaded_file($userfile_tmp, $prod_img);
		       $slider_image  = $prefix.$userfile_name;
		 
		       $filename = 'files/uploads/page_banner/'.$prefix.$userfile_name;
			   insert_page_banner($id, $filename, $order);
			}
			
		 }
	  
	  }//foreach
	  /* --- END PAGES BANNER --- */
   
   }
   
} // END ISSET
?>