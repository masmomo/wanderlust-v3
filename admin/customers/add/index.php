<?php
include("control.php");
include("custom/customers/add/control.php");

?>

<form name="add-customer" method="post" id="add-customer" autocomplete="off">

  <div class="subnav">
    <div class="container clearfix">
      <h1><span class="glyphicon glyphicon-user"></span> &nbsp; <a href="http://<?php echo $prefix_url."customer"?>">Customers</a> <span class="info">/</span> Add Customer</h1>
      <div class="btn-placeholder">
        <a href="<?php echo $prefix_url."/customer"?>">
          <input type="button" class="btn btn-default btn-sm" value="Cancel" name="btn-add-customer">
        </a>
        <input type="button" class="btn btn-success btn-sm" value="Save Changes" name="btn-add-customer" id="btn-add" onclick="validateAddCust()">
        <input type="submit" class="btn btn-success btn-sm" value="Save Changes" name="btn-add-customer" id="smt-add">
        <!--<input type="button" class="btn green main hidden" value="Save Changes &amp; Exit" name="btn-add-customer">-->
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
        <h3>Account Details</h3>
        <p>Account details of your customer.</p>
      </div>
      <div class="content col-xs-9">
        <ul class="form-set">
          <li class="form-group row">
            <label class="control-label col-xs-3" for="name" id="first_name">First Name <span>*</span></label>
            <div class="col-xs-9">
              <input type="text" class="form-control" id="first-name" name="user_first_name">
            </div>
          </li>
          <li class="form-group row">
            <label class="control-label col-xs-3" for="name" id="last_name">Last Name <span>*</span></label>
            <div class="col-xs-9">
              <input type="text" class="form-control" id="last-name" name="user_last_name">
            </div>
          </li>
          <li class="form-group row">
            <label class="control-label col-xs-3" for="email" id="lbl_phone">Phone <span>*</span></label>
            <div class="col-xs-9" id="wrap-phone">
              <input type="text" class="form-control" id="phone" name="user_phone">
            </div>
          </li>
          <li class="form-group row">
            <label class="control-label col-xs-3" for="email" id="lbl_email">Email <span>*</span></label>
            <div class="col-xs-9">
              <input type="text" class="form-control" id="email" name="user_email">
            </div>
          </li>
          <li class="form-group row">
            <label class="control-label col-xs-3" for="password" id="lbl-password">Password <span>*</span></label>
            <div class="col-xs-9">
              <input type="password" class="form-control" id="password" name="user_password">
            </div>
          </li>
          <li class="form-group row">
            <label class="control-label col-xs-3" for="c_password" id="confirm-password">Confirm Password <span>*</span></label>
            <div class="col-xs-9">  
              <input type="password" class="form-control" id="c_password" name="c_password">
            </div>
          </li>
          <li class="form-group row-divider hidden"></li>
          <li class="form-group row hidden">
            <label class="control-label col-xs-3" for="category">Class <span>*</span></label>
            <div class="col-xs-9">
              <select class="form-control" id="category" name="category">
                <option selected value="Normal">Normal</option>
                <option value="Member">Member</option>
              </select>
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
            <label class="control-label col-xs-3" for="product-name">Address Name</label>
            <div class="col-xs-9">
              <input type="text" class="form-control" id="product-name" name="" value="Address 1" disabled>
            </div>
          </li>
          <li class="form-group row">
            <label class="control-label col-xs-3" for="product-name" id="lbl-address">Address Details</label>
            <div class="col-xs-9">
              <!--<input type="text" class="form-control" id="product-name" name="product-name">-->
              <textarea class="form-control" name="user_address" rows="5" id="address"></textarea>
            </div>
          </li>
          <li class="form-group row hidden">
            <label class="control-label col-xs-3" class="invisible" for="product-name">Address 2 <span>*</span></label>
            <div class="col-xs-9">
              <input type="text" class="form-control" id="product-name" name="product-name">
            </div>  
          </li>
          <li class="form-group row">
            <label class="control-label col-xs-3" for="category" id="lbl-country">Country </label>
            <div class="col-xs-9">
              <select class="form-control" id="country" name="user_country" onchange="getProvince()">
                <option value="0"></option>
                <?php
                foreach($getCountry as $get_country){
                   echo "<option value=\"".$get_country['country_name']."\">".$get_country['country_name']."</option>";
                }
                ?>
              </select>
              <p class="help-block help-danger hidden" id="alert-country">Please select your country</p>
            </div>
          </li>
          <li class="form-group row" id="id-province">
            <label class="control-label col-xs-3" for="category" id="lbl_province">Province </label>
            <div class="col-xs-9" id="wrap-province">
              <select class="form-control" id="province" name="user_province" onchange="getCity()">
                <?php
                  foreach($getProvince as $province){
                    echo "<option value=\"".$province['province_name']."\">".$province['province_name']."</option>";
                  }
                ?>
              </select>
              <p class="help-block help-danger hidden" id="alert-province">Please select your province</p>
            </div>
          </li>
          <li class="form-group row" id="id-city">
            <label class="control-label col-xs-3" for="product-name" id="lbl-city">City </label>
            <div class="col-xs-9" id="wrap-city">
              <input type="text" class="form-control" id="city" name="user_city">
            </div>
          </li>
          <li class="form-group row">
            <label class="control-label col-xs-3" for="product-name" id="lbl_postal">Postal Code </label>
            <div class="col-xs-9">
              <input type="text" class="form-control" id="postal" name="user_postal_code" style="width: 150px">
            </div>
          </li>
          
          <span class="hidden">
          <li class="form-group row-divider hidden"></li>
          <li class="form-group row">
            <label class="control-label col-xs-3" for="product-name">Address Name</label>
            <div class="col-xs-9">
              <input type="text" class="form-control" id="product-name" name="product-name" value="Address 1" disabled>
            </div>
          </li>
          <li class="form-group row">
            <label class="control-label col-xs-3" for="product-name">Address Details</label>
            <div class="col-xs-9">
              <input type="text" class="form-control" id="product-name" name="product-name">
            </div>
          </li>
          <li class="form-group row">
            <label class="control-label col-xs-3" class="invisible" for="product-name">Address 2 <span>*</span></label>
            <div class="col-xs-9">
              <input type="text" class="form-control" id="product-name" name="product-name">
            </div>
          </li>
          <li class="form-group row">
            <label class="control-label col-xs-3" for="product-name">City </label>
            <div class="col-xs-9">
              <input type="text" class="form-control" id="product-name" name="product-name">
            </div>  
          </li>
          <li class="form-group row">
            <label class="control-label col-xs-3" for="category">Province </label>
            <div class="col-xs-9">
              <select class="form-control" id="category" name="category">
                <option selected value=""></option>
                <option value="">Jakarta</option>
              </select>
            </div>
          </li>
          <li class="form-group row">
            <label class="control-label col-xs-3" for="category">Country </label>
            <div class="col-xs-9">
              <select class="form-control" id="category" name="category">
                <option selected value=""></option>
                <option value="">Indonesia</option>
              </select>
            </div>
          </li>
          <li class="form-group row">
            <label class="control-label col-xs-3" for="product-name">Postal Code </label>
            <div class="col-xs-9">
              <input type="text" class="form-control" id="product-name" name="product-name" style="width: 150px">
            </div>
          </li>
          </span>
        </ul>
      </div>
    </div><!--box-->                

  </div><!--main-content-->
            
</form>

<script>
$('#smt-add').hide();

function validateAddCust(){
   var fname  = $('#first-name').val();
   var lname  = $('#last-name').val();
   var email  = $('#email').val();
   var phone  = $('#phone').val();
   var nonum  = /^\d*[0-9](|.\d*[0-9]|,\d*[0-9])?$/
   var atpos  = email.indexOf("@");
   var dotpos = email.lastIndexOf(".");
   var pass   = $('#password').val();
   var pass2  = $('#c_password').val();
   
   var address  = $('#address').val();
   var country  = $('#country option:selected').val();
   var province = $('#province option:selected').val();
   var city     = $('#city').val();
   var postal   = $('#postal').val();
   
   $('#first_name').attr('style','');
   $('#last_name').attr('style','');
   $('#phone').removeClass("empty");
   $('#lbl_email').attr('style','');
   $('#lbl-password').attr('style','');
   $('#confirm-password').attr('style','');
   
   $('#lbl-address').attr('style','');
   $('#lbl-country').attr('style','');
   $('#alert-country').addClass("hidden");
   $('#lbl_province').attr('style','');
   $('#alert-province').addClass("hidden");
   $('#lbl-city').attr('style','');
   $('#lbl_postal').attr('style','');

   if(fname == ""){
      $('#first_name').attr('style', 'color:#f00;');
	  $('#first-name').attr('placeholder', 'Required');
   }else if(lname == ""){
      $('#last_name').attr('style', 'color:#f00;');
	  $('#last-name').attr('placeholder', 'Required');
   }else if(phone == ""){
	  $('#phone').addClass("empty");
	  $('#phone').attr('placeholder', 'required');
   }else if(phone.length < 8){
	  $('#wrap-phone').html('<input type="text" class="form-control empty" id="phone" name="user_phone" placeholder="please provide valid number">');
   }else if(!nonum.test(phone)){
	  $('#wrap-phone').html('<input type="text" class="form-control empty" id="phone" name="user_phone" placeholder="Numbers only and no whitespace allowed">');
   }else if(email == ""){
      $('#lbl_email').attr('style', 'color:#f00;');
	  $('#email').attr('placeholder', 'Required');
   }else if(atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= email.length){
      $('#lbl_email').attr('style', 'color:#f00;');
	  $('#email').val('');
	  $('#email').attr('placeholder', 'Please enter correct email');
   }else if(pass == ""){
      $('#lbl-password').attr('style', 'color:#f00;');
	  $('#password').attr('placeholder', 'Required');
   }else if(pass2 == ""){
      $('#confirm-password').attr('style', 'color:#f00;');
	  $('#c_password').attr('placeholder', 'Required');
   }else if(pass != pass2){
      $('#confirm-password').attr('style', 'color:#f00;');
	  $('#c_password').val('');
	  $('#c_password').attr('placeholder', 'Password do not match');
   }else if(address == ""){
      $('#lbl-address').attr('style', 'color:#f00;');
	  $('#address').attr('placeholder', 'Required');
   }else if (country == "0"){
      $('#lbl-country').attr('style', 'color:#f00;');
	  $('#alert-country').removeClass("hidden");
   }else if (province == "0"){
      $('#lbl_province').attr('style', 'color:#f00;');
	  $('#alert-province').removeClass("hidden");
   }else if(city == ""){
      $('#lbl-city').attr('style', 'color:#f00;');
	  $('#city').attr('placeholder', 'Required');
   }else if(postal == ""){
      $('#lbl_postal').attr('style', 'color:#f00;');
	  $('#postal').attr('placeholder', 'Required');
   }else{
	  $('#smt-add').click();
   }

}

$('#id-province').hide();
$('#id-city').hide();

function getProvince(){
   var country  = $('#country option:selected').val();
   
   $('#wrap-province').html('<select class="form-control" id="province" name="user_province" onchange="getCity()"><?php foreach($getProvince as $province){echo "<option value=\"".$province['province_name']."\">".$province['province_name']."</option>";}?></select>');
   
   $('#id-city').slideUp("fast");
   
   if(country == "Indonesia"){
      $('#id-province').slideDown("fast");
   }else if(country != "Indonesia"){
	  $('#id-province').slideDown("fast");
      $('#wrap-province').html('<input type="text" class="form-control" name="user_province">');
	  $('#id-city').slideDown("fast");  
   }
   
}

function getCity(){
   var province = $('#province option:selected').val();
   
   var city = $.ajax({
	             type : "POST",
				 url  : "customers/add/ajax.php",
				 data : { province:province},
				 error: function(jqXHR, textStatus, errorThrown) {
					    
						}
						
				 }).done(function(data) {
					$('#id-city').slideDown("fast");
				    $('#wrap-city').html(data);
				 });
}


</script>

<?php
if($_POST['btn-add-customer'] == ""){
   unset($_SESSION['alert']);
   unset($_SESSION['msg']);
}
?>

<?php
include('custom/customers/add/index.php');
?>
