<?php
$general = get_general();

$accounts = get_admin();

if(isset($_POST['btn-index-account'])){
   
   if($_POST['btn-index-account'] == "Save Changes"){
      
	  // DATA FEEDER
	  $acc_id       = $_POST['admin_id'];
	  $acc_role     = $_POST['admin_role'];
	  $acc_name     = $_POST['admin_username'];
	  $acc_email    = $_POST['admin_email'];
	  $acc_old_pass = $_POST['admin_old_password'];
	  $acc_new_pass = $_POST['admin_r_new_password'];
	  
	  if(empty($acc_role)){
	     $role = "super admin";
	  }else{
	     $role = $acc_role;
	  }
	  
	  update_admin_half($role, $acc_name, $acc_email, '1', $acc_id);
	  
	  $_SESSION['alert'] = "success";
	  $_SESSION['msg']   = "Changes successfully saved";
	  
	  // VERIFY ADMIN
	  $cek_admin = get_admin_validation($acc_id, $acc_name, $acc_old_pass);
	  
	  if(!empty($acc_old_pass)){
	  
	     if($cek_admin['rows'] == 1){
	     
		    if(empty($acc_new_pass)){
			 
		    }else{
		       update_admin($role, $acc_name, $acc_email, $acc_new_pass, '1', $acc_id);
		    }
			
			$_SESSION['alert'] = "success";
			$_SESSION['msg']   = "Changes successfully saved";
		 
	     }else{
		    $_SESSION['alert'] = "error";
		    $_SESSION['msg']   = "Please input valid information";
	     }
	  
	  }
	  
   }
   
}// END ISSET





/*
# ----------------------------------------------------------------------
# GENERAL
# ----------------------------------------------------------------------
*/


if(isset($_POST['btn_general_index'])){


   /* --- DEFINE VARIABLE --- */
   $url         = $_POST['url'];

   $title       = escape_quote($_POST['website_title']);
   $description = escape_quote($_POST['website_description']);
   $keywords    = escape_quote($_POST['website_keywords']);
   $analytics   = $_POST['google_analytics'];
   $phone       = $_POST['company_phone'];
   $email       = $_POST['company_email'];
   $address     = escape_quote($_POST['company_address']);
   $country     = $_POST['company_country'];
   $province    = $_POST['company_province'];
   $city        = $_POST['company_city'];
   $postal      = $_POST['company_postal_code'];
   $facebook    = $_POST['company_facebook'];
   $twitter     = $_POST['company_twitter'];
   $instagram   = $_POST['company_instagram'];
   $currency    = $_POST['currency_rate'];
	
   /* --- LOGO --- */
   if(!empty($_FILES['color_image']['name'])){
      $image_name    = substr($_FILES['color_image']['name'],0,- 4);
      $image_type    = substr($_FILES['color_image']['name'],-4);
   
      $uploads_dir   = 'files/common/';
      $userfile_name = cleanurl(str_replace(array('(',')',' '),'_',$image_name)).$image_type;
      $userfile_tmp  = $_FILES['color_image']['tmp_name'];
      $prefix        = 'logo-';
      $prod_img      = $uploads_dir.$prefix.$userfile_name;
   
      move_uploaded_file($userfile_tmp, $prod_img);
      //$logo          = 'files/common/'.$prefix.$userfile_name;
	  $logo = $prod_img;
	  
   }else{
      
	  /*
      if($_POST['logo_check_delete'] == 'yes'){
         $logo       = 'files/common/logo.png';
	     $asd = 'Bottom - Top';
	  }else{
	  */
         $logo       = $_POST['hidden_logo'];
	     //$asd = 'Bottom - Bottom';
	  //}
	  
   }

   $validation = get_general_validation();
   
   if($validation['rows'] > 0){
      update_general($url, $title, $description, $keywords, $analytics, $phone, $email, $address, $country, $province, $city, $postal, $facebook, $twitter, $instagram, $currency, $logo);   
   }else{
      insert_general($url, $title, $description, $keywords, $analytics, $phone, $email, $address, $country, $province, $city, $postal, $facebook, $twitter, $instagram, $currency, $logo);
   }
	  
   $_SESSION['alert'] = 'success';
   $_SESSION['msg']   = 'Changes has been successfully saved';

}
?>