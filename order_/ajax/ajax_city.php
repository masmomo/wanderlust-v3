<?php
include("../../admin/custom/static/general.php");
include("../../admin/static/general.php");

// FUNCTIONS
function get_city($post_province){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM cities WHERE `province` = '$post_province' ORDER BY `city_name`";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
   
}


// DEFINED VARIABLE
$ajx_province = $_POST['province'];


// CALL FUNCTIONS
$city = get_city($ajx_province);


// DATA

echo "<select class=\"form-control\" id=\"id_checkout_user_city\" onChange=\"ajaxCourier()\" name=\"checkout_user_city\"> \n";
//echo "<option></option>";
foreach($city as $city ){
   echo "   <option value=\"".$city ['city_name']."\"";
   if($city ['courier_province'] == "Jakarta"){
      echo "selected";
   }
   echo ">".$city['city_name']."</option> \n";
}
echo "</select>";
?>