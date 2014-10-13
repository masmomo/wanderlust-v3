<?php
include("get.php");
include("update.php");
include("control.php");
?>

<form method="post" autocomplete="off">
  
  <div class="subnav">
    <div class="container clearfix">
      <h1><span class="glyphicon glyphicon-comment"></span> &nbsp; Notifications</h1>
      <div class="btn-placeholder">
        <input type="button" class="btn btn-success btn-sm hidden" value="Save Changes" onclick="validation()" id="btn_validation">
        <input type="submit" class="btn btn-success btn-sm " value="Save Changes" name="btn_notification" id="id_btn_notification">
        <input type="hidden" name="notification_id" value="<?php echo $notification['notification_id']?>">
      </div>
    </div>
  </div>
    
	<?php
    if(!empty($_SESSION['alert'])){?>
      <div class="alert <?php echo $_SESSION['alert'];?>">
        <div class="container">
          <?php echo $_SESSION['msg'];?>
        </div>
      </div>
    <?php }?>

  <div class="container main">

    <div class="box row">
      <div class="desc col-xs-3">
        <h3>Notification Details</h3>
        <p>Details on your admin panel notifications.</p>
      </div>
      <div class="content col-xs-9">
        <ul class="form-set">
          <li class="form-group row">
            <label class="control-label col-xs-3" for="">Order Email <span>*</span></label>
            <div class="col-xs-9">
              <input type="text" class="form-control" id="id_email_order" name="email_order" value="<?php echo $notification['email_order'];?>">
              <p class="help-block">Email to receive order notifications from customers.</p>
            </div>
          </li>
          <li class="form-group row">
            <label class="control-label col-xs-3" for="">Warehouse Email <span>*</span></label>
            <div class="col-xs-9">
              <input type="text" class="form-control" id="id_email_wareshouse" name="email_warehouse" value="<?php echo $notification['email_warehouse'];?>">
              <p class="help-block">Email to receive delivery order from admin.</p>
            </div>
          </li>
        </ul>
      </div>
    </div><!--.box-->

  </div><!--.container.main-->
            
</form>

<?php
if($_POST['btn_notification'] == ""){
   unset($_SESSION['alert']);
   unset($_SESSION['msg']);
}
?>

<style>
.has-error{ border:1px solid #F00;}
</style>

<script>
function validation(){
   var order        = $('#id_email_order').val();
   var atorder      = order.indexOf("@");
   var dotorder     = order.lastIndexOf(".");
   var warehouse    = $('#id_email_wareshouse').val();
   var atwarehouse  = warehouse.indexOf("@");
   var dotwarehouse = warehouse.lastIndexOf(".");
   var nonum        = /^\d*[0-9](|.\d*[0-9]|,\d*[0-9])?$/
   
   if(order == "" || atorder < 1 || dotorder < atorder + 2 || dotorder + 2 >= order.length){
      $('#id_email_order').addClass('has-error');
   }else if(warehouse == "" || atwarehouse < 1 || dotwarehouse < atwarehouse + 2 || dotwarehouse + 2 >= warehouse.length){
      $('#id_email_wareshouse').addClass('has-error');
   }else{
	  $('#id_btn_notification').click();
   }
   
}

$('#btn_validation').click(function(){
   validation();
});
</script>
            