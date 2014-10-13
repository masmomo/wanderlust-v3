<?php
if(empty($_SESSION['user_id'])){
  include("order-login.php");
}else{
?>

<?php
include('checkout/control.php');

/* -- FUNCTIONS -- */
/*
function get_countries(){
   $conn   = conndB();
   
   $sql    = "SELECT * FROM countries ORDER BY country_name ASC";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}


function get_provinces(){
   $conn   = conndB();
   
   $sql    = "SELECT * FROM province ORDER BY province_name ASC";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}



// CALL FUNCTION
$country  = get_countries();
$province = get_provinces();
*/

function get_payment(){
   $conn   = conndB();
   
   $sql    = "SELECT * FROM tbl_account ORDER BY account_bank ASC";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}

// CALL FUNCTION
$payment  = get_payment();

?>

<div class="container main">
  <img class="m_b_20" src="<?php echo $prefix_url;?>files/common/img_line-dotted.png" width="100%" height="2">
  <div class="content">

      <div class="row">

        <ul class="steps col-md-2 visible-md visible-lg">
          <li>Login</li>
          <li class="divider"></li>
          <li class="active">Checkout</li>
          <li class="divider"></li>
          <li>Finish</li>
        </ul>

        <div class="checkout col-md-8 col-xs-12">
          <div class="alert alert-danger hidden" style="margin-top: 15px">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <p>Error message goes here.</p>
          </div>  
          <form class="form-horizontal" method="post">
            <fieldset class="m_b_20">
              <h2 class="heading underlined">Shipping Details</h2>
              <div class="form-group" id="lbl_checkout_user_fname"> <!--has-error-->
                <label class="col-md-3 control-label">First Name</label>
                <div class="col-md-9">
                  <input type="text" class="form-control w50" name="checkout_user_fname" id="id_checkout_user_fname" value="<?php echo $global_user['user_first_name']?>">
                </div>
              </div>
              <div class="form-group" id="lbl_checkout_user_lname">
                <label class="col-md-3 control-label">Last Name</label>
                <div class="col-md-9">
                  <input type="text" class="form-control w50" name="checkout_user_lname" id="id_checkout_user_lname" value="<?php echo $global_user['user_last_name']?>">
                </div>
              </div>
              <div class="form-group" id="lbl_checkout_user_phone">
                <label class="col-md-3 control-label">Phone</label>
                <div class="col-md-9">
                  <input type="text" class="form-control w50" name="checkout_user_phone" id="id_checkout_user_phone" value="<?php echo $global_user['user_phone'];?>">
                </div>
              </div>
              <div class="form-group" id="lbl_checkout_user_address">
                <label class="col-md-3 control-label">Address</label>
                <div class="col-md-9">
				  <textarea id="id_checkout_user_address" name="checkout_user_address" class="form-control" rows="4"><?php echo $global_user['user_address'];?></textarea>
                </div>
              </div>
              <div class="form-group" id="lbl_checkout_user_country">
                <label class="col-md-3 control-label">Country</label>
                <div class="col-md-9">
                  <select class="form-control w50" name="checkout_user_country" id="id_checkout_user_country" onchange="ajaxProvince()">
                    <?php
					foreach($get_country as $get_country){
					   // INTERNATIONAL
					   //echo "<option value=\"".$get_country['country_name']."\">".$get_country['country_name']."</option>";
					   
					   // NATIONAL
					   $national = "Indonesia";
					   echo "<option ";
					   
					   if($get_country['country_name'] != $national){
					      echo 'disabled="disabled"';
					   }
					   
					   echo "value=\"".$get_country['country_name']."\">".$get_country['country_name']."</option>";
					}
					?>
                  </select>
                </div>
              </div>
              <div class="form-group" id="lbl_checkout_user_province">
                <label class="col-md-3 control-label">Province</label>
                <div class="col-md-9">
                  <select class="form-control w50" id="id_checkout_user_province" name="checkout_user_province" onChange="ajaxCity()">
                     <?php
					 echo "<option></option>";
					 foreach($province as $province){
					    echo "  <option value=\"".$province['province_name']."\" ";
						   
					    if($global_user['user_province'] == $province['province_name']){
						   echo 'selected="selected"';
						}
						
						echo ">".$province['province_name']."</option> \n";
					 }
					 ?>
                  </select>
                </div>
              </div>
              <div class="form-group" id="lbl_checkout_user_city">
                <label class="col-md-3 control-label">City</label>
                <div class="col-md-9" id="ajax_data_city">
                  <?php 
				  echo "<select class=\"form-control\" name=\"checkout_user_city\" id=\"id_checkout_user_city\" onChange=\"ajaxCourier()\">";
				  foreach($user_city as  $user_city){
				     echo "<option ";
				     
					 if($user_city['city_name'] == $global_user['user_city']){ 
					    echo "selected=\"selected\"";
					 }
					 
				     echo "value=\"".$user_city['city_name']."\">".$user_city['city_name']."</option> \n";
				  }
				  
				  echo "</select>";
                  ?>
                </div>
              </div>
              <div class="form-group" id="lbl_checkout_user_postal">
                <label class="col-md-3 control-label">Postal Code</label>
                <div class="col-md-9">
                  <input type="text" class="form-control w25" name="checkout_user_postal" id="id_checkout_user_postal" value="<?php echo $global_user['user_postal_code'];?>">
                </div>
              </div>
            </fieldset>

            <fieldset class="m_b_20">
              <h2 class="heading">Shipping Method</h2>
              <div class="form-group" id="lbl_checkout_user_shipping">
                <label class="col-md-3 control-label">Method</label>
                <div class="col-md-9">
                  	<div id="ajax_courier">

	                  <select class="form-control" id="id_checkout_user_shipping" onChange="setRate()">
	                    <option value="13" selected>JNE Regular - <?php $currency;?></option>
	                  </select>

	                </div>
                </div>
              </div>
            </fieldset>

            <fieldset>
              <h2 class="heading">Payment Method</h2>
              <div class="form-group">
                <label class="col-md-3 control-label">Method</label>
                <div class="col-md-9">
                  <select class="form-control" name="checkout_payment_method">
                    <?php
                    foreach($payment as $payment){
					  echo '<option value="'.$payment['account_bank'].'">Bank Transfer via '.$payment['account_bank'].'</option>'; 
					}
					?>
                    <!--<option>Credit Card</option>-->
                    <!--<option value="paypal">PayPal</option>-->
                  </select>
                </div>
              </div>
            </fieldset>

            <div class="clearfix">
              <button type="button" class="btn btn-primary pull-right hidden" style="margin-top: 10px" onclick="validateCheckout()">NEXT</button>
              <input type="submit" name="btn_submit_checkout" id="id_btn_submit_checkout" class="btn btn-primary pull-right" style="margin-top: 10px" value="NEXT"/>
              <a href="" class="btn btn-default pull-right" style="margin-top: 10px; margin-right: 10px">BACK</a>
            </div>
            
            <input type="text" class="hidden" name="hidden_checkout_country" id="id_hidden_checkout_country" value="<?php echo $global_user['user_country'];?>">
            <input type="text" class="hidden" name="hidden_checkout_province" id="id_hidden_checkout_province" value="<?php echo $global_user['user_province'];?>">
            <input type="text" class="hidden" name="hidden_checkout_city" id="id_hidden_checkout_city" value="<?php echo $global_user['user_city'];?>">
            
            <input type="text" class="hidden" name="hidden_checkout_courier" id="id_hidden_checkout_courier">
            <input type="text" class="hidden" id="hidden_checkout_amount" name="hidden_checkout_amount">
            <input type="text" class="hidden" id="hidden_checkout_discount" name="hidden_checkout_discount" value="<?php echo $_SESSION['amount_discount'];?>">
            <input type="text" class="hidden" id="hidden_checkout_total" name="hidden_checkout_total">
            <input type="text" class="hidden" id="order_amount_hidden" name="order_amount_hidden" value="<?php echo $_SESSION['amount_purchase'];?>">
			
          </form>

        </div> <!-- checkout -->

        <aside class="info col-md-2 col-sm-12 col-xs-12">

          <div class="box">
            <div class="title">Summary</div>
            <div class="content">
              <div class="info-row">
                <div class="subtitle">Total</div>
                <div class="price clearfix">
                  <div>
                    <p class="currency hidden"><?php echo price($_SESSION['amount_purchase']);?></p> 
                    <p class="amount" id=""><?php echo price($_SESSION['amount_purchase']);?></p>
                    <input type="text" class="hidden summary_option" value="<?php echo $_SESSION['amount_purchase'];?>" id="id_summary_amount">
                  </div>
                </div>
              </div>
              <div class="info-row" style="padding-bottom: 10px">
                <div class="subtitle">Shipping</div>
                <div class="price clearfix">
                  <div>
                    <p class="currency hidden"><?php $currency;?></p> 
                    <p class="amount" id="checkout_summary_shipping"></p>
                    <input type="text" class="hidden summary_option" id="id_summary_shipping">
                  </div>
                </div>
              </div>
              <div class="info-row" style="border-top: 1px solid #eee; padding-top: 10px">
                <div class="subtitle">Total</div>
                <div class="price clearfix">
                  <div>
                    <p class="currency hidden"><?=$currency;?></p> 
                    <p class="amount" id="total_summary"></p>
                  </div>
                </div>
              </div>
            </div>
          </div><!--box-->

          <div class="box">
            <div class="title">Help</div>
            <div class="content">
              <div class="info-row info-email text-center">
                <a href="mailto:<?php echo $info['email_display'];?>">Email Us</a>
              </div>
            </div>
          </div><!--box-->

        </aside>

      </div> <!--row-->

	  </div><!--.content-->
  </div><!--.container.main-->

<script src="<?php echo $prefix_url;?>script/checkout.js"></script>
<script>
$(document).ready(function(e) {
  
  selectCountry('<?php echo $global_user['user_country'];?>');
  
  //var user_province = $('#id_hidden_checkout_province').val();
  //function getSelect(<?php echo $global_user['user_province'];?>, <?php echo $global_user['user_city'];?>);
  
  $('#id_checkout_user_province option[value="<?php echo $global_user['user_province'];?>"]').attr('selected', 'selected');
  ajaxCity('<?php echo $global_user['user_city'];?>');

});
</script>
<?php
}
?>