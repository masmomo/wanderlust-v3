<?php
include("get.php");
include("update.php");
include("control.php");
?>

<form method="post" autocomplete="off">
  
  <div class="subnav">
    <div class="container clearfix">
      <h1><span class="glyphicon glyphicon-user"></span> &nbsp; Account <?php echo $_SESSION['admin_id']?></h1>
      <div class="btn-placeholder">
        <input type="button" class="btn btn-success btn-sm" value="Save Changes" name="btn-index-account" onclick="validationAdminAccount()">
        <input type="submit" class="btn btn-success btn-sm hidden" value="Save Changes" name="btn-index-account" id="id_btn_account">
        <input type="hidden" name="admin_id" value="<?php echo $accounts['id']?>">
      </div>
    </div>
  </div>
  
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
  if($_POST['btn-index-account'] == ""){
     unset($_SESSION['alert']);
     unset($_SESSION['msg']);
  }
  ?>

  <div class="container main">
    <div class="box row">
      <div class="desc col-xs-3">
        <h3>Account Details</h3>
        <p>Basic details of your account.</p>
      </div>
      <div class="content col-xs-9">
        <ul class="form-set">
          <li class="form-group row">
            <label class="control-label col-xs-3" for="role">Role <span>*</span></label>
            <div class="col-xs-9">
              <select class="form-control" id="admin-role" name="admin_role" disabled="disabled">
                <option value="null"></option>
                <option value="super admin">Super Admin</option>
                <option value="order">Order Manager</option>
                <option value="content creator">Content Creator</option>
              </select>
            </div>
          </li>
                  
          <li class="form-group row">
            <label class="control-label col-xs-3" for="username">Username <span>*</span></label>
            <div class="col-xs-9">
              <input type="text" class="form-control" id="id_admin_username" name="admin_username" value="<?php echo $accounts['username']?>">
            </div>
          </li>
          <li class="form-group row">
            <label class="control-label col-xs-3" for="username">Email <span>*</span></label>
            <div class="col-xs-9">
              <input type="text" class="form-control" id="id_admin_email" name="admin_email" value="<?php echo $accounts['email']?>">
            </div>
          </li>
          <li class="form-group row">
            <label class="control-label col-xs-3" for="old-password">Old Password </label>
            <div class="col-xs-9">
              <input type="password" class="form-control" id="id_admin_old_password" name="admin_old_password">
            </div>
          </li>
          <li class="form-group row">
            <label class="control-label col-xs-3" for="new-password">New Password </label>
            <div class="col-xs-9">
              <input type="password" class="form-control" id="id_admin_new_password" name="admin_new_password">
            </div>
          </li>
          <li class="form-group row">
            <label class="control-label col-xs-3" for="r_new-password">Retype New Password </label>
            <div class="col-xs-9">
              <input type="password" class="form-control" id="id_admin_r_new_password" name="admin_r_new_password">
            </div>
          </li>
        </ul>
      </div>
    </div><!--.box-->

  </div><!--.container.main-->
            
</form>

<script src="<?php echo $prefix_url;?>script/admin_account.js"></script>
<script>
$('#admin-role option[value="<?php echo $accounts['role']?>"]').attr('selected', 'selected');
</script>
            