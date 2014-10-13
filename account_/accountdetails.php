<?php
if(empty($_SESSION['user_id'])){
   include("account_/login.php");
}else{
?>

<?php
/* -- GET -- */
function validate_password($post_user_id, $post_password){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_user WHERE `user_id` = '$post_user_id' AND `user_password` = MD5('$post_password')";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function cek_alias($post_user_alias, $post_user_id){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_user WHERE `user_alias` = '$post_user_alias' AND `user_id` != '$post_user_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function get_alias($post_user_alias, $post_user_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_user WHERE `user_alias` = '$post_user_alias' AND `user_id` != '$post_user_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


/* -- UPDATE -- */
function update_account($post_user_first_name, $post_user_last_name, $post_user_email, $post_user_id, $post_user_alias){
   $conn   = connDB();
   
   $sql    = "UPDATE tbl_user SET `user_first_name` = '$post_user_first_name',
                                  `user_last_name` = '$post_user_last_name',
								  `user_email` = '$post_user_email',
								  `user_alias` = '$post_user_alias'
			  WHERE `user_id` = '$post_user_id'
			 ";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
}

function update_password($post_user_password, $post_user_id){
   $conn   = connDB();
   
   $sql    = "UPDATE tbl_user SET `user_password` = MD5('$post_user_password') WHERE `user_id` = '$post_user_id'";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
}


/* -- CONTROL -- */

if(isset($_POST['btn_edit_account'])){
   
   // DEFINED VARIABLE
   $user_first_name = clean_alphabet($_POST['account_user_first_name']);
   $user_last_name  = clean_alphabet($_POST['account_user_last_name']);
   $user_email      = clean_email($_POST['account_user_email']);
   $old_pass        = clean_alphanumeric($_POST['account_user_password']);
   $user_password   = clean_alphanumeric($_POST['account_user_cpassword']);
   $user_id         = $global_user['user_id'];
   
   if(empty($user_password)){
      $password = $global_user['user_password'];
   }else{
      $password = $user_password;
   }
   
   // CALL FUNCTION
   $validate = validate_password($user_id, $old_pass);
   
   // CHECK ALIAS
   $check = cek_alias(cleanurl($user_first_name." ".$user_last_name), $user_id);
   $get   = get_alias(cleanurl($user_first_name." ".$user_last_name), $user_id);
   
   if($check['rows'] > 0){
	  $user_alias = cleanurl($user_first_name." ".$user_last_name.((int) $check['rows'] + 1));
   }else{
      $user_alias = cleanurl($user_first_name." ".$user_last_name);
   }
   
   
   if(!empty($user_password)){
      
	  if($validate['rows'] > 0){
		 
         update_password($user_password, $user_id);
		 update_account($user_first_name, $user_last_name, $user_email, $user_id, $user_alias);
		 
		 $_SESSION['alert'] = "alert-success";
		 $_SESSION['msg']   = "Changes has been successfully saved";
	  }else{
         $_SESSION['alert'] = "alert-danger";
         $_SESSION['msg']   = "Old password wrong";
      }
	  
   }else{   
      update_account($user_first_name, $user_last_name, $user_email, $user_id, $user_alias);
   
      $_SESSION['alert'] = "alert-success";
      $_SESSION['msg']   = "Changes has been successfully saved";
   }
   
}
?>

<div class="container main">
  <div class="content">

      <ul class="breadcrumb">
        <li><a href="<?php echo $prefix_url."account/".$global_user['user_alias'];?>">Account</a></li>
        <li class="active">Edit Account Details</li>
      </ul>

      <div class="row">

        <ul class="list-group col-xs-4 visible-md visible-lg">
          <li class="list-group-item active">Account</li>
        </ul>
        
		<?php 
		//ALERT
		if(!empty($_SESSION['alert'])){
		?>
        <div class="col-xs-12 col-md-8">
          <div class="alert <?php echo $_SESSION['alert'];?>" id="alert_wrap">
            <button type="button" class="close" data-dismiss="alert" onclick="dismissAlert('alert_wrap','alert_msg')">&times;</button>
            <p id="alert_msg"><?php echo $_SESSION['msg']?></p>
            </div> 
        <?php
		}
		?>
		
          <form method="post" class="form-horizontal">
            <fieldset>
              <h1>Account Details</h1>
              <p>If you're a new customer, please sign up using the form below for faster checkout.</p>
              <div class="form-group" id="lbl_account_first_name">
                <label class="col-md-4 control-label">First Name</label>
                <div class="col-md-8">
                  <input type="text" class="form-control" value="<?php echo $global_user['user_first_name'];?>" name="account_user_first_name" id="id_account_user_first_name">
                </div>
              </div>
              <div class="form-group" id="lbl_account_last_name">
                <label class="col-md-4 control-label">Last Name</label>
                <div class="col-md-8">
                  <input type="text" class="form-control" value="<?php echo $global_user['user_last_name'];?>" name="account_user_last_name" id="id_account_user_last_name">
                </div>
              </div>
              <div class="form-group" id="lbl_account_email">
                <label class="col-md-4 control-label">Email</label>
                <div class="col-md-8">
                  <input type="text" class="form-control" value="<?php echo $global_user['user_email'];?>" name="account_user_email" id="id_account_user_email">
                </div>
              </div>
              <div class="form-group" id="lbl_account_password">
                <label class="col-md-4 control-label">Old Password</label>
                <div class="col-md-8">
                  <input type="password" class="form-control" name="account_user_password" id="id_account_user_password">
                </div>
              </div>
			        <div class="form-group" id="lbl_account_npassword">
                <label class="col-md-4 control-label">New Password</label>
                <div class="col-md-8">
                  <input type="password" class="form-control" name="account_user_npassword" id="id_account_user_npassword">
                </div>
              </div>
              <div class="form-group" id="lbl_account_cpassword">
                <label class="col-md-4 control-label">Retype New Password</label>
                <div class="col-md-8">
                  <input type="password" class="form-control" name="account_user_cpassword" id="id_account_user_cpassword">
                </div>
              </div>
            </fieldset>

			     <input type="button" class="btn btn-primary pull-right" onClick="validateAccount()" value="Save Changes">
            <input type="submit" value="submit" class="hidden" name="btn_edit_account" id="id_btn_edit_account">

            <a href="<?php echo $prefix_url."account/".$global_user['user_alias'];?>" class="btn btn-default pull-right">Back</a>
          </form>

        </div>

      </div> <!--row-->

  </div><!--.content-->
</div><!--.container.main-->

<script src="<?php echo $prefix_url."script/edit_account.js"?>">

<?php
if($_POST['btn_edit_account'] == ""){
   unset($_SESSION['alert']);
   unset($_SESSION['msg']);
}
?>

<?php
}
?>