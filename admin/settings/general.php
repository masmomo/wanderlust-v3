<?php
include("get.php");
include("update.php");
include("control.php");
include("ajax.php");
?>

<form method="post" enctype="multipart/form-data">

  <div class="subnav">
    <div class="container clearfix">
      <h1><span class="glyphicon glyphicon-cog"></span> &nbsp; General</h1>
      <div class="btn-placeholder">
        <input type="submit" class="btn btn-success btn-sm" value="Save Changes" name="btn_general_index">
      </div>
    </div>
  </div>
  
  <?php 
  if(!empty($_SESSION['alert'])){
     echo '<div class="alert '.$_SESSION['alert'].'">';
     echo '<div class="container">'.$_SESSION['msg'].'</div>';
     echo '</div>';
  }
  
  if($_POST['btn_general_index'] == ''){
     unset($_SESSION['alert']);
     unset($_SESSION['msg']);
  }
  ?>

  <div class="container main">

      <div class="box row">
        <div class="desc col-xs-3">
          <h3>Site Details</h3>
          <p>Basic details of your website.</p>
        </div>
        <div class="content col-xs-9">
          <ul class="form-set">
            <li class="form-group row">
              <label class="control-label col-xs-3" for="url">URL <span>*</span></label>
              <div class="col-xs-9">
                <input type="text" class="form-control" id="url" name="url" value="<?php echo $general['url'];?>">
              </div>
            </li>
            <li class="form-group row">
              <label class="control-label col-xs-3" for="website-name">Website Title <span>*</span></label>
              <div class="col-xs-9">
                <input type="text" class="form-control" id="website-name" name="website_title" value="<?php echo $general['website_title'];?>">
                <p class="help-block">Short title of your website that will be used as a title of your home page.</p>
              </div>
            </li>
            <li class="form-group row">
              <label class="control-label col-xs-3" for="website-description">Website Description <span>*</span></label>
              <div class="col-xs-9">
                <textarea class="form-control" rows="5" id="website-description" name="website_description"><?php echo preg_replace("/\n/","\n<br>",$general['website_description']);?></textarea class="form-control">  
                <p class="help-block">Short description of your website that will be used as a meta description.</p>
              </div>
            </li>
            <li class="form-group row">
              <label class="control-label col-xs-3" for="website-description">Website Keywords <span>*</span></label>
              <div class="col-xs-9">
                <textarea class="form-control" rows="5" id="website-keywords" name="website_keywords"><?php echo preg_replace("/\n/","\n<br>",$general['website_keywords']);?></textarea class="form-control">  
                <p class="help-block">Keywords of your website that will be used as a meta keywords.</p>
              </div>
            </li>

            
            <li class="form-group row">
              <label class="control-label col-xs-3">Admin Logo</label>
              <div class="col-xs-9">
                <div class="color-thumb edit" id="picture" onclick="openBrowser()">
                   <img class="" id="upload-image" width="40px;" src="<?php echo $prefix_url.'static/thimthumb.php?src='.$general['logo'].'&w=40px&h=40px&q=80';?>">
                </div>
                <p class="help-block">Recommended dimensions of 40 x 40 px.</p>
                <span id="tester">
                <input type="file" name="color_image" id="color_files" onchange="readURL(this)" class="hidden"/>
                </span><!--tester-->
              </div>
              <input type="hidden" name="hidden_logo" value="<?php echo $general['logo'];?>">
            </li>
          </ul>
        </div>
      </div><!--box-->

      <div class="box row">
        <div class="desc col-xs-3">
          <h3>Google Analytics</h3>
          <p>Google analytics code.</p>
        </div>
        <div class="content col-xs-9">
          <ul class="form-set">
            <li class="form-group row">
              <label class="control-label col-xs-3" for="google">Google Analytics Code <span>*</span></label>
              <div class="col-xs-9">
                <input type="text" class="form-control" id="google" name="google_analytics" value="<?php echo $general['analytics_code'];?>">
              </div>
            </li>
          </ul>
        </div>
      </div><!--.box-->

      <div class="box row">
        <div class="desc col-xs-3">
          <h3>Company Details</h3>
          <p>Your company details.</p>
        </div>
        <div class="content col-xs-9">
          <ul class="form-set hidden">
            <li class="form-group row">
              <label class="control-label col-xs-3" for="phone">Phone</label>
              <div class="col-xs-9">
                <input type="text" class="form-control" id="phone" name="company_phone" value="<?php echo $general['company_phone'];?>">
              </div>
            </li>
			 <li class="form-group row">
	              <label class="control-label col-xs-3" for="email">Email</label>
	              <div class="col-xs-9">
	                <input type="text" class="form-control" id="email" name="company_email" value="<?php echo $general['company_email'];?>">
	              </div>
	            </li>
            <li class="form-group row">
              <label class="control-label col-xs-3" for="company-address">Address</label>
              <div class="col-xs-9">
                <textarea class="form-control" rows="5" id="company-address" name="company_address"><?php echo $general['company_address'];?></textarea class="form-control">  
              </div>
            </li>
            <li class="form-group row">
              <label class="control-label col-xs-3" for="color">Country</label>
              <div class="col-xs-9">  
                <select name="company_country" class="form-control" id="company_country">
                  <option value=""></option>
                  <option value="AF">Afghanistan</option>
                  <option value="AL">Albania</option>
                  <option value="DZ">Algeria</option>
                  <option value="AS">American Samoa</option>
                  <option value="AD">Andorra</option>
                  <option value="AG">Angola</option>
                  <option value="AI">Anguilla</option>
                  <option value="AG">Antigua &amp; Barbuda</option>
                  <option value="AR">Argentina</option>
                  <option value="AA">Armenia</option>
                  <option value="AW">Aruba</option>
                  <option value="AU">Australia</option>
                  <option value="AT">Austria</option>
                  <option value="AZ">Azerbaijan</option>
                  <option value="BS">Bahamas</option>
                  <option value="BH">Bahrain</option>
                  <option value="BD">Bangladesh</option>
                  <option value="BB">Barbados</option>
                  <option value="BY">Belarus</option>
                  <option value="BE">Belgium</option>
                  <option value="BZ">Belize</option>
                  <option value="BJ">Benin</option>
                  <option value="BM">Bermuda</option>
                  <option value="BT">Bhutan</option>
                  <option value="BO">Bolivia</option>
                  <option value="BL">Bonaire</option>
                  <option value="BA">Bosnia &amp; Herzegovina</option>
                  <option value="BW">Botswana</option>
                  <option value="BR">Brazil</option>
                  <option value="BC">British Indian Ocean Ter</option>
                  <option value="BN">Brunei</option>
                  <option value="BG">Bulgaria</option>
                  <option value="BF">Burkina Faso</option>
                  <option value="BI">Burundi</option>
                  <option value="KH">Cambodia</option>
                  <option value="CM">Cameroon</option>
                  <option value="CA">Canada</option>
                  <option value="IC">Canary Islands</option>
                  <option value="CV">Cape Verde</option>
                  <option value="KY">Cayman Islands</option>
                  <option value="CF">Central African Republic</option>
                  <option value="TD">Chad</option>
                  <option value="CD">Channel Islands</option>
                  <option value="CL">Chile</option>
                  <option value="CN">China</option>
                  <option value="CO">Colombia</option>
                  <option value="CC">Comoros</option>
                  <option value="CG">Congo</option>
                  <option value="CK">Cook Islands</option>
                  <option value="CR">Costa Rica</option>
                  <option value="HR">Croatia</option>
                  <option value="CU">Cuba</option>
                  <option value="CB">Curacao</option>
                  <option value="CY">Cyprus</option>
                  <option value="CZ">Czech Republic</option>
                  <option value="DK">Denmark</option>
                  <option value="DJ">Djibouti</option>
                  <option value="DM">Dominica</option>
                  <option value="DO">Dominican Republic</option>
                  <option value="TM">East Timor</option>
                  <option value="EC">Ecuador</option>
                  <option value="EG">Egypt</option>
                  <option value="SV">El Salvador</option>
                  <option value="GQ">Equatorial Guinea</option>
                  <option value="ER">Eritrea</option>
                  <option value="EE">Estonia</option>
                  <option value="ET">Ethiopia</option>
                  <option value="FA">Falkland Islands</option>
                  <option value="FO">Faroe Islands</option>
                  <option value="FJ">Fiji Islands</option>
                  <option value="FI">Finland</option>
                  <option value="FR">France</option>
                  <option value="GF">French Guiana</option>
                  <option value="GA">Gabon</option>
                  <option value="GM">Gambia</option>
                  <option value="GE">Georgia</option>
                  <option value="DE">Germany</option>
                  <option value="GH">Ghana</option>
                  <option value="GI">Gibraltar</option>
                  <option value="GR">Greece</option>
                  <option value="GL">Greenland</option>
                  <option value="GD">Grenada</option>
                  <option value="GP">Guadeloupe</option>
                  <option value="GU">Guam</option>
                  <option value="GT">Guatemala</option>
                  <option value="GN">Guinea</option>
                  <option value="GW">Guinea-Bissau</option>
                  <option value="GY">Guyana</option>
                  <option value="HT">Haiti</option>
                  <option value="HW">Hawaii</option>
                  <option value="HN">Honduras</option>
                  <option value="HK">Hong Kong</option>
                  <option value="HU">Hungary</option>
                  <option value="IS">Iceland</option>
                  <option value="IN">India</option>
                  <option value="ID">Indonesia</option>
                  <option value="IA">Iran</option>
                  <option value="IQ">Iraq</option>
                  <option value="IR">Ireland</option>
                  <option value="IM">Isle of Man</option>
                  <option value="IL">Israel</option>
                  <option value="IT">Italy</option>
                  <option value="JM">Jamaica</option>
                  <option value="JP">Japan</option>
                  <option value="JE">Jersey</option>
                  <option value="JO">Jordan</option>
                  <option value="KZ">Kazakhstan</option>
                  <option value="KE">Kenya</option>
                  <option value="KI">Kiribati</option>
                  <option value="NK">Korea North</option>
                  <option value="KS">Korea South</option>
                  <option value="KW">Kuwait</option>
                  <option value="KG">Kyrgyzstan</option>
                  <option value="LA">Laos</option>
                  <option value="LV">Latvia</option>
                  <option value="LB">Lebanon</option>
                  <option value="LS">Lesotho</option>
                  <option value="LR">Liberia</option>
                  <option value="LY">Libya</option>
                  <option value="LI">Liechtenstein</option>
                  <option value="LT">Lithuania</option>
                  <option value="LU">Luxembourg</option>
                  <option value="MO">Macau</option>
                  <option value="MK">Macedonia</option>
                  <option value="MG">Madagascar</option>
                  <option value="MY">Malaysia</option>
                  <option value="MW">Malawi</option>
                  <option value="MV">Maldives</option>
                  <option value="ML">Mali</option>
                  <option value="MT">Malta</option>
                  <option value="MH">Marshall Islands</option>
                  <option value="MQ">Martinique</option>
                  <option value="MR">Mauritania</option>
                  <option value="MU">Mauritius</option>
                  <option value="ME">Mayotte</option>
                  <option value="MX">Mexico</option>
                  <option value="MD">Moldova</option>
                  <option value="MC">Monaco</option>
                  <option value="MN">Mongolia</option>
                  <option value="MS">Montserrat</option>
                  <option value="MA">Morocco</option>
                  <option value="MZ">Mozambique</option>
                  <option value="MM">Myanmar</option>
                  <option value="NA">Nambia</option>
                  <option value="NU">Nauru</option>
                  <option value="NP">Nepal</option>
                  <option value="AN">Netherland Antilles</option>
                  <option value="NL">Netherlands, The</option>
                  <option value="NV">Nevis</option>
                  <option value="NC">New Caledonia</option>
                  <option value="NZ">New Zealand</option>
                  <option value="NI">Nicaragua</option>
                  <option value="NE">Niger</option>
                  <option value="NG">Nigeria</option>
                  <option value="NW">Niue Islands</option>
                  <option value="NO">Norway</option>
                  <option value="OM">Oman</option>
                  <option value="PK">Pakistan</option>
                  <option value="PA">Panama</option>
                  <option value="PG">Papua New Guinea</option>
                  <option value="PY">Paraguay</option>
                  <option value="PE">Peru</option>
                  <option value="PH">Philippines</option>
                  <option value="PL">Poland</option>
                  <option value="PT">Portugal</option>
                  <option value="QA">Qatar</option>
                  <option value="RE">Reunion</option>
                  <option value="RO">Romania</option>
                  <option value="RU">Russia</option>
                  <option value="RW">Rwanda</option>
                  <option value="NT">St. Barthelemy</option>
                  <option value="EU">St. Eustatius</option>
                  <option value="KN">St. Kitts-Nevis</option>
                  <option value="LC">St. Lucia</option>
                  <option value="MB">St. Maarten</option>
                  <option value="VC">St. Vincent</option>
                  <option value="SP">Saipan</option>
                  <option value="ST">Sao Tome &amp; Principe</option>
                  <option value="SA">Saudi Arabia</option>
                  <option value="SN">Senegal</option>
                  <option value="SC">Seychelles</option>
                  <option value="SL">Sierra Leone</option>
                  <option value="SG">Singapore</option>
                  <option value="SK">Slovakia</option>
                  <option value="SI">Slovenia</option>
                  <option value="SB">Solomon Islands</option>
                  <option value="OI">Somalia</option>
                  <option value="ZA">South Africa</option>
                  <option value="ES">Spain</option>
                  <option value="LK">Sri Lanka</option>
                  <option value="SD">Sudan</option>
                  <option value="SR">Suriname</option>
                  <option value="SZ">Swaziland</option>
                  <option value="SE">Sweden</option>
                  <option value="CH">Switzerland</option>
                  <option value="SY">Syria</option>
                  <option value="TA">Tahiti</option>
                  <option value="TW">Taiwan</option>
                  <option value="TJ">Tajikistan</option>
                  <option value="TZ">Tanzania</option>
                  <option value="TH">Thailand</option>
                  <option value="TG">Togo</option>
                  <option value="TK">Tokelau</option>
                  <option value="TO">Tonga</option>
                  <option value="TT">Trinidad &amp; Tobago</option>
                  <option value="TN">Tunisia</option>
                  <option value="TR">Turkey</option>
                  <option value="TU">Turkmenistan</option>
                  <option value="TC">Turks &amp; Caicos Islands</option>
                  <option value="TV">Tuvalu</option>
                  <option value="UG">Uganda</option>
                  <option value="UA">Ukraine</option>
                  <option value="AE">United Arab Emirates</option>
                  <option value="GB">United Kingdom</option>
                  <option value="US">United States of America</option>
                  <option value="UY">Uruguay</option>
                  <option value="UZ">Uzbekistan</option>
                  <option value="VU">Vanuatu</option>
                  <option value="VE">Venezuela</option>
                  <option value="VN">Vietnam</option>
                  <option value="VB">Virgin Islands (Brit)</option>
                  <option value="VA">Virgin Islands (USA)</option>
                  <option value="WS">Western Samoa</option>
                  <option value="WK">Wake Island</option>
                  <option value="YE">Yemen</option>
                  <option value="ZR">Zaire</option>
                  <option value="ZM">Zambia</option>
                  <option value="ZW">Zimbabwe</option>
                </select>
              </div>  
            </li>
            
            <li class="form-group row">
              <label class="control-label col-xs-3" for="province">Province</label>
              <div class="col-xs-9">
                <select class="form-control" name="company_province" id="company_province">
                    <option value=""></option>
                    <option value="Bali">Bali</option>
                    <option value="Bangka-Belitung">Bangka-Belitung</option>
                    <option value="Banten">Banten</option>
                    <option value="Bengkulu">Bengkulu</option>
                    <option value="DI Aceh">DI Aceh</option>
                    <option value="DI Yogyakarta">DI Yogyakarta</option>
                    <option value="DKI Jakarta">DKI Jakarta</option>
                    <option value="Gorontalo">Gorontalo</option>
                    <option value="Jambi">Jambi</option>
                    <option value="Jawa Barat">Jawa Barat</option>
                    <option value="Jawa Tengah">Jawa Tengah</option>
                    <option value="Jawa Timur">Jawa Timur</option>
                    <option value="Kalimantan Barat">Kalimantan Barat</option>
                    <option value="Kalimantan Selatan">Kalimantan Selatan</option>
                    <option value="Kalimantan Tengah">Kalimantan Tengah</option>
                    <option value="Kalimantan Timur">Kalimantan Timur</option>
                    <option value="Kepulauan Riau">Kepulauan Riau</option>
                    <option value="Lampung">Lampung</option>
                    <option value="Maluku">Maluku</option>
                    <option value="Maluku Utara">Maluku Utara</option>
                    <option value="Nusa Tenggara Barat">Nusa Tenggara Barat</option>
                    <option value="Nusa Tenggara Timur">Nusa Tenggara Timur</option>
                    <option value="Papua">Papua</option>
                    <option value="Papua Barat">Papua Barat</option>
                    <option value="Riau">Riau</option>
                    <option value="Sulawesi Barat">Sulawesi Barat</option>
                    <option value="Sulawesi Selatan">Sulawesi Selatan</option>
                    <option value="Sulawesi Tengah">Sulawesi Tengah</option>
                    <option value="Sulawesi Tenggara">Sulawesi Tenggara</option>
                    <option value="Sulawesi Utara">Sulawesi Utara</option>
                    <option value="Sumatera Barat">Sumatera Barat</option>
                    <option value="Sumatera Selatan">Sumatera Selatan</option>
                    <option value="Sumatera Utara">Sumatera Utara</option>
                </select>
              </div>
            </li>

            <script>
            $('#company_country option[value=<?php echo $general['company_country']?>]').attr('selected', 'selected');
            $('#company_province option[value=<?php echo $general['company_province']?>]').attr('selected', 'selected');
            </script>
            <li class="form-group row">
              <label class="control-label col-xs-3" for="city">City</label>
              <div class="col-xs-9">
                <input type="text" class="form-control" id="city" name="company_city" value="<?php echo $general['company_city'];?>">
              </div>
            </li>
            <li class="form-group row underlined">
              <label class="control-label col-xs-3" for="postal-code">Postal Code</label>
              <div class="col-xs-9">
                <input type="text" class="form-control" id="postal-code" name="company_postal_code" style="width: 150px" value="<?php echo $general['company_postal_code'];?>">
              </div>
            </li>
          </ul>
          <ul class="form-set">
            <li class="form-group row">
              <label class="control-label col-xs-3" for="facebook">Facebook</label>
              <div class="col-xs-9">
                <input type="text" class="form-control" id="facebook" name="company_facebook" placeholder="http://www.facebook.com/username" value="<?php echo $general['company_facebook'];?>">
              </div>
            </li>
            <li class="form-group row">
              <label class="control-label col-xs-3" for="twitter">Twitter</label>
              <div class="col-xs-9">
                <input type="text" class="form-control" id="twitter" name="company_twitter" placeholder="http://www.twitter.com/username" value="<?php echo $general['company_twitter'];?>">
              </div>
            </li>
			<li class="form-group row">
              <label class="control-label col-xs-3" for="instagram">Instagram</label>
              <div class="col-xs-9">
                <input type="text" class="form-control" id="twitter" name="company_instagram" placeholder="http://www.instagram.com/username" value="<?php echo $general['company_instagram'];?>">
              </div>
            </li>
          </ul>
        </div>
      </div><!--.box-->

      <div class="box row hidden">
        <div class="desc col-xs-3">
          <h3>Other Details</h3>
          <p>Details such as currency. </p>
        </div>
        <div class="content col-xs-9">
          <ul class="form-set">
            <li class="form-group row">
              <label class="control-label col-xs-3" for="rate">USD to IDR rate <span>*</span></label>
              <div class="col-xs-9">
                <input type="text" class="form-control" id="currency_rate" name="currency_rate" value="<?php echo $general['currency_rate'];?>">
              </div>
            </li>
          </ul>
        </div>
      </div><!--.box-->

  </div><!--.container.main-->

</form>

<script>
function openBrowser(){
   document.getElementById("color_files").click();
}


function readURL(input) {
      
   if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
	     $('#upload-image').removeClass("hidden");
		 $('#upload-image').attr('src', e.target.result);
	  }
	  
	  reader.readAsDataURL(input.files[0]);
   }
	  
}

function validation(){
   var name = $('#id_color_name').val();
   
   $('#lbl_color_name').removeClass('has-error');
   
   if(name == ''){
      $('#lbl_color_name').addClass('has-error');
   }else{
	  $('#btn-save').click();
   }
   
}
</script>

            
