<?php
// DEFINED VARIABLE
$recover_name = $_REQUEST['name'];
$recover_code = $_REQUEST['code'];
$recover_time = $_REQUEST['time'];

function check_recover_time($post_end_time, $post_start_time){
   $conn   = connDB();
   
   $sql    = "SELECT DATEDIFF('$post_end_time', '$post_start_time') AS left_days";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

$check_time = check_recover_time(date('Y-m-d'), $_REQUEST['time']);

if($check_time['left_days'] > 0){

}else{
   
   function count_recover($post_name, $post_code){
      $conn   = connDB();
   
      $sql    = "SELECT COUNT(*) AS rows FROM tbl_forgot_log WHERE `admin_username` = '$post_name' AND `code` = MD5('$post_code')";
      $query  = mysql_query($sql, $conn);
      $result = mysql_fetch_array($query);
   
      return $result;
   }

   function update_recover($post_name, $post_code){
      $conn   = connDB();
   
      $sql    = "UPDATE tbl_forgot_log SET `status` = '$post_status' WHERE `admin_username` = '$post_name' AND `code` = MD5('$post_code')";
      $query  = mysql_query($sql, $conn) or die(mysql_error());
   }
   
   
   // CALL FUNCTION
   $check_link = count_recover($recover_name, $recover_code);
   
   if($check_link['rows'] > 0){
      
	  if(isset($_POST['btn-admin-recover'])){
	     
	  }
   
?>

<form method="post" enctype="multipart/form-data" autocomplete="off"> 

<?php if(!empty($_SESSION['alert'])){?>
<div class="alert <?php echo $_SESSION['alert'];?>" id="alert-msg-pass">
  <div class="container text-center">
    <?php echo $_SESSION['msg'];?>
  </div>
</div>
<?php }?>

            <div class="container main">

                <!--<div class="overlay over-signin <?php if(!empty($_SESSION['alert'])){ echo "error";}?>" id="overlay-error">-->

                <div class="box row login">

                    <div class="navbar-login clearfix">
                      <div class="navbar-brand"><img src="<?php echo $prefix_url;?>files/common/logo.png" alt="logo"></div>
                      <h1>Antikode Admin</h1>
                    </div>

                    <div class="content">
                    
                        
                            <ul class="form-set clearfix">
                                <p class="m_b_15">Reset password for <strong><?php echo $recover_name;?></strong></p>
                                <li class="form-group row">
                                    <label class="col-xs-4 control-label">New Password</label>
                                    <div class="col-xs-8">
                                      <input type="text" class="form-control" style="width: 100%" id="id_password" name="password">
                                    </div>
                                </li>
                                <li class="form-group row">
                                    <label class="col-xs-4 control-label">Retype Password</label>
                                    <div class="col-xs-8">
                                      <input type="text" class="form-control" autocomplete="off" style="width: 100%" id="id_cpassword" name="cpassword">
                                    </div>
                                </li>
                                <li class="btn-placeholder m_b_15">
                                  <a href="<?php echo $prefix_url;?>"><input type="button" class="btn btn-default btn-sm" value="Back"></a>
                                  <input type="button" class="btn btn-success btn-sm" value="Reset Password" id="id_btn_recover" onclick="validateRecover()">
                                  <input type="submit" class="btn btn-success btn-sm" value="Reset Password" id="id_btn_admin_recover" name="btn-admin-recover">
                              </li>
                            </ul>
                            
                    </div><!--.content-->
                
                </div><!--.box.row-->

            </div><!--.container.main-->           
</form>

<?php
if($_POST['btn-admin-login'] == ""){
   unset($_SESSION['alert']);
   unset($_SESSION['msg']);
}
?>

<script>
function validateRecover(){
   var pass  = $('#id_password').val();
   var cpass = $('#id_cpassword').val();
   
   if(pass == ""){
      $('#id_password').attr('placeholder', 'required');
   }else if(cpass == ""){
      $('#id_cpassword').attr('placeholder', 'required');
   }else if(pass != cpass){
      $('#id_cpassword').val('');
      $('#id_cpassword').attr('placeholder', 'required');
      $('#id_cpassword').focus();
   }else{
      $('#id_btn_admin_recover').click();
   }
   
}

$(document).keypress(function(e) {
   
   if(e.which == 13) {
      $('#id_btn_recover').click();
   }
   
});
</script>

<script type="text/javascript" src="<?php echo $prefix_url?>/script/login.js"></script>

<?php
      
   }else{
     echo "<div class=\"alert error\" id=\"alert-msg-pass\">";
	 echo "   <div class=\"container text-center\">";
	 echo        "Your session has been expired";
	 echo "<br><br>";
	 
	 echo "<a href=\"".$prefix_url."\">";
	 echo "   <b>back</b>";
	 echo "</a>";
	 
	 echo "   </div>";
	 echo "</div>";
	 
	 unset($_SESSION['alert']);
	 unset($_SESSION['msg']);
	 
   }
   
}
?>

        