<?php
function get_user($post_user_fullname){
   $sql    = "SELECT * FROM tbl_user WHERE `user_fullname` = '$post_user_fullname'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query); //or die("Query failed : ".mysql_error());
}


function countUser($post_user_fullname){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_user WHERE `user_fullname` = '$post_user_fullname'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function validate_email($post_user_email){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_user WHERE `user_email` = '$post_user_email'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function getCountry(){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM countries ORDER BY country_name ASC";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}

function getProvince(){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM province WHERE `country_id` = 'Indonesia'";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}


function getCities(){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM countries AS country INNER JOIN  cities AS city ON country.id = city.country_id ORDER BY city_name ASC";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}
?>