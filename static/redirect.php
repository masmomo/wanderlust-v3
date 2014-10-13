<?php
/*
--------------------
|                  |
|     REDIRECT     |
|                  |
--------------------
*/

if(isset($_POST['update_bag'])){
   header("Location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/shopping-bag");
}

// SHOPPING BAG
else if(isset($_POST['btn_checkout'])){
   
   if(empty($_SESSION['user_id'])){
      header("Location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/checkout");
   }else{
      header("Location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/checkout");
   }
   
}


else if(isset($_POST['btn_submit_checkout'])){
   header("Location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/finish");
}


// LOGIN
if(isset($_POST['btn_login'])){
   /*
   if($_SESSION['alert_front'] != "error"){
	  header("Location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/my-account/");
   }else{
	  header("Location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/login");
   }
   */
}

// CONFIRM PAYMENT
else if(isset($_POST['btn_confirm'])){
   
   if($_SESSION['alert'] == "error"){
      header("Location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/confirm");
   }else{
      header("Location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/admin/emails/admin_confirmed.php?act=&ornum=".clean_alphanumeric($_POST['order_number'])."&amount=".clean_number($_POST['order_confirm_amount']));
   }
   
}

// CONTACT
else if(isset($_POST['btn_contact'])){
   header("Location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/contact");
}


// SEARCH BAR
else if(isset($_POST['btn_search'])){
   header("Location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/shop-search/name-".$_POST['search_bar']);
}


/* ACCOUNT */

// EDIT ACCOUNT
else if($_POST['btn_edit_account']){
   header("Location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/account-details");
}

else if($_REQUEST['act']=="order_/wishlist"&&$_SESSION['user_id']==null) {
  
		header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/login");	

}

else if(isset($_POST['btn_edit_shipping_details'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/shipping-details");
}

?>