<?php
/* -- GET -- */
function validate_user($post_username, $post_password){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_user WHERE `user_email` = '$post_username' AND `user_password` = MD5('$post_password')";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query) or die(mysql_error());
   
   return $result;
}

function get_user($post_username, $post_password){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_user WHERE `user_email` = '$post_username' AND `user_password` = MD5('$post_password')";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query) or die(mysql_error());
   
   return $result;
}

function generate_alias($post_user_fullname){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_user WHERE `user_fullname` LIKE '$post_user_fullname'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query) or die(mysql_error());
   
   return $result;
}

function validate_email($post_user_email){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_user WHERE `user_email` = '$post_user_email'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query) or die(mysql_error());
   
   return $result;
}



/* -- UPDATE -- */
function register_user($post_first_name, $post_last_name, $post_user_fullname, $post_email, $post_password, $post_user_alias, $post_user_created_date){
   $conn  = connDB();
   
   $sql   = "INSERT INTO tbl_user (`user_first_name`, `user_last_name`, `user_fullname`, `user_email`, `user_password`, `user_alias`, `user_created_date`) 
                            VALUES('$post_first_name', '$post_last_name', '$post_user_fullname', '$post_email', MD5('$post_password'), '$post_user_alias', '$post_user_created_date')
			";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}


//WISHLIST
function insert_wishlist($ajx_user,$date,$ajx_type,$ajx_stock,$ajx_qty){
   $conn   = connDB();

   $sql    = "INSERT INTO tbl_wishlist(user_id,wishlist_date,type_id,stock_name,item_quantity)
			  VALUES ('$ajx_user','$date','$ajx_type','$ajx_stock','$ajx_qty')";
   $query  = mysql_query($sql, $conn);

}

/* -- CONTROL -- */

// DEFINED VALUE
$user_email = clean_email($_POST['username']);
$password   = clean_alphanumeric($_POST['password']);
$url        = $prefix_url."login";

// CALL FUNCTION
$validate = validate_user($user_email, $password);

if(isset($_POST['btn_login'])){
   
   if($validate['rows'] > 0){
      //CALL FUNCTION
      $user = get_user($user_email, $password);
	  
	  // CONSTRUCT SESSION
	  $_SESSION['user_id'] = $user['user_id'];
	
	//WISHLIST
	

	  if($_SESSION['wishlist_tmp']=='1'){
		 $ajx_type = $_SESSION['wishlist_tmp_type'];
		 $ajx_stock = $_SESSION['wishlist_tmp_stock'];
		 $ajx_qty = $_SESSION['wishlist_tmp_qty'];
		 $ajx_user = $user['user_id'];
		 $date = date('Y-m-d H:i:s');

		 insert_wishlist($ajx_user,$date,$ajx_type,$ajx_stock,$ajx_qty);

		 $_SESSION['wishlist_tmp']=0;
	  }
	  
	  // REDIRECT
	  if($act != "order/bag"){
         
		 if($current_url == $url){
?>
<script>
location.href = "<?php echo $prefix_url."account/".md5($user['user_alias']);?>";
</script>
<?php
		 }else{
?>
<script>
location.href = "<?php echo $url;?>";
</script>
<?php
		 }

	  }else{
?>
<script>
location.href = "<?php echo $prefix_url."checkout";?>";
</script>
<?php 
	  }
	  
   }else{
?>
<script>
//location.href = "<?php echo $prefix_url."/login";?>";
</script>
<?php
      // ALERT
	  $_SESSION['alert'] = "alert-danger";
	  $_SESSION['msg']   = "Incorrect email or password.";
   }
   
}

if(isset($_POST['btn_register'])){
   // DEFINED VALUE
   $fname       = clean_alphabet($_POST['register_fname']);
   $lname       = clean_alphabet($_POST['register_lname']);
   $fullname    = $fname." ".$lname;
   $email       = clean_email($_POST['register_email']);
   $password    = clean_alphanumeric($_POST['regeister_repassword']);
   $check       = generate_alias($fullname);
   $date        = current_date_sql();
   $check_email = validate_email(clean_email($_POST['register_email']));
   
   
   if($check_email['rows'] > 0){
      // ALERT
	  $_SESSION['alert'] = "alert-danger";
	  $_SESSION['msg']   = "The e-mail that you entered has been registered.";
   }else{
   
      if($check['rows'] > 0){
         $user_alias = cleanurl($fullname.$check['rows']);
      }else{
	     $user_alias = cleanurl($fullname);
      }
   
      register_user($fname, $lname, $fullname, $email, $password, $user_alias, $date);
	  
      //CALL FUNCTION
      $user = get_user($email, $password);
	  
      // CONSTRUCT SESSION
      $_SESSION['user_id'] = $user['user_id'];

	  //WISHLIST
	  
	  if($_SESSION['wishlist_tmp']=='1'){
		 $ajx_type = $_SESSION['wishlist_tmp_type'];
		 $ajx_stock = $_SESSION['wishlist_tmp_stock'];
		 $ajx_qty = $_SESSION['wishlist_tmp_qty'];
		 $ajx_user = $user['user_id'];
		 $date = date('Y-m-d H:i:s');
		
		 insert_wishlist($ajx_user,$date,$ajx_type,$ajx_stock,$ajx_qty);
		
		 $_SESSION['wishlist_tmp']=0;
	  }
		
		
   
   
      if($act != "order/bag"){
         
		 if($current_url == $url){
?>
<script>
location.href = "<?php echo $prefix_url."account/".$user_alias;?>";
</script>
<?php
		 }else{
?>
<script>
location.href = "<?php echo $url;?>";
</script>
<?php
		 }
?>
         <script>
	     location.href = "<?php echo $prefix_url."account/".cleanurl($user_alias);?>";
         </script>
<?php
      }else{
?>
         <script>
	     location.href = "<?php echo $prefix_url."checkout";?>";
         </script>
<?php
      }
   
   }
   
}
?>    
    
    <div class="container main"> 
      <img class="m_b_20" src="<?php echo $prefix_url;?>files/common/img_line-dotted.png" width="100%" height="2">
      <div class="content clearfix">

      <div class="row-20">

        <div class="col-md-6 col-xs-12">
          <form method="post" class="form-horizontal" autocomplete="off">
            <h2 class="h6 heading">RETURNING CUSTOMER</h2>
            <p class="m_b_20">Already registered? Log in using the form below.</p>

            <?php 
            //ALERT
            if(!empty($_SESSION['alert']) and isset($_POST['btn_login'])){
            ?>
                  <div class="alert <?=$_SESSION['alert']?>" style="margin-top: 15px;">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <p><?php echo $_SESSION['msg']?></p>
                  </div>  
            <?php
            }
            ?>
            
            <div class="form-group" id="lbl_login_username">
              <label class="col-md-4 control-label">Email</label>
              <div class="col-md-8">
                <input type="text" class="form-control input-sm" name="username" id="id_login_username" onfocus="enterLogin()">
              </div>
            </div>
            <div class="form-group" id="lbl_login_password">
              <label class="col-md-4 control-label">Password</label>
              <div class="col-md-8">
                <input type="password" class="form-control input-sm" style="margin-bottom: 10px" id="id_login_password" name="password" onfocus="enterLogin()">
                <a style="cursor: pointer" data-toggle="modal" data-target="#forgotModal">Forgot password?</a>
              </div>
            </div>

            <div class="forgot-password modal fade" id="forgotModal">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <p class="h5 modal-title">Retrieve your password</p>
                  </div>
                  <div class="modal-body">
                     
                    <div id="ajax_forgot_password">
                    </div>
                    
                    <p style="margin-bottom: 15px">Input your email in the box below to retrieve your password.</p>
                    <div class="form-group" style="margin-bottom: 0" id="lbl_forgot_email">
                      <label class="col-xs-3 control-label">Email</label>
                      <div class="col-xs-9">
                        <input type="text" class="form-control input-sm" id="id_forgot_email">
                        <a href="#" class="btn btn-primary pull-right m_t_10" onClick="vaildateForgotPassword()">SUBMIT</a>
                        <span onClick="ajaxForgotPassword()" id="btn_forgot" class="hidden">button</span>
                      </div>
                    </div>
                  </div>
                </div><!-- modal-content -->
              </div><!-- modal-dialog -->
            </div><!-- modal -->

		  	    <button type="button" class="btn btn-primary pull-right m_t_10" onClick="validateLogin()">LOGIN</button>
            <input type="submit" class="hidden" id="btn_login" name="btn_login" value="login">
          </form>
        </div>

        <div class="col-xs-12 col-md-6">
          <form method="post" class="form-horizontal" autocomplete="off">
            <h2 class="h6 heading">NEW CUSTOMER</h2>
		
            <p class="m_b_20">If you're a new customer, please sign up using the form below for faster checkout.</p>

            <?php 
            //ALERT
            if(!empty($_SESSION['alert']) and isset($_POST['btn_register'])){
            ?>
                  <div class="alert alert-danger" style="margin-top: 15px;">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <p><?php echo $_SESSION['msg']?></p>
                  </div>
              <?php
            }
            ?>

            <div class="form-group" id="lbl_register_fname">
              <label class="col-md-4 control-label">First Name</label>
              <div class="col-md-8">
                <input type="text" class="form-control input-sm" id="id_register_fname" name="register_fname">
              </div>
            </div>
            <div class="form-group" id="lbl_register_lname">
              <label class="col-md-4 control-label" >Last Name</label>
              <div class="col-md-8">
                <input type="text" class="form-control input-sm" id="id_register_lname" name="register_lname">
              </div>
            </div>
            <div class="form-group" id="lbl_register_email">
              <label class="col-md-4 control-label">Email</label>
              <div class="col-md-8">
                <input type="text" class="form-control input-sm" id="id_register_email" name="register_email">
              </div>
            </div>
            <div class="form-group" id="lbl_register_password">
              <label class="col-md-4 control-label">Password</label>
              <div class="col-md-8">
                <input type="password" class="form-control input-sm" id="id_register_password" name="register_password">
              </div>
            </div>
            <div class="form-group" id="lbl_register_repassword">
              <label class="col-md-4 control-label">Retype Password</label>
              <div class="col-md-8">
                <input type="password" class="form-control input-sm" id="id_register_repassword" name="regeister_repassword">
              </div>
            </div>
		  	    <button type="button" class="btn btn-primary pull-right m_t_10" onClick="validateRegister()">CREATE NEW ACCOUNT</button>
            <input type="submit" value="submit" class="hidden" id="btn_register" name="btn_register">
          </form>
        </div>

      </div> <!--row-->

      </div><!--.content-->
    </div><!--.container.main-->

	<?php
	if($_POST['btn_login'] == "" || $_POST['btn_register'] == ""){
	   unset($_SESSION['alert']);
	   unset($_SESSION['msg']);
	}
	?>
	
    <script src="<?php echo $prefix_url;?>script/login.js"></script>