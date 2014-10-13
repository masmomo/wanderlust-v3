<?php
if(empty($_SESSION['user_id'])){
   include("account_/login.php");
}else{
?>

<?php
//reset_alert('btn_edit_shipping_details');

/* -- GET -- */
function get_country(){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM countries ORDER BY country_name ASC";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}

function generate_alias($post_user_fullname, $post_user_id){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_user WHERE `user_fullname` LIKE '$post_user_fullname' AND `user_id` = '$post_user_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query) or die(mysql_error());
   
   return $result;
}



/* -- UPDATE -- */
function update($post_user_first_name, $post_user_last_name, $post_user_fullname, $post_user_phone, $post_user_address, $post_user_country, $post_user_province, $post_user_city, $post_user_postal_code, $post_user_alias, $post_user_id){
   $conn  = connDB();
   
   $sql   = "UPDATE tbl_user SET `user_first_name` = '$post_user_first_name', 
                                 `user_last_name` = '$post_user_last_name',
								 `user_fullname` = '$post_user_fullname',
								 `user_phone` = '$post_user_phone',
								 `user_address` = '$post_user_address',
								 `user_country` = '$post_user_country',
								 `user_province` = '$post_user_province',
								 `user_city` = '$post_user_city',
								 `user_postal_code` = '$post_user_postal_code',
								 `user_alias` = '$post_user_alias'
             WHERE `user_id` = '$post_user_id'
	        ";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}



/* -- CONTROL -- */
$get_country = get_country();

if(isset($_POST['btn_edit_shipping_details'])){
   // DEFINED VALUE
   $user_first_name    = clean_alphabet($_POST['user_first_name']);
   $user_last_name     = clean_alphabet($_POST['user_last_name']);
   $post_user_fullname = $user_first_name." ".$user_last_name;
   $user_phone         = clean_number($_POST['user_phone']);
   $user_address       = $_POST['user_address'];
   $user_country       = $_POST['user_country'];
   $user_province      = $_POST['user_province'];
   $user_city          = $_POST['user_city'];
   $user_postal_code   = clean_number($_POST['user_postal_code']);
   
   // CALL FUNCTION
   $validate = generate_alias($post_user_fullname, $global_user['user_id']);
   
   if($validate['rows'] > 0){
      $user_alias = $global_user['user_alias'];
   }else{
      $user_alias = cleanurl($post_user_fullname.$validate['rows']);
   }
   
   update($user_first_name, $user_last_name, $post_user_fullname, $user_phone, $user_address, $user_country, $user_province, $user_city, $user_postal_code, $user_alias, $global_user['user_id']);
   
   $_SESSION['alert'] = "alert-success";
   $_SESSION['msg']   = "Changes has been successfully saved";
}
?>

<div class="container main">
  <div class="content">

      <ul class="breadcrumb" style="border-bottom: 1px solid #eee">
        <li><a href="<?php echo $prefix_url."account/".md5($global_user['user_alias']);?>">Account</a></li>
        <li class="active">Edit Account Details</li>
      </ul>

      <div class="row">

        <ul class="list-group col-xs-4 visible-md visible-lg">
          <li class="list-group-item active">Address 1</li>
        </ul>

        <div class="col-xs-12 col-md-8">
          
		  <?php 
		  /* --- ALERT --- */
		  if(isset($_SESSION['alert'])){
		     echo '<div class="alert '.$_SESSION['alert'].'" style="margin-top: 15px">';
			 echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
			 echo '<p>'.$_SESSION['msg'].'</p>';
			 echo '</div>'; 
		  }
		  
		  if($_POST['btn_edit_shipping_details'] == ''){
		     unset($_SESSION['alert']);
			 unset($_SESSION['msg']);
		  }
		  ?>
          
          <form method="post" class="form-horizontal" autocomplete="off">
            <fieldset>
              <h1>Shipping Details</h1>
              <div class="form-group" id="lbl_address_fname">
                <label class="col-md-3 control-label">First Name</label>
                <div class="col-md-9">
                  <input type="text" class="form-control w50" value="<?php echo $global_user['user_first_name']?>" id="address_fname" name="user_first_name">
                </div>
              </div>
              <div class="form-group" id="lbl_address_lname">
                <label class="col-md-3 control-label">Last Name</label>
                <div class="col-md-9">
                  <input type="text" class="form-control w50" value="<?php echo $global_user['user_last_name']?>" id="address_lname" name="user_last_name">
                </div>
              </div>
              <div class="form-group" id="lbl_address_phone">
                <label class="col-md-3 control-label">Phone</label>
                <div class="col-md-9">
                  <input type="text" class="form-control w50" value="<?php echo $global_user['user_phone']?>" id="address_phone" name="user_phone">
                </div>
              </div>
              <div class="form-group" id="lbl_address_address">
                <label class="col-md-3 control-label">Address</label>
                <div class="col-md-9">
                  <textarea rows="4" class="form-control" id="address_address" name="user_address"><?php echo $global_user['user_address']?></textarea>
                </div>
              </div>
              <div class="form-group" id="lbl_address_country">
                <label class="col-md-3 control-label">Country</label>
                <div class="col-md-9">
                  <select class="form-control" id="address_country" name="user_country" onChange="ajaxProvince()">
                    <?php
					foreach($get_country as $get_country){
					   
					   /* -- ALL COUNTRY -- */
					   //echo "<option value=\"".$get_country['country_name']."\">".$get_country['country_name']."</option>";
					   
					   /* -- INDONESIA ONLY -- */
					   echo "<option";
					   if($get_country['country_name'] != 'Indonesia'){
					      echo "disabled=\"disabled\"";
					   }
					   echo " value=\"".$get_country['country_name']."\">".$get_country['country_name']."</option>";
					}
					?>
                  </select>
                </div>
                
                <input type="text" name="user_country" id="hidden_user_country" class="hidden"  value="<?php echo $global_user['user_country'];?>">
              </div>
              
              <div class="form-group" id="lbl_address_province">
                <label class="col-md-3 control-label">Province</label>
                <div class="col-md-9">
                
                  <div id="ajax_province">
                  </div>
                  
                </div>
   				<input type="text" name="user_province" id="hidden_user_province" value="<?php echo $global_user['user_province'];?>" class="hidden" >
              </div>
              
              <div class="form-group" id="lbl_address_city">
                <label class="col-md-3 control-label">City</label>
                <div class="col-md-9">
				  	<div id="ajax_city" class="hidden">
	                  </div>

	                  <div id="initial_city">
	                  <?php
	                  if(!empty($global_user['user_province'])){

					     function get_city($post_courier_province){
							$conn  = connDB();

							$sql   = "SELECT * FROM tbl_courier_rate WHERE `courier_province` = '$post_courier_province' GROUP BY `courier_city` ORDER BY courier_city ASC";
							$query = mysql_query($sql, $conn);
							$row   = array();

							while($result = mysql_fetch_array($query)){
							   array_push($row, $result);
							}

							return $row;
						 }

						 $city = get_city($global_user['user_province']);

						 echo "<select  class=\"form-control w50\" id=\"address_city\" onChange=\"getCity()\">";

						 foreach($city as $city){
							echo "<option value=\"".$city['courier_city']."\">".$city['courier_city']."</option>";
						 }

						 echo "</select>";
					  }
					  ?>
					  </div>
					
                  <!--<input type="text" class="form-control w50">-->
                </div>
				<input type="text" name="user_city" id="hidden_user_city" class="hidden" value="<?php echo $global_user['user_city'];?>">
              </div>
              <div class="form-group" id="lbl_address_postal">
                <label class="col-md-3 control-label">Postal Code</label>
                <div class="col-md-9">
                  <input type="text" class="form-control w25" id="address_postal" value="<?php echo $global_user['user_postal_code'];?>" name="user_postal_code">
                </div>
              </div>
            </fieldset>
			<button type="button" class="btn btn-primary pull-right" onClick="validateShippingAddress()">Save Changes</button>
            <input type="submit" name="btn_edit_shipping_details" value="save" class="hidden" id="id_btn_edit_shipping_details">
            
            <a href="<?php echo $prefix_url."account/".md5($global_user['user_alias']);?>" class="btn btn-default pull-right">Back</a>
          </form>

        </div>

      </div> <!--row-->

  </div><!--.content-->
</div><!--.container.main-->

<?php
   include("script/edit_address.php");
}
?>

