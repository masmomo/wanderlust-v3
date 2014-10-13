<?php
/*
# ----------------------------------------------------------------------
# AJAX CITY
# ----------------------------------------------------------------------
*/
include('../../custom/static/general.php');
include('../../static/general.php');



/*
# ----------------------------------------------------------------------
# FUNCTIONS
# ----------------------------------------------------------------------
*/

function count_city($country, $province){
   $conn   = connDB();
   $sql    = "SELECT COUNT(*) AS rows FROM cities WHERE `country_id` = '$country' AND `province` = '$province' ORDER BY `city_name` ASC";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function get_city($country, $province){
   $conn   = connDB();
   $sql    = "SELECT * FROM cities WHERE `country_id` = '$country' AND `province` = '$province' ORDER BY `city_name` ASC";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}



/*
# ----------------------------------------------------------------------
# DEFINED VARIABLE
# ----------------------------------------------------------------------
*/

$country  = $_POST['country'];
$province = $_POST['province'];



/*
# ----------------------------------------------------------------------
# CALL FUNCTIONS
# ----------------------------------------------------------------------
*/

$count_city = count_city($country, $province);
$data_city  = get_city($country, $province);



/*
# ----------------------------------------------------------------------
# CONTROL
# ----------------------------------------------------------------------
*/

if($count_city['rows'] > 0){
   
   foreach($data_city as $data_city){
      echo '<option value="'.$data_city['city_name'].'">'.$data_city['city_name'].'</option>';
   }
   
}else{
   echo '0';
}
?>