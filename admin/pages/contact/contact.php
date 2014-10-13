<?php
include("control.php");
include("custom/pages/contact/control.php");
?>

<form method="post" enctype="multipart/form-data">

    <div class="subnav">
      <div class="container clearfix">
        <h1><span class="glyphicon glyphicon-earphone"></span> &nbsp; Contact</h1>
        <div class="btn-placeholder">
          <input type="submit" class="btn btn-success btn-sm" value="Save Changes" name="btn-infos">
        </div>
      </div>
    </div>

    <?php
      if(!empty($_SESSION['alert'])){?>
      
        <div class="alert <?php echo $_SESSION['alert'];?>">
        <div class="container"><?php echo $_SESSION['msg'];?></div>
      </div>
      <?php }?>

    <div class="container main">
            


      <div class="box row">
        <div class="desc col-xs-3">
          <h3>Content</h3>
          <p>Your company's contact information.</p>
        </div>
        <div class="content col-xs-9">
          <ul class="form-set">
            <li class="form-group row underlined">
              <label class="col-xs-3">Email to <span>*</span></label>
              <div class="col-xs-9">
                <input type="text" class="form-control" value="<?php echo $get_info['email'];?>" name="email">
                <p class="help-block">Message from Contact Us page will be sent here.</p>
              </div>
            </li>
            <li class="form-group row">
              <label class="col-xs-3">Email</label>
              <div class="col-xs-9">
                <input type="text" class="form-control" value="<?php echo $get_info['email_display'];?>" name="email_display">
              </div>
            </li>
            <li class="form-group row">
              <label class="col-xs-3">Tel.</label>
              <div class="col-xs-9">
                <input type="text" class="form-control" value="<?php echo $get_info['telephone'];?>" name="telephone">
              </div>
            </li>
            <li class="form-group row">
              <label class="col-xs-3">Tel. / Fax</label>
              <div class="col-xs-9">
                <input type="text" class="form-control" value="<?php echo $get_info['fax'];?>" name="fax">
              </div>
            </li>
            <li class="form-group row">
              <label class="col-xs-3">HP</label>
              <div class="col-xs-9">
                <input type="text" class="form-control" value="<?php echo $get_info['handphone'];?>" name="handphone">
              </div>
            </li>
          </ul>
        </div>
      </div><!--box-->

    </div><!--container main-->

</form>

<?php
if($_POST['btn-infos'] == ""){
unset($_SESSION['alert']);
unset($_SESSION['msg']);
}
?>

<script>
function cancelInfo(){
   location.href = "http://<?php echo $_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF']);?>"
}
</script>

<?php include("custom/pages/contact/contact.php");?>       