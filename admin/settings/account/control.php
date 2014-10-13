<?php
$accounts = get_admin($_SESSION['admin']);

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
   
}
?>