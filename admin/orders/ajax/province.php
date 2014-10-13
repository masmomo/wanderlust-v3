<?php
/*
# ----------------------------------------------------------------------
# AJAX PROVINCE
# ----------------------------------------------------------------------
*/
include('../../custom/static/general.php');
include('../../static/general.php');



/*
# ----------------------------------------------------------------------
# FUNCTIONS
# ----------------------------------------------------------------------
*/

function count_province($country){
   $conn   = connDB();
   $sql    = "SELECT COUNT(*) AS rows FROM province WHERE `country_id` = '$country' ORDER BY `province_name` ASC";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function get_province($country){
   $conn   = connDB();
   $sql    = "SELECT * FROM province WHERE `country_id` = '$country' ORDER BY `province_name` ASC";
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

$country = $_POST['country'];



/*
# ----------------------------------------------------------------------
# CALL FUNCTIONS
# ----------------------------------------------------------------------
*/

$count_province = count_province($country);
$data_province  = get_province($country);



/*
# ----------------------------------------------------------------------
# CONTROL
# ----------------------------------------------------------------------
*/

if($count_province['rows'] > 0){
   
   foreach($data_province as $data_province){
      echo '<option value="'.$data_province['province_name'].'">'.$data_province['province_name'].'</option>';
   }
   
}else{
   echo '0';
}
?>