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
    <div class="content">

      <div class="row">

        <div class="col-xs-12">
          <h1>My Account</h1>
          <p>Hello <?php echo strtoupper($global_user['user_first_name']);?>, here are a couple of things you can do in your account.</p>
        </div>
        <div class="col-xs-4 hidden-xs">
          <img class="img-responsive" src="<?php echo $prefix;?>holder.js/100%x350">
        </div>
        <ul class="col-xs-12 col-sm-8">
          <li><a href="<?php echo $prefix_url."order-history";?>"><span class="glyphicon glyphicon-shopping-cart"></span>See order history</a></li>
          <li><a href="<?php echo $prefix_url."confirm";?>"><span class="glyphicon glyphicon-usd"></span>Confirm payment</a></li>
          <li><a href="<?php echo $prefix_url."account-details";?>"><span class="glyphicon glyphicon-user"></span>Change account details</a></li>
          <li><a href="<?php echo $prefix_url."shipping-details";?>"><span class="glyphicon glyphicon-envelope"></span>Change shipping details</a></li>
        </ul>

      </div> <!--.row-->

    </div><!--.content-->
  </div><!--.container.main-->
<?php
	}
?>