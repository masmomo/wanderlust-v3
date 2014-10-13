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
	  
	  // REDIRECT
	  if($act != "order/bag"){
         
		 if($current_url == $url){
?>
<script>
location.href = "<?php echo $prefix_url."my-account/".$user['user_alias']?>";
</script>
<?php
		 }else{
?>
<script>
location.href = "<?php echo $uri;?>";
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
   
   
      if($act != "order/bag"){
         
		 if($current_url == $url){
?>
<script>
location.href = "<?php echo $prefix_url."my-account/".$user_alias;?>";
</script>
<?php
		 }else{
?>
<script>
location.href = "<?php echo $uri;?>";
</script>
<?php
		 }
?>
         <script>
	     location.href = "<?php echo $prefix_url."my-account/".cleanurl($user_alias);?>";
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
  <div class="content">

      <div>

        <ul class="steps col-md-2 visible-md visible-lg">
          <li class="active">Login</li>
          <li class="divider"></li>
          <li>Checkout</li>
          <li class="divider"></li>
          <li>Finish</li>
        </ul>

        <div class="col-xs-8">
          <div class="col-xs-12">
                
                <?php 
				//ALERT
				if(!empty($_SESSION['alert']) and isset($_POST['btn_register'])){
				?>
                <div class="alert <?php echo $_SESSION['alert'];?>">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <p><?php echo $_SESSION['msg']?></p>
                </div>
                <?php
				}
				?> 
                
                <?php 
				//ALERT
				if(!empty($_SESSION['alert']) and isset($_POST['btn_login'])){
				?>
                <div class="alert <?php echo $_SESSION['alert'];?>">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <p><?php echo $_SESSION['msg']?></p>
                </div>
                <?php
				}
				?>
            
            <form method="post" class="form-horizontal" autocomplete="off">
              <fieldset>
                <h2 class="heading">Returning customer? <?php echo $randomize;?><span class="head-light">log in to access your account.</span></h2>
                
                <div class="form-group" id="lbl_login_username">
                  <label class="col-xs-3 control-label">Email</label>
                  <div class="col-xs-9">
                    <input type="text" class="form-control input-sm" name="username" id="id_login_username">
                  </div>
                </div>
                <div class="form-group" id="lbl_login_password">
                  <label class="col-xs-3 control-label">Password</label>
                  <div class="col-xs-9">
                    <input type="password" class="form-control input-sm" style="margin-bottom: 10px" id="id_login_password" name="password">
                    <a data-toggle="modal" href="#forgotModal">Forgot password?</a>
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

                <button type="button" class="btn btn-primary pull-right" onClick="validateLogin()">LOGIN</button>
                <input type="submit" class="hidden" id="btn_login" name="btn_login" value="login">
              </fieldset>
            </form>
          </div>

          <div class="col-xs-12 m_t_20">
            <form method="post" class="form-horizontal" autocomplete="off">
              <fieldset>
                <h2 class="heading">New Customer? <span class="head-light">Create an account for better shopping experience.</span></h2>
                
                <div class="form-group" id="lbl_register_fname">
                  <label class="col-xs-3 control-label">First Name</label>
                  <div class="col-xs-9">
                    <input type="text" class="form-control input-sm" id="id_register_fname" name="register_fname">
                  </div>
                </div>
                <div class="form-group" id="lbl_register_lname">
                  <label class="col-xs-3 control-label">Last Name</label>
                  <div class="col-xs-9">
                    <input type="text" class="form-control input-sm" id="id_register_lname" name="register_lname">
                  </div>
                </div>
                <div class="form-group" id="lbl_register_email">
                  <label class="col-xs-3 control-label">Email</label>
                  <div class="col-xs-9">
                    <input type="text" class="form-control input-sm" id="id_register_email" name="register_email">
                  </div>
                </div>
                <div class="form-group" id="lbl_register_password">
                  <label class="col-xs-3 control-label">Password</label>
                  <div class="col-xs-9">
                    <input type="password" class="form-control input-sm" id="id_register_password" name="register_password">
                  </div>
                </div>
                <div class="form-group" id="lbl_register_repassword">
                  <label class="col-xs-3 control-label">Retype Password</label>
                  <div class="col-xs-9">
                    <input type="password" class="form-control input-sm" id="id_register_repassword" name="regeister_repassword">
                  </div>
                </div>
                <button type="button" class="btn btn-primary pull-right" onClick="validateRegister()">CREATE NEW ACCOUNT</button>
                <input type="submit" value="submit" class="hidden" id="btn_register" name="btn_register">
                
              </fieldset>
            </form>
          </div>

        </div>

        <div class="col-xs-2">
          <aside class="info">

          <div class="box">
            <div class="title">Summary</div>
            <div class="content">
              <div class="info-row">
                <div class="subtitle">Total</div>
                <div class="price clearfix">
                  <div>
                    <p class="amount"><?php echo price($_SESSION['amount_purchase']);?></p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          </aside>
        </div>

      </div> <!--row-->


        </div><!--.content-->
      </div><!--.container.main-->

<script src="<?php echo $prefix_url.'script/login.js'?>"></script>
<script>
function openOverlay() {
   $('#overlayhelp').removeClass('hidden')
}

function closeOverlay() {
   $('#overlayhelp').addClass('hidden')
}
</script>

