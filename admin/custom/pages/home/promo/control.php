<?php
include("get.php");
include("update.php");

// CALL FUNCTION
$count_promo_banner = count_promos();
$max_id_promo       = promo_get_maxid();

/* -- PROMO -- */
if($_POST['btn-pages-home'] == "Save Changes"){

   $promo_banner_id = $_POST['promo_id'];
   $promo_order     = $_POST['promo_order'];
   
   foreach($promo_banner_id as $promo_key=>$promo_banner_id){
      
	  $promo_banner_name       = substr($_FILES['upload_promo_'.$promo_banner_id]['name'],0 , - 4);
	  $promo_banner_type       = substr($_FILES['upload_promo_'.$promo_banner_id]['name'],$promo_banner_img_length - 4);
	  
	  $promo_uploads_dir       = '../files/uploads/promo/';
	  $promo_userfile_name     = cleanurl(str_replace(array('(',')',' '),'_',$promo_banner_name)).$promo_banner_type;
	  $promo_userfile_tmp      = $_FILES['upload_promo_'.$promo_banner_id]['tmp_name'];
	  $promo_prefix        	   = 'promo-'.$promo_banner_id."-";
	  $promo_prod_img          = $promo_uploads_dir.$promo_prefix.$promo_userfile_name;
	  
	  move_uploaded_file($promo_userfile_tmp, $promo_prod_img);
	  $promo_image             = $promo_prefix.$promo_userfile_name;
	  
	  $promo_filename          = 'files/uploads/promo/'.$promo_prefix.$promo_userfile_name;
	  $promo_dml               = check_promos($promo_banner_id);
	  $promo_link              = addslashes($_POST['promo_link_'.$promo_banner_id]);
	  
	  if($promo_dml['rows'] > 0){
	     update_promo($promo_filename, $promo_link, $promo_order, ' ', $promo_banner_id);
	  }else{
		 insert_promo($promo_banner_id, $promo_filename, '', '', '');
	  }
	  
   }
   
   // ORDER DRAGABLE
   foreach($promo_order as $promo_key=>$promo_order){
      $promo_id = $promo_key + 1;
	  update_order_promo($promo_id, $promo_order);
   }
   
   $_SESSION['alert'] = "success";
   $_SESSION['msg']   = "Changes have been successfully saved.";
   
}


// PROMO LINK
if(isset($_POST['btn_promo_link'])){
   
   $post_promo_id   = $_POST['link_id'];
   $post_promo_link = addslashes($_POST['name_link']);
   $promo_name      = $_POST['name_promo_link'];

   if($_POST['btn_promo_link'] == "Delete"){
      update_promo_link('', $post_promo_id);
   }else if($_POST['btn_promo_link'] == "Save Changes"){
      update_promo_link($post_promo_link, $promo_name, $post_promo_id);
   }
   
   $_SESSION['alert'] = "success";
   $_SESSION['msg']   = "Changes have been successfully saved.";

}


/* -- END PROMO -- */
?>