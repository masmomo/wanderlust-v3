<?php
include("../../admin/custom/static/general.php");
include("../../admin/static/general.php");

$province = $_POST['set'];

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

$city = get_city($province);

echo "<select  class=\"form-control\" id=\"address_city\" onChange=\"getCity()\" name=\"user_city\">";
foreach($city as $city){
   echo "<option value=\"".$city['courier_city']."\">".$city['courier_city']."</option>";
}
echo "</select>";
?>