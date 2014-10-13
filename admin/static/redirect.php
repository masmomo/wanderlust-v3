<?php

/*
# ----------------------------------------------------------------------
# ORDER
# ----------------------------------------------------------------------
*/

if(isset($_POST['index-order'])){
   header("Location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/order");
     
}else if(isset($_POST['btn-order-detailing']) || isset($_POST['deliver-validation']) || isset($_POST['btn-order_confirm'])){
   $order_id = $_REQUEST['oid'];
   header("Location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/order-detailing/".$order_id);
   
}else if(isset($_POST['btn-order-detail'])){
   $order_id = $_REQUEST['oid'];
   header("Location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/order-detail/".$order_id);

}else if(isset($_POST['index_open_order'])){
   header("Location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/order-open");

}else if(isset($_POST['index_cancel_order'])){
   header("Location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/order-cancelled");
}else if(isset($_POST['btn-edit-order'])){
   header("Location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/order-detail/".$_POST['redirect_order_number']);

   


/*
# ----------------------------------------------------------------------
# PRODUCT
# ----------------------------------------------------------------------
*/
}else if(isset($_POST['btn-product-index'])){
   header("Location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/product");
   
}else if(isset($_POST['add-product'])){
   header("Location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/product-details-".$_POST["product_alias"]);
   
}else if(isset($_POST['btn-product-detail'])){
   header("Location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/product-details-".$_POST['product_alias']);




/*
# ----------------------------------------------------------------------
# CUSTOMER
# ----------------------------------------------------------------------
*/
}else if(isset($_POST['btn-index-customer'])){
   header("Location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/customer");
   
}else if(isset($_POST['btn-detail-customer'])){
   
   if($_POST['btn-detail-customer'] == "GO"){
      $clean = strtolower($_REQUEST['cid']);
      header("Location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/customer/".$clean."");
   }else if($_POST['btn-detail-customer'] == "Delete"){
      header("Location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/customer");
   }
   
}else if(isset($_POST['btn-add-customer'])){
   header("Location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/add-customer");
   
}else if(isset($_POST['btn-edit-customer'])){
   
   if($_POST['btn-edit-customer'] == "Save Changes"){
	   
	  function redir_count_customer($post_user_fullname, $post_user_id){
	     $conn   = connDB();
		 
		 $sql    = "SELECT COUNT(*) AS rows FROM tbl_user WHERE user_fullname = '$post_user_fullname' AND `user_id` != '$post_user_id'";
		 $query  = mysql_query($sql, $conn);
		 $result = mysql_fetch_array($query);
		 
		 return $result;
	  }
	   
	  function redir_get_customer($post_user_id){
	     $conn   = connDB();
		 
		 $sql    = "SELECT * FROM tbl_user WHERE `user_id` = '$post_user_id'";
		 $query  = mysql_query($sql, $conn);
		 $result = mysql_fetch_array($query);
		 
		 return $result;
	  }
	  
	  $redirect_customer = redir_count_customer($_POST['user_first_name']." ".$_POST['user_last_name'], $_POST['user_id']);
	  
	  if($redirect_customer['rows'] > 0){
		 
		 $redir_get_customer = redir_get_customer($_POST['user_id']);
		 
		 if(cleanurl($_POST['user_first_name']." ".$_POST['user_last_name']) == $redir_get_customer['user_alias']){
			$redirect_edit_customer = $redir_get_customer['user_alias'];
		 }else{
		    $redirect_edit_customer = cleanurl($_POST['user_first_name']." ".$_POST['user_last_name'].$redirect_customer['rows']);
		 }
		 
	  }else{
		 $redirect_edit_customer = cleanurl($_POST['user_first_name']." ".$_POST['user_last_name']);
	  }
	  
      header("Location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/edit-customer/".$redirect_edit_customer);
   }else if($_POST['btn-edit-customer'] == "Save Changes & Exit"){
	  header("Location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/customer");
   }



/*
# ----------------------------------------------------------------------
# LOGIN
# ----------------------------------------------------------------------
*/
}else if(isset($_POST['btn-admin-login'])){
   
   if(isset($_POST['btn-admin-login'])){

      $username = $_POST['username'];
      $password = $_POST['password'];

      if($_POST['btn-admin-login'] == "Sign In"){
	
         $get_admin = admin_login($username, $password);

         if($get_admin['rows'] != 1){
			$_SESSION['alert'] = "error";
			$_SESSION['msg']   = "Login invalid";
			
		    header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/");
         }else{
            $_SESSION['admin'] = $get_admin['id'];
		    header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/product");
         }

      }else if($_POST['btn-admin-login'] == "Send Password"){

         $get_username = admin_forgot_password($username);

         if($get_username['rows'] != 1){
			$_SESSION['alert'] = "error";
			$_SESSION['msg']   = "Username not existed";
			
		    header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/");
         }else{
		    header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."");
         }

      }

   }


/*
# ----------------------------------------------------------------------
# FORGOT PASSWORD
# ----------------------------------------------------------------------
*/
}else if(isset($_POST['btn-admin-forgot'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/recover-password");

// GENERAL
}else if(isset($_POST['btn_general_index'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/general");


// HOME   
}else if(isset($_POST['btn-pages-home']) || isset($_POST['btn-link-promo']) || isset($_POST['btn-link-banner'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/home");
   
   if($_POST['btn-pages-home'] == "Save Changes & Exit"){
      header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/product");
   }



/*
# ----------------------------------------------------------------------
# CATEGORY
# ----------------------------------------------------------------------
*/
}else if(isset($_POST['btn-index-category'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/category");
}else if(isset($_POST['btn_add_category'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/add-category");
}else if($_POST['btn_detail_category']){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/detail-category/".$_POST['hidden_category_id']."/".cleanurl($_POST['category_name']));
}else if($_POST['btn_child_category']){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/child-category/".$_POST['hidden_category_parent_id']."/".cleanurl($_POST['hidden_category_parent']));



/*
# ----------------------------------------------------------------------
# COLOR MANAGER
# ----------------------------------------------------------------------
*/
}else if(isset($_POST['btn-index-color'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/color");
}else if(isset($_POST['btn_add_color'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/add-color");
}else if(isset($_POST['btn_detail_color'])){
	
	if($_POST['btn_detail_color'] == 'Delete'){
	   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/color");
	}else if($_POST['btn_detail_color'] == 'Save Changes'){
	   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/color-detail/".$_POST['hidden_color_id']."/".cleanurl($_POST['color_name']));
	}



/*
# ----------------------------------------------------------------------
# SIZE MANAGER
# ----------------------------------------------------------------------
*/
}else if(isset($_POST['btn-size-index'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/size");
}else if(isset($_POST['btn_add_size'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/add-size");
}else if(isset($_POST['btn_detail_size'])){
   
   if($_POST['btn_detail_size'] == 'Save Changes'){
	  header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/size-detail/".$_POST['hidden_size_id']."/".cleanurl($_POST['size_type_name']));
   }else if($_POST['btn_detail_size'] == 'Delete'){
	  header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/size");
   }




/*
# ----------------------------------------------------------------------
# SHIPPING
# ----------------------------------------------------------------------
*/
}else if(isset($_POST['btn-index-shipping'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/shipping");
   
}else if(isset($_POST['btn-edit-shipping'])){

   if($_POST['btn-edit-shipping'] == "Save Changes & Exit"){
      header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/shipping");
   }else{
	  
	  function redirect_get_latest_id_courier(){
	     $conn   = connDB();
		 
		 $sql    = "SELECT MAX(courier_id) AS latest_courier_id FROM tbl_courier";
		 $query  = mysql_query($sql, $conn);
		 $result = mysql_fetch_array($query);
		 
		 return $result;
	  }
	  
	  $redirect_latest_courier_id = redirect_get_latest_id_courier();
	  
      header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/edit-shipping/".$_POST['hidden_shipping_id']);
   }



// ADD SHIPPING
}else if(isset($_POST['btn-add-shipping'])){
   
   if($_POST['btn-add-shipping'] == "Save Changes & Exit"){
      header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/shipping");
   }else if($_POST['btn-add-shipping'] == "Save Changes"){
      header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/shipping/".$_REQUEST['sid']);
   }
   
// EDIT SHIPPING   
}else if(isset($_POST['btn-edit-shipping'])){

   if($_POST['btn-edit-shipping'] == "Save Changes & Exit"){
      header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/shipping");
   }else{
     header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/edit-shipping/".$_REQUEST['sid']);
   }

// ABOUT
}else if(isset($_POST['btn-about'])){
   
   if($_POST['btn-about'] == "Save Changes"){
      header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/about");
   }else{
      header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/product");
   }
   
}

// INFO
else if(isset($_POST['btn-infos'])){
   if($_POST['btn-infos'] == "Save Changes"){
      header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/contact");
   }else{
	   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/product");
   }
   

// STOCK MANAGER
}else if(isset($_POST['btn_index_stock'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/stock-manager");

}

// ACCOUNTS
else if(isset($_POST['btn-index-account'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/accounts");
}

// NOTIFICATION
else if(isset($_POST['btn_notification'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/notifications");
}

// PAYMENT
else if(isset($_POST['btn_payment'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/payment");
}

// ORDER DETAIL
else if(isset($_POST['btn-order-confirm'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/order-detailing/".$_POST['redirect_order_number']);
}



/* -- FRONT END -- */

// CONFIRM PAYMENT
else if(isset($_POST['btn-index-confirm'])){
   
   if($_POST['btn-index-confirm'] == "Submit"){
      header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/confirm-payment");   
   }
   
}
?>