<?php
include("get.php");
include("update.php");
include("control.php");
?>

<form method="post" autocomplete="off">
  
  <div class="subnav">
    <div class="container clearfix">
      <h1><span class="glyphicon glyphicon-usd"></span> &nbsp; Payment</h1>
      <div class="btn-placeholder">
        <input type="button" class="btn btn-success btn-sm" value="Save Changes" id="id_button">
        <input type="submit" class="btn btn-success btn-sm hidden" value="Save Changes" name="btn_payment" id="id_btn_payment">
      </div>
    </div>
  </div>
  
  <?php
  if(!empty($_SESSION['alert'])){
  ?>
     <div class="alert <?php echo $_SESSION['alert'];?>">
       <div class="container"><?php echo $_SESSION['msg'];?></div>
     </div>
  <?php }?>

  <div class="container main">

    <div class="box row">
      <div class="desc col-xs-3">
        <h3>Transfer Payment Details</h3>
        <p>Details for your transfer payment method for customers.</p>
      </div>
      <div class="content col-xs-9">
        <ul class="form-set">
          <li class="form-group row">
            <label class="control-label col-xs-3">Payment Method Name</label>
            <div class="col-xs-9">
              <select class="form-control" id="id_bank_method" name="payment_method" onchange="ajaxGet()">
                 <?php
				 foreach($payment as $payment){
                    echo '<option value="'.$payment['id'].'">'.$payment['account_bank'].'</option>';
				 }
				 ?>
              </select>
            </div>
          </li>
          
          <div id="ajax_payment">
          
          
          
          </div><!--ajax_payment-->
          
        </ul>
      </div>
    </div><!--.box-->

  </div><!--.container.main-->
            
</form>

<?php
if($_POST['btn_payment'] == ""){
   unset($_SESSION['alert']);
   unset($_SESSION['msg']);
}
?>

<style>
.has-error { border:1px solid #f00;}
</style>

<script src="<?php echo $prefix_url;?>script/payment.js"></script>
            