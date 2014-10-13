<?php
function get_province(){
   $conn  = connDB();
   
   $sql   = "SELECT * FROM province ORDER BY `province_name`";
   $query = mysql_query($sql, $conn);
   $row   = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}

function get_city($post_province){
   $conn  = connDB();
   
   $sql   = "SELECT * FROM cities AS city INNER JOIN tbl_courier_rate as rate ON city.city_name = rate.courier_city
             WHERE `province` = '$post_province' AND `courier_name` = '1'
			";
   $query = mysql_query($sql, $conn);
   $row   = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}

function get_max_courier(){
   $conn   = connDB();
   
   $sql    = "SELECT MAX(courier_id) AS latest_id FROM tbl_courier";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function get_min_courier($post_courier_name){
   $conn   = connDB();
   
   $sql    = "SELECT MIN(courier_rate_id) AS latest_id FROM tbl_courier_rate where `courier_name` = '$post_courier_name'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function get_country(){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM countries ORDER BY `country_name`";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}
?>