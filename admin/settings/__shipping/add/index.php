<?php
include("get.php");
include("update.php");
include("control.php");



//var_dump($_POST);
/*
$foreach_provinces  = $_POST['province_name'];
$foreach_city_names = $_POST['city_name'];
$price              = $_POST['array_rate'];
$weight             = $_POST['courier_weight'];

foreach($foreach_provinces as $provinces){
   $city = get_city($provinces);
   
   foreach($city as $key=>$city){
         echo "<br><b>".$provinces."</b>";
		 echo "<br> PROVINCES: ".$provinces."<br>".$city['city_name']."";
		 echo "<br> PRICE: IDR".$price[$key]."/".$weight."Kg";
		 echo "<br>";
   }
}

foreach($price as $price){
   echo "<br> PRICE: ".$price;
}


$foreach_provinces  = $_POST['province_name'];
$foreach_city_names = $_POST['city_name'];
$price              = $_POST['courier_rate'];
$weight             = $_POST['courier_weight'];

   foreach($foreach_provinces as $provinces){
      $city = get_city($provinces);
	  
	  foreach($city as $city){
         echo "<br><b>".$provinces."</b>";
		 echo "<br> PROVINCES: ".$provinces."<br>".$city['city_name']."";
		 echo "<br> PRICE (Key: ".$key."): IDR ".price($rate)."/".$weight."Kg";
		 echo "<br>";
		 
	  }
   }

//var_dump($_POST);

$rate = $_POST['courier_rate'];

foreach($rate as $as=>$rate){
   echo "<br> Key: ".$as." <br> Rate: IDR ".$rate;
}
*/

?>

<form method="post">

            <div class="sub-header clearfix">
                    <div class="content">
                        <h2>Add Shipping Method</h2>
                        <div class="btn-placeholder">
                            <a href="<?php echo $prefix_url."shipping";?>">
                            <input type="button" class="btn grey main" value="Cancel">
                            </a>
                            <input type="button" class="btn green main" value="Save Changes" onclick="validationAddShipping('save')">
                            <input type="button" class="btn green main" value="Save Changes &amp; Exit"  onclick="validationAddShipping('exit')">
                            
                            <input type="submit" class="btn green main hidden" value="Save Changes" name="btn-add-shipping" id="btn-save">
                            <input type="submit" class="btn green main hidden" value="Save Changes &amp; Exit" name="btn-add-shipping" id="btn-save-exit">
                        </div>
                    </div>
                </div>

            <div id="main-content">
            
                <?php 
				if(!empty($_SESSION['alert'])){
				   echo "<div class=\"content\">\n";
				   echo "   <div class=\"alert-message ".$_SESSION['alert']."\"><center>".$_SESSION['msg']."</center></div>";
				   echo "</div>";
				}
				
				if($_POST['btn-add-shipping']){
			       $_SESSION['alert'] = "";
				   $_SESSION['msg']   = ""; 
				}
				?>

                <div class="box clearfix">
                    <div class="desc">
                        <h3>Basic Details</h3>
                        <p>Basic details of your shipping method. </p>
                    </div>
                    <div class="content basic-details" >
                        <ul class="field-set">
                            <li class="field">
                                <label>Shipping Method <span>*</span></label>
                                <div id="inner-html-courier-name">
                                <input type="text" class="input-text" placeholder="e.g., JNE (Regular)" name="courier_name" id="id_courier_name">
                                </div>
                            </li>
                            <li class="field">
                                <label>Description <span>*</span></label>
                                <div id="inner-html-description">
                                <input type="text" class="input-text" placeholder="e.g., Regular Shipping (2-3 days delivery)" name="description" id="id_description">
                                </div>
                            </li>
                            <li class="field">
                                <label>Services <span>*</span></label>
                                <select class="input-select" id="id_service" name="courier_service" onchange="selectService()">
                                    <option value="0"></option>
                                    <option value="Local Only">Local only</option>
                                    <option value="International Only" disabled="disabled">International only</option>
                                    <option value="Local &amp; International" disabled="disabled">Local &amp; International</option>
                                </select>
                            </li>
                            <li class="field">
                                <label>Weight Counter <span>*</span></label>
                                <select class="input-select" name="courier_weight" id="id_courier_weight" onchange="perWeight()">
                                    <option></option>
                                    <option value="0.5">Every 0.5 kg</option>
                                    <option value="1">Every 1 kg</option>
                                    <option value="2">Every 2 kg</option>
                                </select>
                            </li>
                        </ul>
                    </div>
                </div><!--box-->

                <div class="box clearfix" id="local">
                    <div class="desc">
                        <h3>Local Shipping</h3>
                        <p>Details of local shipping.</p>
                    </div>
                    <div class="content">
                        <ul class="field-set">
                        
						<?php 
						$row = 0;
						foreach($provinces as $provinces){
						   $row++;
						   $city = get_city($provinces['province_name']);
						?>
                                
                            <li class="field field-checkbox" style="position: relative" id="courier-city-<?php echo $row;?>">
                                <label><?php echo $provinces['province_name']?></label>
                                <input type="checkbox" class="input-checkbox" value="<?php echo $provinces['province_name']?>" name="province_name[]" onclick="selectProvince('<?php echo $row;?>')" id="province-checked-<?php echo $row;?>" flag="unchecked" checked="checked">
                                
                                <div class="expander collapse"></div>
                                <div class="field-divider"></div>
                                <ul style="margin-bottom: 20px">
                                    
                                    <?php $san=0; foreach($city as $city){ $san++;?>
                                    
                                    <li class="field field-checkbox clearfix" onclick="selectCity('<?php echo $row;?>')">
                                        <div class="fl" style="width: 250px; padding-top: 5px">
                                            <label><?php echo $city['city_name'];?></label>
                                            <input type="checkbox" class="input-checkbox" value="<?php echo $city['city_name'];?>" style="top: 14px;" id="city-checkbox-<?php echo $row;?>-<?php echo $san;?>" name="city_name[]" attribute="attribute-<?php echo $row?>" province="<?php echo $city['city_name'];?>" checked="checked">
                                        </div>
                                        <div class="fr" style="width: 220px">
                                            <p class="fl" style="width: 30px; margin-right: 10px">IDR</p>
                                            <input type="text" name="courier_rate[]" class="input-text fl" style="width: 100px" placeholder="0" value="<?php //echo price($city['courier_rate']);?>" onfocus="focusCheckbox(<?php echo $row.", ".$san?>)" onkeyup="focusCheckbox(<?php echo $row.", ".$san?>)" id="courier_rate_<?php echo $row."_".$san?>">
                                            
                                            <div id="custom-shipping-<?php echo $row;?>">
                                            <input type="checkbox" name="array_rate[]" id="ck-rate-<?php echo $row;?>-<?php echo $san;?>" class="hidden" value="0">
                                            </div>
                                            <span class="custom-weight">
                                            <p class="fl" style="width: 60px; margin-left: 10px" id="per_weight"> / 1 kg</p>
                                            </span>
                                        </div>
                                    </li>
                                    
                                    <?php }?>
                                </ul>
                                <div class="field-divider"></div>
                            </li>
                        
						<?php }?>
                        </ul>
                    </div>
                </div><!--box-->
                
                <script>
				function selectProvince(i){
				   var flag = $('#province-checked-'+i).attr('flag');
				   var rate = $('#courier_rate_'+i).val();
				   
				   if(flag == "unchecked"){
				      $('#courier-city-'+i).find('[type=checkbox]').each(function() {
				         $(this).attr('checked', 'checked');
                      });
				   
				      $('#province-checked-'+i).attr('flag','checked');
					  $('#custom-shipping [type=checkbox]').val(rate);
				   }else if(flag == "checked"){
				      $('#courier-city-'+i).find(':checked').each(function() {
				         $(this).removeAttr('checked');
                      });
				   
				      $('#province-checked-'+i).attr('flag','unchecked');
					  
					  $('#custom-shipping [type=checkbox]').val('inactive');
				   }
				   
				}
				
				function selectCity(i){
				   var flag = $('#province-checked-'+i).attr('flag');
				   var rate = $('#courier_rate_'+i).val();
				   
				   if(flag != "checked"){ 
					  $('#province-checked-'+i).attr('checked', 'checked');
				      $('#province-checked-'+i).attr('flag', 'checked');
					  $('#custom-shipping-'+i+' [type=checkbox]').attr('checked','checked');
					  $('#custom-shipping [type=checkbox]').val(rate);
					  $('#city-checkbox-'+i).attr('checked','checked');
					  //$('[type=checkbox][name=][attribute=attribute-'+i+']').attr('checked','checked');
				   }
				}
				</script>

                <div class="box clearfix" id="international">
                    <div class="desc">
                        <h3>International Shipping</h3>
                        <p>Details of international shipping cost.</p>
                    </div>
                    <div class="content">
                        <ul class="field-set">
                            
                            <?php
                            $row = 0;
							foreach($country as $country){
							?>
                        
                            <li class="field field-checkbox clearfix">
                                <div class="fl" style="width: 250px; padding-top: 5px">
                                    <label><?php echo $country['country_name'];?></label>
                                    <input type="checkbox" checked="checked" class="input-checkbox"  style="top: 14px;" name="international_id[]" value="<?php echo $country['country_name'];?>" id="chk-<?php echo $row;?>">
                                </div>
                                <div class="fr" style="width: 220px">
                                    <p class="fl" style="width: 30px; margin-right: 10px">IDR</p>
                                    <input type="text" class="input-text fl" style="width: 100px" placeholder="0" onfocus="checkIt('<?php echo $row;?>')" name="international_rate[]" id="intl-rate-<?php echo $row;?>">
                                    
                                    <span class="custom-weight">
                                    <p class="fl" style="width: 60px; margin-left: 10px" id="per_weight"> / 0.5 kg</p>
                                    </span>
                                    
                                </div>
                            </li>
                            
                            <div class="field-divider"></div>
                            
                            <?php
							   $row++;
                            }
                            ?>
                            
                            <!--
                            <li class="field field-checkbox clearfix">
                                <div class="fl" style="width: 250px; padding-top: 5px">
                                    <label>Malaysia</label>
                                    <input type="checkbox" class="input-checkbox"  style="top: 14px;" name="international_id[]" value="Malaysia" id="chk-2">
                                </div>
                                <div class="fr" style="width: 220px">
                                    <p class="fl" style="width: 30px; margin-right: 10px">IDR</p>
                                    <input type="text" class="input-text fl" style="width: 100px" placeholder="0" onfocus="checkIt('malaysia')">
                                    
                                    <span class="custom-weight">
                                    <p class="fl" style="width: 60px; margin-left: 10px" id="per_weight"> / 0.5 kg</p>
                                    </span>
                                    
                                </div>
                            </li>
                            <div class="field-divider"></div>
                            <li class="field field-checkbox clearfix">
                                <div class="fl" style="width: 250px; padding-top: 5px">
                                    <label>United States of America</label>
                                    <input type="checkbox" class="input-checkbox"  style="top: 14px;" name="international_id[]" value="United States Of America" id="chk-3">
                                </div>
                                <div class="fr" style="width: 220px">
                                    <p class="fl" style="width: 30px; margin-right: 10px">IDR</p>
                                    <input type="text" class="input-text fl" style="width: 100px" placeholder="0" onfocus="checkIt('united-states-of-america')">
                                    
                                    <span class="custom-weight">
                                    <p class="fl" style="width: 60px; margin-left: 10px" id="per_weight"> / 0.5 kg</p>
                                    </span>
                                    
                                </div>
                            </li>
                            <div class="field-divider"></div>
                            <li class="field field-checkbox clearfix">
                                <div class="fl" style="width: 250px; padding-top: 5px">
                                    <label>United Kingdom</label>
                                    <input type="checkbox" class="input-checkbox"  style="top: 14px;" name="international_id[]" value="United Kingdom">
                                </div>
                                <div class="fr" style="width: 220px">
                                    <p class="fl" style="width: 30px; margin-right: 10px">IDR</p>
                                    <input type="text" class="input-text fl" style="width: 100px" placeholder="0">
                                    
                                    <span class="custom-weight">
                                    <p class="fl" style="width: 60px; margin-left: 10px" id="per_weight"> / 0.5 kg</p>
                                    </span>
                                    
                                </div>
                            </li>
                            <div class="field-divider"></div>
                            <li class="field field-checkbox clearfix">
                                <div class="fl" style="width: 250px; padding-top: 5px">
                                    <label>Cambodia</label>
                                    <input type="checkbox" class="input-checkbox"  style="top: 14px;" name="international_id[]" value="Cambodia">
                                </div>
                                <div class="fr" style="width: 220px">
                                    <p class="fl" style="width: 30px; margin-right: 10px">IDR</p>
                                    <input type="text" class="input-text fl" style="width: 100px" placeholder="0">
                                    
                                    <span class="custom-weight">
                                    <p class="fl" style="width: 60px; margin-left: 10px" id="per_weight"> / 0.5 kg</p>
                                    </span>
                                    
                                </div>
                            </li>
                            <div class="field-divider"></div>
                            <li class="field field-checkbox clearfix">
                                <div class="fl" style="width: 250px; padding-top: 5px">
                                    <label>Rest of the World</label>
                                    <input type="checkbox" class="input-checkbox"  style="top: 14px;" name="international_id[]" value="Rest of the World">
                                </div>
                                <div class="fr" style="width: 220px">
                                    <p class="fl" style="width: 30px; margin-right: 10px">IDR</p>
                                    <input type="text" class="input-text fl" style="width: 100px" placeholder="0">
                                    
                                    <span class="custom-weight">
                                    <p class="fl" style="width: 60px; margin-left: 10px" id="per_weight"> / 0.5 kg</p>
                                    </span>
                                    
                                </div>
                            </li>
                            <div class="field-divider"></div>
                            -->
                        </ul>
                    </div>
                </div><!--box-->
                

            </div><!--main-content-->
</form>



<script>
$('#international').hide();
$('#local').hide();


function selectService(){
   var service = $('#id_service option:selected').val();

   if(service == "International Only"){
      $('#local').slideUp("slow");
      $('#international').slideDown("slow");
	  $('#international input[type=checkbox]').each(function () {
	     //$(this).attr('checked', 'checked');
		 $('#local input[type=checkbox]').attr('checked', false);
		 //$('#international input[type=checkbox]').attr('checked', false);
	  });
	  
	  $('#international input[type=text]').each(function () {
	     //$(this).attr('checked', 'checked');
		 $('#local input[type=text]').attr('disabled', 'disabled');
	  });
	  
   }else if(service == "Local Only"){
      $('#international').slideUp("slow");
      $('#local').slideDown("slow");
	  $('#local input[type=checkbox]').each(function () {
	     //$(this).attr('checked', 'checked');
	  });
   }else if(service == "Local & International"){
      $('#international').slideDown("slow");
      $('#local').slideDown("slow");
   }else{
      $('#international').slideUp("slow");
      $('#local').slideUp("slow");
   }
   
}

function validationAddShipping(i){
   var cname   = $('#id_courier_name').val();
   var note    = $('#id_description').val();
   var service = $('#id_service option:selected').val();
   
   $('#id_courier_name').removeClass('empty');
   $('#id_description').removeClass('empty');
   $('#id_service').removeClass('empty');
   
   if(cname == ""){
      $('#id_courier_name').addClass('empty').attr('placeholder', 'Required');
	  location.href = "http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."#id_courier_name";?>";
   }else if(note == ""){
      $('#id_description').addClass('empty').attr('placeholder', 'Required');
	  location.href = "http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."#id_description";?>";
   }else if(service == 0){  
      $('#id_service').addClass('empty');
	  location.href = "http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."#id_service";?>";
   }else if(i == "save"){
      $('#btn-save').click();
   }else if(i == "exit"){
      $('btn-save-exit').click();
   }
   
   //alert(note);
   
}

function focusCheckbox(i, x){
   //$('[type=checkbox][name='+i+']').attr('checked', 'checked');
   $('#city-checkbox-'+i+'-'+x).attr('checked', 'checked');
   
   var source = $('#courier_rate_'+i+'_'+x).val();
   
   $('#ck-rate-'+i+'-'+x).val(source);
   //alert(source);
}

function perWeight(){
   var weight  = $('#id_courier_weight option:selected').val();
   
   $('.custom-weight').find('p').each(function() {
      $('p#per_weight').text("/ "+weight+" kg"); 
   });
}

function checkIt(i){
   $('#chk-'+i).attr('checked', true);
}

function intl(i){
   $('#international li').click(function(){
      $('input[type=checkbox]#chk-'+i).attr('checked', true);
	  $('int-rate-'+i).val('0');
   });
}

$(document).ready(function(e) {
    intl();
});
</script>

           