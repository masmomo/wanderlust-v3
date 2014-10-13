<?php
// CALL FUNCTION
$notification = get_notification();

if(isset($_POST['btn_notification'])){
   
   // DEFINED $_POST VARIABLE
   $notification_id = $_POST['notification_id'];
   $email_order     = $_POST['email_order'];
   $email_warehouse = $_POST['email_warehouse'];
   
   // CALL FUNCTION
   $check = count_notification();
   
   if($check['rows'] > 0){
	   
      // UPDATE
	  update_notification($notification_id, $email_order, $email_warehouse);
	  
	  $_SESSION['alert'] = "success";
	  $_SESSION['msg']   = "Changes successfully saved.";
	  
   }else{
	   
      // INSERT
	  insert_notification($notification_id, $email_order, $email_warehouse);
	  
	  $_SESSION['alert'] = "success";
	  $_SESSION['msg']   = "Item has been sucessfully saved.";
   }
   
}
?>