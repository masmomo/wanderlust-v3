<?php
$ship_id = $_REQUEST['sid'];

function get_detail($post_courier_name){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_courier WHERE courier_id = '$post_courier_name'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function get_shipping($post_courier_name){
   $conn   = connDB();
   
   /*
   $sql    = "SELECT * FROM tbl_courier AS courier INNER JOIN tbl_courier_rate AS rate ON courier.courier_id = rate.courier_name
              WHERE rate.courier_name = '$post_courier_name'
			  ORDER BY courier_province
			 ";
   */
   $sql    = "SELECT * FROM cities GROUP BY `province`";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}

function get_city($post_courier_province, $post_courier_name){
   $conn  = connDB();
   
   $sql   = "SELECT * FROM tbl_courier_rate WHERE `courier_province` = '$post_courier_province' AND `courier_name` = '$post_courier_name'
			";
   $query = mysql_query($sql, $conn);
   $row   = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}

function international($post_courier_name){
   $conn  = connDB();
   
   $sql   = "SELECT * FROM tbl_courier_rate WHERE `courier_province` = 'international' AND `courier_name` = '$post_courier_name' ORDER BY `courier_city` ASC";
   $query = mysql_query($sql, $conn);
   $row   = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
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