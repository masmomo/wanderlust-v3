<?php
require_once("../../custom/static/general.php");

$province = $_POST['province'];

function get_city($post_province){
   $conn  = connDB();
   
   $sql   = "SELECT * FROM cities WHERE `province` = '$post_province'";
   $query = mysql_query($sql, $conn);
   $row   = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}

// CALL FUNCTION
$get_city = get_city($province);
?>

<select class="form-control" id="city" name="user_city" onchange="backupCity()">
   <?php
   foreach($get_city as $city){
      echo "<option value=\"".$city['city_name']."\">".$city['city_name']."</option>";
   }
   ?>
</select>