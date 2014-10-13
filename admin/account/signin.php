<?php
function password($post_username, $post_password){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_admin WHERE `username` = '$post_username' AND `password` = md5($post_password)";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function get_username($post_username){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_admin WHERE `username` = '$post_username'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


$username = clean_alphanum($_POST['username']);
$password = clean_alphanum($_POST['password']);

if($_POST['btn-admin-login'] == "Sign In"){
   
   $get_admin = admin_login($username, $password);
   
   if($get_admin['rows'] != 1){
      $_SESSION['alert'] = "error";
	  $_SESSION['msg']   = "<strong>Login invalid.</strong> Please check your username and password.";
	  
	  $forgot = get_username($username);
	  
	  if($forgot['rows'] > 0){
	     $_SESSION['username'] = $username;
	  }else{
	     $_SESSION['username'] = "error";
	  }
	  
   }else{
	  $_SESSION['admin'] = $get_admin['id'];
	  ini_set('session.gc_probability', '1');
	  
	  if(isset($_SESSION['alert'])){
	     unset($_SESSION['alert']);
		 unset($_SESSION['msg']);
	  }
	  
   }

}
?>

<form method="post" enctype="multipart/form-data"> 

<?php 
if(!empty($_SESSION['alert'])){
   echo '<div class="alert '.$_SESSION['alert'].'" id="alert-msg-login">';
   echo '<div class="container text-center">';
   echo $_SESSION['msg'];
   echo '</div>';
   echo '</div>';
}

if($_POST['btn-admin-login'] == ""){
   unset($_SESSION['alert']);
   unset($_SESSION['msg']);
}
?>

            <div class="container main">
              
              <!--<div class="overlay over-signin <?php if(!empty($_SESSION['alert'])){ echo "error";}?>" id="overlay-error">-->
              <div class="box row login">
                <div class="navbar-login clearfix">
                  <div class="navbar-brand">
                    <img src="<?php echo $prefix_url;?>files/common/logo.png" alt="logo" class="hidden">
                    <img src="<?php echo $prefix_url.'static/thimthumb.php?src='.$general['logo'].'&w=40&h=40&q=80';?>" class="">
                  </div>
                  <h1><?php echo $general['website_title'];?> Admin</h1>
                </div>
                
                <div class="content">
                  <ul class="form-set clearfix">
                    <li class="form-group row">
                      <label class="col-xs-3 control-label">Username</label>
                      <div class="col-xs-9">
                        <input type="text" class="form-control" autocomplete="off" name="username" id="id_username">
                      </div>
                    </li>
                    
                    <li class="form-group row">
                      <label class="col-xs-3 control-label">Password</label>
                      <div class="col-xs-9">
                        <input type="password" class="form-control" autocomplete="off" name="password" id="id_password">
                      </div>
                    </li>
                    
                    <li class="btn-placeholder m_b_15">
                    
					  <?php
					  //if(isset($_SESSION['alert']) and $_SESSION['username'] != "error"){
					     echo "<a class=\"m_r_15\" href=\"".$prefix_url."forgot-password\" id=\"ahref-forgot\">Forgotten your password?</a>";
					  //}
					  ?>
                      
                      <input type="button" class="btn btn-success btn-sm" value="Sign In" onclick="validateLogin()" id="btn_login">
                      <input type="submit" class="btn btn-success btn-sm hidden" value="Sign In" name="btn-admin-login" id="btn-login">
                    </li>
                  </ul>
                  
                </div><!--.content-->
                
              </div><!--.box.row-->
              
            </div><!--.container.main-->
            
          </form>

<script type="text/javascript" src="<?php echo $prefix_url?>/script/login.js"></script>

        