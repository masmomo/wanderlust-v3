<?php
/*
# ----------------------------------------------------------------------
# FUNCTIONS
# ----------------------------------------------------------------------
*/

function forgot_count_username($post_username){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_admin WHERE `username` = '$post_username'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function forgot_get_username($post_username){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_admin WHERE `username` = '$post_username'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function forgot_insert_log($post_admin_id, $post_username, $post_code, $post_status){
   $conn   = connDB();
   
   $sql    = "INSERT INTO tbl_forgot_log(`admin_id`, `admin_username`, `code`, `status`) VALUES('$post_admin_id', '$post_username', md5('$post_code'), '$post_status')";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
}


/*
# ----------------------------------------------------------------------
# CONTROL
# ----------------------------------------------------------------------
*/

if(isset($_POST['btn-admin-forgot'])){
   $username = clean_alphanum($_POST['usernames']);
   $count_forgot = forgot_count_username($username);
   
   if($count_forgot['rows'] > 0){
	  $get_forgot = forgot_get_username($username);
	  
	  $code = randomchr($length = 10, $letters = '123456789abcdefghijklmnopqrstuvwxyz');
	  
	  // INSERT INTO LOG
	  forgot_insert_log($get_forgot['id'], $get_forgot['username'], $code, 'n/a');
	  
	  $link_forgot = $prefix_url.md5("recover-password/".$get_forgot['username']."/".$code."/".date('Y-m-d'));
	  
	  // MAIL
	  $name      = $general['website_title']; 
	  $email     = $info['email']; 
      $recipient = $get_forgot['email']; 
	  $mail_body = '<body style="font-family: Helvetica, Arial, sans-serif; color:#fff" topmargin="0" leftmargin="0">
	                  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="overflow: hidden; padding-top: 15px">
					    <tbody>
						  <tr>
						    <td>
							  <table width="600" border="0" cellspacing="0" cellpadding="0" align="center" style="border-bottom: 1px solid #e0e0e0">
							    <tr>
								  <td>
								    <td style="padding-left: 15px; text-align: left;">
									  <span style="color: #333; font-size: 20px;">Website Name</span>
									</td>
									
									<td style="font-size: 12px; color: #fff; padding: 10px 15px; text-align: right">
									  <span style="line-height: 18px; color: #999"><b style="color: #333">RESET PASSWORD</b> </span>
									</td>
								  </td>
								</tr>
						      </table>
							</td>
					      </tr>
						</tbody>
				      </table>
					  
					  <table width="600" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:12px; overflow: hidden; line-height: 20px; color: #333">
					    <tbody>
						  <tr>
						    <td width="600" style="padding: 25px">
							  You have requested to reset your password for username <b>'.$get_forgot['username'].'</b> <br>
							  <br>
							  <a href="'.$prefix_url.'md5(recover" style="color: #ffffff;
											    background-color: #5cb85c;
											    border-color: #4cae4c;display: inline-block;
											    padding: 6px 12px;
											    margin-bottom: 0;
											    font-size: 14px;
											    font-weight: normal;
											    line-height: 1.428571429;
											    text-align: center;
											    white-space: nowrap;
											    vertical-align: middle;
											    cursor: pointer;
											    border: 1px solid transparent;
											    border-radius: 4px;
											    padding: 5px 10px;
											    font-size: 12px;
											    line-height: 1.5;
											    border-radius: 3px;
											    text-decoration: none;">Reset Password</a><br>
							 <br>
							 If you did not request to reset your password, please ignore this email.
						   </td>
						 </tr>
					   </tbody>
					 </table>
					 
					 <table width="600" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:11px; color: #999; margin-top:15px">
					   <tbody>
					     <tr>
						   <td style="padding-left:20px; padding-right:20px; padding-bottom: 20px">
						     &copy; 2013 '.$general['website_title'].'. Powered by <a style="color: #666; text-decoration: none" href="http://www.antikode.com">Antikode</a>. <br><br>
						   </td>
						 </tr>
					   </tbody>
					 </table>
				   </body>';
				   
	  $subject   = '['.$general['website_title'].'] Forgot Password';
	  $headers   = "Content-Type: text/html; charset=ISO-8859-1\r\n".
	  $headers  .= "From: ".$general['website_title']." <" .$info['email']. ">\r\n"; //optional headerfields
	  
	  mail($recipient, $subject, $mail_body, $headers);
	  
	  $_SESSION['alert'] = "success";
	  $_SESSION['msg']   = "<strong>Success.</strong> Your reset password email has been sent to your registered email address.";
	  
   }else{
      $_SESSION['alert'] = "error";
	  $_SESSION['msg']   = "Please check your username";
   }
   
}


?>

<form method="post" enctype="multipart/form-data"> 

<?php 
/* --- SHOW ALERT --- */
if(!empty($_SESSION['alert'])){
   echo '<div class="alert '.$_SESSION['alert'].'" id="alert-msg-pass">';
   echo '<div class="container text-center">';
   echo $_SESSION['msg'];
   echo '</div>';
   echo '</div>';
}

/* --- UNSET ALERT --- */
if($_POST['btn-admin-forgot'] == ""){
   unset($_SESSION['alert']);
   unset($_SESSION['msg']);
}
?>

            <div class="container main">
              <div class="box row login">
                <div class="navbar-login clearfix">
                  <div class="navbar-brand"><img src="<?php echo $prefix_url;?>files/common/logo.png" alt="logo"></div>
                  <h1><?php echo $general['website_title'];?> Admin</h1>
                </div>
                
                <div class="content">
                  <ul class="form-set clearfix">
                    <p class="m_b_15">Forgot your password? Write down your username below and we'll send the instructions to reset your password.</p>
                      <li class="form-group row">
                        <label class="col-xs-3 control-label">Username</label>
                        <div class="col-xs-9">
                          <input type="text" class="form-control" autocomplete="off" style="width: 100%" name="usernames" id="username-admin">
                        </div>
                      </li>
                      <li class="btn-placeholder m_b_15">
                        <a href="<?php echo substr($prefix_url,0,-1);?>"><input type="button" class="btn btn-default btn-sm" value="Back"></a>
                        <input type="submit" class="btn btn-success btn-sm" value="Submit" name="btn-admin-forgot" id="forgot-password">
                      </li>
                    </ul>
                  </div><!--.content-->
                </div><!--.box.row-->
              </div><!--.container.main-->           
</form>

<script type="text/javascript" src="<?php echo $prefix_url?>/script/login.js"></script>

        