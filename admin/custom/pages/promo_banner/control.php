<?php
/* -- LINK -- */

if(isset($_POST['btn-link-promo'])){
   
   if($_POST['btn-link-promo'] == "Save Changes"){
	  $banner_link = $_POST['banner_link'];
	  $banner_id   = $_POST['banner_id']; 
	  
      insertLinkPromo($banner_link, $banner_id);
	  
	  // ALERT
	  $_SESSION['alert'] = "success";
	  $_SESSION['msg']   = "Changes have been successfully saved.";
	  $_SESSION['page']  = $act;
   }else if($_POST['btn-link-promo'] == "Delete"){
	  $banner_link = $_POST['banner_link'];
	  $banner_id   = $_POST['banner_id']; 
	  
      insertLinkPromo('', $banner_id);
	  
	  // ALERT
	  $_SESSION['alert'] = "success";
	  $_SESSION['msg']   = "Changes have been successfully saved.";
	  $_SESSION['page']  = $act;
   }
   
}
?>