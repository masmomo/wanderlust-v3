<?php
if(empty($_SESSION['user_id'])){
   include("account_/login.php");
}else{
?>

<?php
/* -- GET -- */
/* -- UPDATE -- */
/* -- CONTROL -- */
?>

  <div class="container main myaccount"> 
    <img class="img-responsive" src="<?php echo $prefix_url;?>files/common/img_small-0.jpg" width="100%">
    <div class="content" style="margin-top: -10px">

      <!--<p class="m_b_20">Dear <strong><?php echo strtoupper($global_user['user_first_name']);?></strong>, lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt.</p>-->
      <ul class="account-box row-5">
        <li class="col-xs-3"><a href="<?php echo $prefix_url."order-history";?>">See Order History</a></li>
        <li class="col-xs-3"><a href="<?php echo $prefix_url."confirm";?>">Confirm Payment</a></li>
        <li class="col-xs-3"><a href="<?php echo $prefix_url."account-details";?>">Change Account Details</a></li>
        <li class="col-xs-3"><a href="<?php echo $prefix_url."shipping-details";?>">Change Shipping Details</a></li>
      </ul>

    </div><!--.content-->
  </div><!--.container.main-->
<?php
	}
?>