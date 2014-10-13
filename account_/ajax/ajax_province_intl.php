<?php
include("../../admin/custom/static/general.php");
include("../../admin/static/general.php");

$country = $_POST['country'];


?>

<label class="col-md-3 control-label">City/State</label>
<div class="col-md-9">
  
	<div id="ajax_province">
		<input  type="text" name="user_province" class="form-control input-sm w50" id="address_province" value=""></input>
    </div>
</div>
<input type="text"  id="hidden_user_province" value="<?php echo $global_user['user_province'];?>" class="hidden">