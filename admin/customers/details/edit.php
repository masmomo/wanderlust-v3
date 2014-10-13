<?php
include("control.php");
include("custom/customers/details/control.php");
?>

<script>
$(document).ready(function() {
   var country  = $('#country option:selected').val();
   var value_province = $('#province').val();
   
   if(country == "Indonesia"){
	  $('#wrap-province-text').hide();
	  $('#wrap-province').slideDown("fast");
	  
	  $('#wrap-city-text').hide();
	  $('#wrap-city').slideDown("fast");
	  
   }else if(country != "Indonesia"){
	  $('#wrap-province-text').slideDown("fast");
	  $('#wrap-province').hide();
	  
	  $('#wrap-city-text').slideDown("fast");
	  $('#wrap-city').hide();
   }
   
   if(country == "Indonesia"){
      backupProvince();
	  backupCity();
   }else{
      backupProvinceText();
	  backupCityText();
   }

});
</script>



<form method="post" enctype="multipart/form-data">
  
  <input type="hidden" name="user_id" value="<?php echo $user_detail['user_id'];?>" id="hidden-user-id">

  <div class="subnav">
    <div class="container clearfix">
      <h1><span class="glyphicon glyphicon-user"></span> &nbsp; <a href="<?php echo $prefix_url."customer"?>">Customers</a> <span class="info">/</span> Edit Customer</h1>
      <div class="btn-placeholder">
        <a href="<?php echo $prefix_url."customer/".cleanurl($user_name);?>">
           <input type="button" class="btn btn-grey btn-sm main" value="Cancel">
        </a>
        
        <input type="button" class="btn btn-success btn-sm" value="Save Changes" onclick="validateEditUser('Save')">
        <input type="button" class="btn btn-success btn-sm hidden" value="Save Changes &amp; Exit" onclick="validateEditUser('Exit')">
        
        <input type="submit" class="btn btn-success btn-sm hidden" value="Save Changes" name="btn-edit-customer" id="btn-save">
        <input type="submit" class="btn btn-success btn-sm hidden" value="Save Changes &amp; Exit" name="btn-edit-customer" id="btn-exit">
      </div>
    </div>
  </div>
            
  <?php
  if(!empty($_SESSION['alert'])){
     echo '<div class="alert '.$_SESSION['alert'].'">';
	 echo '<div class="container">'.$_SESSION['msg'].'</div>';
	 echo '</div>';
  }
  
  if($_POST['btn-edit-customer'] == ""){
     $_SESSION['alert'] = "";
	 $_SESSION['msg']   = "";
  }
  ?>

  <div class="container main">

      <div class="box row">
        <div class="desc col-xs-3">
          <h3>Account Details</h3>
          <p>Account details of your customer.</p>
        </div>
        <div class="content col-xs-9">
          <ul class="form-set">
            <li class="form-group row">
              <input type="hidden" name="user_id" value="<?php echo $user_detail['user_id']?>">
              <input type="hidden" name="user_alias" value="<?php echo $user_detail['user_alias'];?>">
              
              <label class="control-label col-xs-3" for="product-name">First Name <span>*</span></label>
              <div class="col-xs-9">
                <input type="text" class="form-control" id="user-first-name" name="user_first_name" value="<?php echo $user_detail['user_first_name'];?>">
              </div>
            </li>
            <li class="form-group row">
              <label class="control-label col-xs-3" for="product-name">Last Name <span>*</span></label>
              <div class="col-xs-9">
                <input type="text" class="form-control" id="user-last-name" name="user_last_name" value="<?php echo $user_detail['user_last_name'];?>">
              </div>
            </li>
            <li class="form-group row">
              <label class="control-label col-xs-3" for="product-name">Email <span>*</span></label>
              <div class="col-xs-9">
                <input type="text" class="form-control" id="user-email" name="user_email" value="<?php echo $user_detail['user_email'];?>">
              </div>
            </li>
            <li class="form-group row">
              <label class="control-label col-xs-3" for="product-name">Phone <span>*</span></label>
              <div class="col-xs-9">
                <input type="text" class="form-control" id="user-phone" name="user_phone" value="<?php echo $user_detail['user_phone'];?>">
              </div>
            </li>
            <!--
            <li class="form-group row">
                <label class="control-label col-xs-3" for="o_password">Old Password <span>*</span></label>
                <input type="password" class="form-control col-xs-9" id="o_password" name="o_password">
            </li>
            <li class="form-group row">
                <label class="control-label col-xs-3" for="password">New Password <span>*</span></label>
                <input type="password" class="form-control col-xs-9" id="password" name="password">
            </li>
            <li class="form-group row">
                <label class="control-label col-xs-3" for="c_password">Confirm Password <span>*</span></label>
                <input type="password" class="form-control col-xs-9" id="c_password" name="c_password">
            </li>
            -->
            <li class="form-group row">
              <label class="control-label col-xs-3" for="category">Class <span>*</span></label>
              <div class="col-xs-9">
                <select class="form-control" id="category" name="user_status" disabled="disabled">
                    <option value="Normal">Normal</option>
                    <option value="Gold">Gold</option>
                    <option value="Platinum">Platinum</option>
                </select>
                <input type="hidden" name="user_status_backup" value="<?php echo $user_detail['user_status'];?>">
              </div>
            </li>
          </ul>
        </div>
      </div><!--box-->

      <div class="box row">
        <div class="desc col-xs-3">
          <h3>Shipping Details</h3>
          <p>Customer's shipping details.</p>
        </div>
        <div class="content col-xs-9">
          <ul class="form-set">
            <li class="form-group row">
              <label class="control-label col-xs-3">Address Name</label>
              <div class="col-xs-9">
                <input class="form-control" type="text" value="Address 1" id="address-title" disabled>
                <p class="help-block" style="color: #40a035"><i>Default address</i></p>
              </div>
            </li>
            <li class="form-group row">
              <label class="control-label col-xs-3" for="product-name">Address Details</label>
              <div class="col-xs-9">
                <!--<input type="text" class="form-control col-xs-9" id="product-name" name="product-name">-->
                <textarea class="form-control" rows="5" name="user_address" id="address-detail"><?php echo $user_detail['user_address'];?></textarea>
              </div>
            </li>
            <li class="form-group row">
              <label class="control-label col-xs-3">Country </label>
              <div class="col-xs-9">
                <select class="form-control" name="user_country" id="country" onchange="getProvince()">
                  <?php
				  echo "<option></option>";
				  foreach($getCountry as $get_country){
				     echo "<option value=\"".$get_country['country_name']."\">".$get_country['country_name']."</option>";
				  }
            	  ?>
                </select>
              </div>
            </li>
            <li class="form-group row">
              <label class="control-label col-xs-3">Province </label>
              <div class="col-xs-9" id="wrap-province">
                <select class="form-control" id="province" name="user_province" onchange="backupProvince()">
                <?php
				foreach($getProvince as $province){
				   echo "<option value=\"".$province['province_name']."\">".$province['province_name']."</option>";
				}
    			?>
                </select>
              </div>
              <!--
              <div class="col-xs-9" id="wrap-province-text">
                 <input type="text" class="form-control" name="user_province" onkeyup="backupProvinceText()" id="text-province" value="<?php echo $user_detail['user_province'];?>">
              </div>
              -->
              
              <input type="hidden" name="user_province_backup" id="province-backup">
            </li>
            <li class="form-group row">
              <label class="control-label col-xs-3">City </label>
              <div class="col-xs-9" id="wrap-city">
                <select class="form-control" id="city-select" name="user_city" onchange="backupCity()">
                   <?php
                   foreach($getCity as $city){
					  echo "<option value=\"".$city['courier_city']."\">".$city['courier_city']."</option>";
				   }
				   ?>
                </select>
              </div>
              <!--
              <div class="col-xs-9" id="wrap-city-text">
                 <input type="text" class="form-control" name="user_city" value="<?php echo $user_detail['user_city'];?>" id="text-city" onkeyup="backupCityText()">
              </div>
              
              <input type="hidden" name="user_city_backup" id="city-backup">
              -->
            </li>
            
            <li class="form-group row">
              <label class="control-label col-xs-3">Postal Code </label>
              <div class="col-xs-9">
                <input type="text" class="form-control col-xs-9" style="width: 150px" name="user_postal_code" value="<?php echo $user_detail['user_postal_code'];?>">
              </div>
            </li>

          </ul>
        </div>
      </div><!--box-->  

    </div><!--.container.main-->
    
    </form>

<script src="<?php echo $prefix_url?>/script/edit_customer.js"></script>
<script>
$('#country option[value="<?php echo $user_detail['user_country']?>"]').attr('selected', 'selected');
$('#province option[value="<?php echo $user_detail['user_province']?>"]').attr('selected', 'selected');

$(document).ajaxStop(function(e){
   $('#city-select option[value="<?php echo $user_detail['user_city']?>"]').attr('selected', 'selected');
});

$('#category option[value=<?php echo $user_detail['user_status']?>]').attr('selected', 'selected');
</script>

<?php
include('custom/customers/details/edit.php');
?>         