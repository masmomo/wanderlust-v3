<?php
include("../../admin/custom/static/general.php");
include("../../admin/static/general.php");

$country = $_POST['country'];

if ($country=='Indonesia'){
	function get_province(){
   		$conn  = connDB();
   	
   		$sql   = "SELECT * FROM province ORDER BY province_name ASC";
   		$query = mysql_query($sql, $conn);
   		$row   = array();
   
   		while($result = mysql_fetch_array($query)){
      		array_push($row, $result);
   		}
   
   		return $row;
	}

	$province = get_province();

	?>
	
	<label class="col-md-3 control-label">Province</label>
	<div class="col-md-9">

		<div id="ajax_province">
	<?php
	echo "<select  class=\"form-control input-sm w50\" id=\"id_checkout_user_province\" onChange=\"ajaxCity()\" name=\"checkout_user_province\">";
	foreach($province as $province){
   		echo "<option value=\"".$province['province_name']."\">".$province['province_name']."</option>";
	}
	echo "</select>";
	?>
		</div>
	</div>
	<?php
}
else{
	echo "<input  type=\"text\" class=\"form-control input-sm w50\" id=\"address_province\" value=\"\"></input>";
}
?>


