<?php
/*
# ----------------------------------------------------------------------
# AJAX SHIPPING
# ----------------------------------------------------------------------
*/
include('../../custom/static/general.php');
include('../../static/general.php');



/*
# ----------------------------------------------------------------------
# FUNCTIONS
# ----------------------------------------------------------------------
*/

function count_shipping($courier, $status){
   $conn   = connDB();
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_courier WHERE `courier_name` = '$courier' AND `active_status` = '$status'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function get_shipping($courier, $status){
   $conn   = connDB();
   $sql    = "SELECT * FROM tbl_courier WHERE `courier_name` = '$courier' AND `active_status` = '$status'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function count_shipping_rate($country, $province){
   $conn   = connDB();
   $sql    = "SELECT * FROM tbl_courier_rate WHERE `courier_name` = '$courier' AND `active_status` = '$status'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
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